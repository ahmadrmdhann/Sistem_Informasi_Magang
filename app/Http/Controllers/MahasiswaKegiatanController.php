<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogModel;
use App\Models\ActivityAttachmentModel;
use App\Models\PengajuanMagangModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MahasiswaKegiatanController extends Controller
{
    /**
     * Display the activity logging dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        // Get student's accepted internships
        $internships = PengajuanMagangModel::with(['lowongan.partner', 'dosen'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->where('status', 'diterima')
            ->get();

        // Get filter parameters
        $selectedInternship = $request->get('internship_id');
        $statusFilter = $request->get('status', 'all');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Build query for activities
        $activitiesQuery = ActivityLogModel::with(['pengajuan.lowongan.partner', 'dosen', 'latestReview', 'attachments'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id);

        // Apply filters
        if ($selectedInternship) {
            $activitiesQuery->where('pengajuan_id', $selectedInternship);
        }

        if ($statusFilter !== 'all') {
            $activitiesQuery->where('status', $statusFilter);
        }

        if ($dateFrom) {
            $activitiesQuery->where('activity_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $activitiesQuery->where('activity_date', '<=', $dateTo);
        }

        $activities = $activitiesQuery->orderBy('activity_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get statistics
        $stats = [
            'total' => ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->count(),
            'pending' => ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'pending')->count(),
            'approved' => ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'approved')->count(),
            'needs_revision' => ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'needs_revision')->count(),
            'rejected' => ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'rejected')->count(),
        ];

        return view('dashboard.mahasiswa.kegiatan.index', compact(
            'activities', 
            'internships', 
            'stats', 
            'selectedInternship', 
            'statusFilter', 
            'dateFrom', 
            'dateTo',
            'mahasiswa'
        ));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        // Get student's accepted internships
        $internships = PengajuanMagangModel::with(['lowongan.partner', 'dosen'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->where('status', 'diterima')
            ->get();

        if ($internships->isEmpty()) {
            return redirect()->route('mahasiswa.kegiatan.index')
                ->with('error', 'Anda belum memiliki magang yang diterima untuk mencatat kegiatan.');
        }

        // Pre-select internship if provided
        $selectedInternship = $request->get('internship_id');

        return view('dashboard.mahasiswa.kegiatan.create', compact('internships', 'selectedInternship', 'mahasiswa'));
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        // Validation rules
        $validator = Validator::make($request->all(), [
            'pengajuan_id' => 'required|exists:m_pengajuan_magang,id',
            'activity_date' => 'required|date|before_or_equal:today',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'activity_title' => 'required|string|max:255',
            'activity_description' => 'required|string|min:50',
            'learning_objectives' => 'nullable|string',
            'challenges_faced' => 'nullable|string',
            'solutions_applied' => 'nullable|string',
            'is_weekly_summary' => 'boolean',
            'week_start_date' => 'nullable|date|required_if:is_weekly_summary,true',
            'week_end_date' => 'nullable|date|after_or_equal:week_start_date|required_if:is_weekly_summary,true',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx',
        ], [
            'pengajuan_id.required' => 'Pilih pengalaman magang.',
            'pengajuan_id.exists' => 'Pengalaman magang tidak valid.',
            'activity_date.required' => 'Tanggal kegiatan harus diisi.',
            'activity_date.before_or_equal' => 'Tanggal kegiatan tidak boleh di masa depan.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            'activity_title.required' => 'Judul kegiatan harus diisi.',
            'activity_description.required' => 'Deskripsi kegiatan harus diisi.',
            'activity_description.min' => 'Deskripsi kegiatan minimal 50 karakter.',
            'attachments.*.max' => 'Ukuran file maksimal 10MB.',
            'attachments.*.mimes' => 'Format file tidak didukung.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify internship belongs to this student
        $pengajuan = PengajuanMagangModel::where('id', $request->pengajuan_id)
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->where('status', 'diterima')
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // Create activity log
            $activity = ActivityLogModel::create([
                'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                'pengajuan_id' => $request->pengajuan_id,
                'dosen_id' => $pengajuan->dosen_id,
                'activity_date' => $request->activity_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'activity_title' => $request->activity_title,
                'activity_description' => $request->activity_description,
                'learning_objectives' => $request->learning_objectives,
                'challenges_faced' => $request->challenges_faced,
                'solutions_applied' => $request->solutions_applied,
                'is_weekly_summary' => $request->boolean('is_weekly_summary'),
                'week_start_date' => $request->week_start_date,
                'week_end_date' => $request->week_end_date,
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            // Handle file attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $index => $file) {
                    $this->storeAttachment($activity->activity_id, $file, $index === 0);
                }
            }

            DB::commit();

            return redirect()->route('mahasiswa.kegiatan.index')
                ->with('success', 'Kegiatan berhasil dicatat dan dikirim untuk review.');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan kegiatan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Display the specified activity.
     */
    public function show($id)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $activity = ActivityLogModel::with([
            'pengajuan.lowongan.partner',
            'dosen.user',
            'reviews.dosen.user',
            'attachments'
        ])
        ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
        ->findOrFail($id);

        return view('dashboard.mahasiswa.kegiatan.show', compact('activity', 'mahasiswa'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $activity = ActivityLogModel::with(['pengajuan.lowongan.partner', 'attachments'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->findOrFail($id);

        // Check if activity can be edited
        if (!$activity->canBeEdited()) {
            return redirect()->route('mahasiswa.kegiatan.index')
                ->with('error', 'Kegiatan ini tidak dapat diedit karena sudah disetujui atau ditolak.');
        }

        // Get student's accepted internships
        $internships = PengajuanMagangModel::with(['lowongan.partner', 'dosen'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->where('status', 'diterima')
            ->get();

        return view('dashboard.mahasiswa.kegiatan.edit', compact('activity', 'internships', 'mahasiswa'));
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $activity = ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->findOrFail($id);

        // Check if activity can be edited
        if (!$activity->canBeEdited()) {
            return redirect()->route('mahasiswa.kegiatan.index')
                ->with('error', 'Kegiatan ini tidak dapat diedit.');
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'activity_date' => 'required|date|before_or_equal:today',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'activity_title' => 'required|string|max:255',
            'activity_description' => 'required|string|min:50',
            'learning_objectives' => 'nullable|string',
            'challenges_faced' => 'nullable|string',
            'solutions_applied' => 'nullable|string',
            'is_weekly_summary' => 'boolean',
            'week_start_date' => 'nullable|date|required_if:is_weekly_summary,true',
            'week_end_date' => 'nullable|date|after_or_equal:week_start_date|required_if:is_weekly_summary,true',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx',
            'remove_attachments' => 'nullable|array',
            'remove_attachments.*' => 'exists:m_activity_attachments,attachment_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Update activity
            $activity->update([
                'activity_date' => $request->activity_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'activity_title' => $request->activity_title,
                'activity_description' => $request->activity_description,
                'learning_objectives' => $request->learning_objectives,
                'challenges_faced' => $request->challenges_faced,
                'solutions_applied' => $request->solutions_applied,
                'is_weekly_summary' => $request->boolean('is_weekly_summary'),
                'week_start_date' => $request->week_start_date,
                'week_end_date' => $request->week_end_date,
                'status' => 'pending', // Reset to pending after edit
                'submitted_at' => now(),
                'reviewed_at' => null,
            ]);

            // Remove selected attachments
            if ($request->has('remove_attachments')) {
                $attachmentsToRemove = ActivityAttachmentModel::whereIn('attachment_id', $request->remove_attachments)
                    ->where('activity_id', $activity->activity_id)
                    ->get();

                foreach ($attachmentsToRemove as $attachment) {
                    $attachment->delete(); // This will also delete the file due to model boot method
                }
            }

            // Handle new file attachments
            if ($request->hasFile('attachments')) {
                $existingAttachments = $activity->attachments()->count();
                foreach ($request->file('attachments') as $index => $file) {
                    $this->storeAttachment($activity->activity_id, $file, $existingAttachments === 0 && $index === 0);
                }
            }

            DB::commit();

            return redirect()->route('mahasiswa.kegiatan.show', $activity->activity_id)
                ->with('success', 'Kegiatan berhasil diperbarui dan dikirim untuk review ulang.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui kegiatan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Remove the specified activity.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $activity = ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->findOrFail($id);

        // Check if activity can be deleted
        if (!$activity->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan ini tidak dapat dihapus karena sudah disetujui atau ditolak.'
            ], 400);
        }

        try {
            $activity->delete(); // This will cascade delete attachments and reviews

            return response()->json([
                'success' => true,
                'message' => 'Kegiatan berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kegiatan.'
            ], 500);
        }
    }

    /**
     * Store file attachment for activity.
     */
    private function storeAttachment($activityId, $file, $isPrimary = false)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $storedName = time() . '_' . uniqid() . '.' . $extension;

        // Determine file type
        $mimeType = $file->getMimeType();
        $fileType = $this->determineFileType($mimeType, $extension);

        // Store file
        $filePath = $file->storeAs('activity_attachments', $storedName, 'public');

        // Create attachment record
        ActivityAttachmentModel::create([
            'activity_id' => $activityId,
            'original_filename' => $originalName,
            'stored_filename' => $storedName,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size' => $file->getSize(),
            'is_primary' => $isPrimary,
        ]);
    }

    /**
     * Determine file type based on mime type and extension.
     */
    private function determineFileType($mimeType, $extension)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }

        if ($mimeType === 'application/pdf' || $extension === 'pdf') {
            return 'pdf';
        }

        if (in_array($extension, ['doc', 'docx', 'txt', 'rtf'])) {
            return 'document';
        }

        if (in_array($extension, ['xls', 'xlsx', 'csv'])) {
            return 'spreadsheet';
        }

        if (in_array($extension, ['ppt', 'pptx'])) {
            return 'presentation';
        }

        if (str_starts_with($mimeType, 'video/')) {
            return 'video';
        }

        if (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        }

        if (in_array($extension, ['zip', 'rar', '7z', 'tar', 'gz'])) {
            return 'archive';
        }

        return 'document';
    }

    /**
     * Download attachment file.
     */
    public function downloadAttachment($attachmentId)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $attachment = ActivityAttachmentModel::whereHas('activity', function ($query) use ($mahasiswa) {
            $query->where('mahasiswa_id', $mahasiswa->mahasiswa_id);
        })->findOrFail($attachmentId);

        if (!Storage::exists($attachment->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::download($attachment->file_path, $attachment->original_filename);
    }
}
