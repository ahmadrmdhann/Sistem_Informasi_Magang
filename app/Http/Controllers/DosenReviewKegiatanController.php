<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogModel;
use App\Models\ActivityReviewModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\PengajuanMagangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DosenReviewKegiatanController extends Controller
{
    /**
     * Display the activity review dashboard for dosen.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        // Get filter parameters
        $statusFilter = $request->get('status', 'pending');
        $mahasiswaFilter = $request->get('mahasiswa_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Get supervised students
        $supervisedStudents = MahasiswaModel::whereHas('PengajuanMagang', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        })->with('user')->get();

        // Build query for activities
        $activitiesQuery = ActivityLogModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'latestReview',
            'attachments'
        ])->where('dosen_id', $dosen->dosen_id);

        // Apply filters
        if ($statusFilter !== 'all') {
            $activitiesQuery->where('status', $statusFilter);
        }

        if ($mahasiswaFilter) {
            $activitiesQuery->where('mahasiswa_id', $mahasiswaFilter);
        }

        if ($dateFrom) {
            $activitiesQuery->where('activity_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $activitiesQuery->where('activity_date', '<=', $dateTo);
        }

        $activities = $activitiesQuery->orderBy('submitted_at', 'desc')
            ->orderBy('activity_date', 'desc')
            ->paginate(15);

        // Get statistics
        $stats = [
            'total' => ActivityLogModel::where('dosen_id', $dosen->dosen_id)->count(),
            'pending' => ActivityLogModel::where('dosen_id', $dosen->dosen_id)->where('status', 'pending')->count(),
            'approved' => ActivityLogModel::where('dosen_id', $dosen->dosen_id)->where('status', 'approved')->count(),
            'needs_revision' => ActivityLogModel::where('dosen_id', $dosen->dosen_id)->where('status', 'needs_revision')->count(),
            'rejected' => ActivityLogModel::where('dosen_id', $dosen->dosen_id)->where('status', 'rejected')->count(),
        ];

        return view('dashboard.dosen.review-kegiatan.index', compact(
            'activities',
            'supervisedStudents',
            'stats',
            'statusFilter',
            'mahasiswaFilter',
            'dateFrom',
            'dateTo',
            'dosen'
        ));
    }

    /**
     * Display the specified activity for review.
     */
    public function show($id)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        $activity = ActivityLogModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'reviews.dosen.user',
            'attachments'
        ])
        ->where('dosen_id', $dosen->dosen_id)
        ->findOrFail($id);

        return view('dashboard.dosen.review-kegiatan.show', compact('activity', 'dosen'));
    }

    /**
     * Show the review form for the specified activity.
     */
    public function review($id)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        $activity = ActivityLogModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'attachments'
        ])
        ->where('dosen_id', $dosen->dosen_id)
        ->findOrFail($id);

        // Check if activity can be reviewed
        if ($activity->status !== 'pending') {
            return redirect()->route('dosen.review-kegiatan.show', $id)
                ->with('error', 'Kegiatan ini sudah direview atau tidak dalam status pending.');
        }

        return view('dashboard.dosen.review-kegiatan.review', compact('activity', 'dosen'));
    }

    /**
     * Store the review for the specified activity.
     */
    public function storeReview(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        $activity = ActivityLogModel::where('dosen_id', $dosen->dosen_id)
            ->findOrFail($id);

        // Check if activity can be reviewed
        if ($activity->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan ini sudah direview atau tidak dalam status pending.'
            ], 400);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'review_status' => 'required|in:approved,needs_revision,rejected',
            'feedback_comment' => 'required|string|min:10',
            'rating' => 'nullable|integer|min:1|max:5',
            'suggestions' => 'nullable|string',
        ], [
            'review_status.required' => 'Status review harus dipilih.',
            'review_status.in' => 'Status review tidak valid.',
            'feedback_comment.required' => 'Komentar feedback harus diisi.',
            'feedback_comment.min' => 'Komentar feedback minimal 10 karakter.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update activity status
            $activity->update([
                'status' => $request->review_status,
                'reviewed_at' => now(),
            ]);

            // Create review record
            ActivityReviewModel::create([
                'activity_id' => $activity->activity_id,
                'dosen_id' => $dosen->dosen_id,
                'review_status' => $request->review_status,
                'feedback_comment' => $request->feedback_comment,
                'rating' => $request->rating,
                'suggestions' => $request->suggestions,
                'reviewed_at' => now(),
                'is_final_review' => true,
            ]);

            DB::commit();

            $statusText = match($request->review_status) {
                'approved' => 'disetujui',
                'needs_revision' => 'perlu revisi',
                'rejected' => 'ditolak',
            };

            return response()->json([
                'success' => true,
                'message' => "Kegiatan berhasil {$statusText}.",
                'redirect_url' => route('dosen.review-kegiatan.index')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan review.'
            ], 500);
        }
    }

    /**
     * Get student progress summary.
     */
    public function studentProgress($mahasiswaId)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        // Verify this student is supervised by this dosen
        $mahasiswa = MahasiswaModel::whereHas('PengajuanMagang', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        })->with('user')->findOrFail($mahasiswaId);

        // Get activities with reviews
        $activities = ActivityLogModel::with(['latestReview', 'attachments'])
            ->where('mahasiswa_id', $mahasiswaId)
            ->where('dosen_id', $dosen->dosen_id)
            ->orderBy('activity_date', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total_activities' => $activities->count(),
            'approved' => $activities->where('status', 'approved')->count(),
            'pending' => $activities->where('status', 'pending')->count(),
            'needs_revision' => $activities->where('status', 'needs_revision')->count(),
            'rejected' => $activities->where('status', 'rejected')->count(),
            'average_rating' => $activities->whereNotNull('latestReview.rating')->avg('latestReview.rating'),
            'total_hours' => $activities->sum(function ($activity) {
                if ($activity->start_time && $activity->end_time) {
                    $start = \Carbon\Carbon::parse($activity->start_time);
                    $end = \Carbon\Carbon::parse($activity->end_time);
                    return $start->diffInHours($end);
                }
                return 0;
            }),
        ];

        return view('dashboard.dosen.review-kegiatan.student-progress', compact(
            'mahasiswa',
            'activities',
            'stats',
            'dosen'
        ));
    }

    /**
     * Generate activity summary report.
     */
    public function generateReport(Request $request)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        $mahasiswaId = $request->get('mahasiswa_id');

        // Build query
        $activitiesQuery = ActivityLogModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'latestReview'
        ])->where('dosen_id', $dosen->dosen_id)
          ->whereBetween('activity_date', [$dateFrom, $dateTo]);

        if ($mahasiswaId) {
            $activitiesQuery->where('mahasiswa_id', $mahasiswaId);
        }

        $activities = $activitiesQuery->orderBy('activity_date', 'desc')->get();

        // Get supervised students for filter
        $supervisedStudents = MahasiswaModel::whereHas('PengajuanMagang', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        })->with('user')->get();

        return view('dashboard.dosen.review-kegiatan.report', compact(
            'activities',
            'supervisedStudents',
            'dateFrom',
            'dateTo',
            'mahasiswaId',
            'dosen'
        ));
    }
}
