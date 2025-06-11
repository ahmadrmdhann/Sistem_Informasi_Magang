<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\FeedbackResponseModel;
use App\Models\FeedbackFormModel;
use App\Models\MahasiswaModel;
use App\Models\PengajuanMagangModel;
use App\Models\PartnerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DosenFeedbackController extends Controller
{
    /**
     * Display the feedback dashboard for dosen.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        // Get filter parameters
        $mahasiswaFilter = $request->get('mahasiswa_id');
        $partnerFilter = $request->get('partner_id');
        $formFilter = $request->get('form_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Get supervised students with completed internships
        $supervisedStudents = MahasiswaModel::whereHas('PengajuanMagang', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        })->with('user')->get();

        // Get partners from supervised students' internships
        $partners = PartnerModel::whereHas('lowongans.pengajuanMagang', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        })->get();

        // Get available feedback forms
        $feedbackForms = FeedbackFormModel::where('is_active', true)->get();

        // Build query for feedback responses from supervised students
        $feedbackQuery = FeedbackResponseModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'pengajuan.dosen.user',
            'form',
            'answers.question'
        ])->whereHas('pengajuan', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        });

        // Apply filters
        if ($mahasiswaFilter) {
            $feedbackQuery->where('mahasiswa_id', $mahasiswaFilter);
        }

        if ($partnerFilter) {
            $feedbackQuery->whereHas('pengajuan.lowongan', function ($query) use ($partnerFilter) {
                $query->where('partner_id', $partnerFilter);
            });
        }

        if ($formFilter) {
            $feedbackQuery->where('form_id', $formFilter);
        }

        if ($dateFrom) {
            $feedbackQuery->whereDate('submitted_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $feedbackQuery->whereDate('submitted_at', '<=', $dateTo);
        }

        $feedbackResponses = $feedbackQuery->orderBy('submitted_at', 'desc')
            ->paginate(15);

        // Get statistics
        $stats = [
            'total_responses' => FeedbackResponseModel::whereHas('pengajuan', function ($query) use ($dosen) {
                $query->where('dosen_id', $dosen->dosen_id)->where('status', 'diterima');
            })->count(),
            'total_students' => $supervisedStudents->count(),
            'total_partners' => $partners->count(),
            'avg_rating' => $this->calculateAverageRating($dosen->dosen_id),
        ];

        return view('dashboard.dosen.feedback-mahasiswa.index', compact(
            'feedbackResponses',
            'supervisedStudents',
            'partners',
            'feedbackForms',
            'stats',
            'mahasiswaFilter',
            'partnerFilter',
            'formFilter',
            'dateFrom',
            'dateTo',
            'dosen'
        ));
    }

    /**
     * Display the specified feedback response.
     */
    public function show($responseId)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        $feedbackResponse = FeedbackResponseModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'pengajuan.dosen.user',
            'form',
            'answers.question'
        ])->whereHas('pengajuan', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        })->findOrFail($responseId);

        // Group answers by question type for better display
        $groupedAnswers = $feedbackResponse->answers->groupBy('question.question_type');

        // Calculate rating statistics for this response
        $ratingAnswers = $groupedAnswers->get('rating', collect());
        $ratingStats = [
            'total_ratings' => $ratingAnswers->count(),
            'average_rating' => $ratingAnswers->avg('rating_value'),
            'ratings_breakdown' => $ratingAnswers->groupBy('rating_value')->map->count(),
        ];

        return view('dashboard.dosen.feedback-mahasiswa.show', compact(
            'feedbackResponse',
            'groupedAnswers',
            'ratingStats',
            'dosen'
        ));
    }

    /**
     * Get feedback analytics for supervised students.
     */
    public function analytics(Request $request)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        // Get date range
        $dateFrom = $request->get('date_from', now()->subMonths(6)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Get feedback responses in date range
        $feedbackResponses = FeedbackResponseModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'answers.question'
        ])->whereHas('pengajuan', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        })->whereBetween('submitted_at', [$dateFrom, $dateTo])
          ->get();

        // Calculate analytics
        $analytics = [
            'total_responses' => $feedbackResponses->count(),
            'responses_by_month' => $feedbackResponses->groupBy(function ($response) {
                return $response->submitted_at->format('Y-m');
            })->map->count(),
            'responses_by_partner' => $feedbackResponses->groupBy('pengajuan.lowongan.partner.nama')->map->count(),
            'average_ratings_by_partner' => $this->getAverageRatingsByPartner($feedbackResponses),
            'student_satisfaction' => $this->calculateStudentSatisfaction($feedbackResponses),
        ];

        return view('dashboard.dosen.feedback-mahasiswa.analytics', compact(
            'analytics',
            'dateFrom',
            'dateTo',
            'dosen'
        ));
    }

    /**
     * Export feedback data to CSV.
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        // Get filtered feedback responses
        $feedbackQuery = FeedbackResponseModel::with([
            'mahasiswa.user',
            'pengajuan.lowongan.partner',
            'form',
            'answers.question'
        ])->whereHas('pengajuan', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->dosen_id)
                  ->where('status', 'diterima');
        });

        // Apply same filters as index
        if ($request->get('mahasiswa_id')) {
            $feedbackQuery->where('mahasiswa_id', $request->get('mahasiswa_id'));
        }

        if ($request->get('partner_id')) {
            $feedbackQuery->whereHas('pengajuan.lowongan', function ($query) use ($request) {
                $query->where('partner_id', $request->get('partner_id'));
            });
        }

        if ($request->get('form_id')) {
            $feedbackQuery->where('form_id', $request->get('form_id'));
        }

        if ($request->get('date_from')) {
            $feedbackQuery->whereDate('submitted_at', '>=', $request->get('date_from'));
        }

        if ($request->get('date_to')) {
            $feedbackQuery->whereDate('submitted_at', '<=', $request->get('date_to'));
        }

        $feedbackResponses = $feedbackQuery->orderBy('submitted_at', 'desc')->get();

        // Generate CSV
        $filename = 'feedback_mahasiswa_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($feedbackResponses) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Tanggal Submit',
                'Mahasiswa',
                'Email Mahasiswa',
                'Form Feedback',
                'Perusahaan',
                'Rata-rata Rating',
                'Total Pertanyaan',
                'Status'
            ]);

            // CSV Data
            foreach ($feedbackResponses as $response) {
                $avgRating = $response->answers->where('rating_value', '!=', null)->avg('rating_value');
                
                fputcsv($file, [
                    $response->submitted_at->format('d/m/Y H:i'),
                    $response->mahasiswa->user->nama,
                    $response->mahasiswa->user->email,
                    $response->form->title,
                    $response->pengajuan->lowongan->partner->nama,
                    $avgRating ? number_format($avgRating, 1) : '-',
                    $response->answers->count(),
                    'Completed'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate average rating for dosen's supervised students.
     */
    private function calculateAverageRating($dosenId)
    {
        return DB::table('m_feedback_answers')
            ->join('m_feedback_responses', 'm_feedback_answers.response_id', '=', 'm_feedback_responses.response_id')
            ->join('m_pengajuan_magang', 'm_feedback_responses.pengajuan_id', '=', 'm_pengajuan_magang.id')
            ->where('m_pengajuan_magang.dosen_id', $dosenId)
            ->where('m_pengajuan_magang.status', 'diterima')
            ->whereNotNull('m_feedback_answers.rating_value')
            ->avg('m_feedback_answers.rating_value');
    }

    /**
     * Get average ratings by partner.
     */
    private function getAverageRatingsByPartner($feedbackResponses)
    {
        return $feedbackResponses->groupBy('pengajuan.lowongan.partner.nama')
            ->map(function ($responses) {
                $allRatings = $responses->flatMap(function ($response) {
                    return $response->answers->whereNotNull('rating_value')->pluck('rating_value');
                });
                
                return $allRatings->avg();
            })->filter();
    }

    /**
     * Calculate student satisfaction metrics.
     */
    private function calculateStudentSatisfaction($feedbackResponses)
    {
        $allRatings = $feedbackResponses->flatMap(function ($response) {
            return $response->answers->whereNotNull('rating_value')->pluck('rating_value');
        });

        if ($allRatings->isEmpty()) {
            return [
                'average' => 0,
                'satisfaction_rate' => 0,
                'total_ratings' => 0,
            ];
        }

        return [
            'average' => $allRatings->avg(),
            'satisfaction_rate' => ($allRatings->where('>=', 7)->count() / $allRatings->count()) * 100,
            'total_ratings' => $allRatings->count(),
        ];
    }
}
