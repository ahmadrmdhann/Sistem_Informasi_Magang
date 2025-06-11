<?php

namespace App\Http\Controllers;

use App\Models\FeedbackFormModel;
use App\Models\FeedbackResponseModel;
use App\Models\FeedbackAnswerModel;
use App\Models\PengajuanMagangModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MahasiswaFeedbackController extends Controller
{
    /**
     * Display available feedback forms for the logged-in student.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        // Check if test mode is enabled
        $testMode = $request->session()->get('feedback_test_mode', false);

        // Get student's internships based on test mode
        if ($testMode) {
            // In test mode, get all internships regardless of status
            $completedInternships = PengajuanMagangModel::with(['lowongan.partner', 'dosen'])
                ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->get();
        } else {
            // Normal mode: only completed internships (status = 'diterima')
            $completedInternships = PengajuanMagangModel::with(['lowongan.partner', 'dosen'])
                ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->where('status', 'diterima')
                ->get();
        }

        // Get active feedback forms
        $activeForms = FeedbackFormModel::active()
            ->with(['questions' => function ($query) {
                $query->orderBy('order_index');
            }])
            ->get();

        // Get student's existing responses
        $existingResponses = FeedbackResponseModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('form')
            ->get()
            ->keyBy('form_id');

        // Prepare forms with submission status
        $formsWithStatus = $activeForms->map(function ($form) use ($existingResponses, $completedInternships, $testMode) {
            $response = $existingResponses->get($form->form_id);

            return [
                'form' => $form,
                'is_submitted' => $response !== null,
                'submitted_at' => $response ? $response->submitted_at : null,
                'can_submit' => $completedInternships->isNotEmpty() && $response === null,
                'response' => $response,
                'is_test_response' => $response && $response->is_test_mode
            ];
        });

        return view('dashboard.mahasiswa.feedback.index', compact(
            'formsWithStatus',
            'completedInternships',
            'mahasiswa',
            'testMode'
        ));
    }

    /**
     * Show the feedback form for submission.
     */
    public function show(Request $request, $formId)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        // Check if test mode is enabled
        $testMode = $request->session()->get('feedback_test_mode', false);

        // Check if form exists and is active
        $form = FeedbackFormModel::active()
            ->with(['questions' => function ($query) {
                $query->orderBy('order_index');
            }])
            ->findOrFail($formId);

        // Get student's internships based on test mode
        if ($testMode) {
            // In test mode, get all internships regardless of status
            $completedInternships = PengajuanMagangModel::with(['lowongan.partner'])
                ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->get();
        } else {
            // Normal mode: only completed internships (status = 'diterima')
            $completedInternships = PengajuanMagangModel::with(['lowongan.partner'])
                ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->where('status', 'diterima')
                ->get();
        }

        if ($completedInternships->isEmpty()) {
            $errorMessage = $testMode
                ? 'Anda belum memiliki pengajuan magang untuk testing.'
                : 'Anda belum memiliki magang yang telah selesai.';

            return redirect()->route('mahasiswa.feedback.index')
                ->with('error', $errorMessage);
        }

        // Check if student has already submitted feedback for this form
        $existingResponse = FeedbackResponseModel::where('form_id', $formId)
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->first();

        if ($existingResponse) {
            return redirect()->route('mahasiswa.feedback.index')
                ->with('error', 'Anda sudah mengisi feedback untuk form ini.');
        }

        return view('dashboard.mahasiswa.feedback.form', compact(
            'form',
            'completedInternships',
            'mahasiswa',
            'testMode'
        ));
    }

    /**
     * Store the feedback submission.
     */
    public function store(Request $request, $formId)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        // Check if test mode is enabled
        $testMode = $request->session()->get('feedback_test_mode', false);

        // Validate form exists and is active
        $form = FeedbackFormModel::active()->findOrFail($formId);

        // Check if student has already submitted feedback
        $existingResponse = FeedbackResponseModel::where('form_id', $formId)
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->first();

        if ($existingResponse) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengisi feedback untuk form ini.'
            ], 400);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'pengajuan_id' => 'required|exists:m_pengajuan_magang,id',
            'answers' => 'required|array',
            'answers.*' => 'required'
        ], [
            'pengajuan_id.required' => 'Pilih pengalaman magang yang akan dievaluasi.',
            'pengajuan_id.exists' => 'Pengalaman magang tidak valid.',
            'answers.required' => 'Semua pertanyaan wajib dijawab.',
            'answers.*.required' => 'Semua pertanyaan wajib dijawab.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify pengajuan belongs to this student
        $pengajuanQuery = PengajuanMagangModel::where('id', $request->pengajuan_id)
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id);

        // In normal mode, only allow completed internships
        if (!$testMode) {
            $pengajuanQuery->where('status', 'diterima');
        }

        $pengajuan = $pengajuanQuery->firstOrFail();

        DB::beginTransaction();
        try {
            // Create feedback response
            $response = FeedbackResponseModel::create([
                'form_id' => $formId,
                'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                'pengajuan_id' => $request->pengajuan_id,
                'submitted_at' => now(),
                'is_test_mode' => $testMode,
            ]);

            // Create answers for each question
            foreach ($request->answers as $questionId => $answerValue) {
                $question = $form->questions()->findOrFail($questionId);
                
                $answerData = [
                    'response_id' => $response->response_id,
                    'question_id' => $questionId,
                ];

                // Handle different question types
                if ($question->question_type === 'rating') {
                    $answerData['rating_value'] = (int) $answerValue;
                    $answerData['answer_text'] = null;
                } else {
                    $answerData['answer_text'] = $answerValue;
                    $answerData['rating_value'] = null;
                }

                FeedbackAnswerModel::create($answerData);
            }

            DB::commit();

            $message = $testMode
                ? 'Feedback test berhasil dikirim. Data ini ditandai sebagai data testing.'
                : 'Feedback berhasil dikirim. Terima kasih atas partisipasi Anda!';

            return response()->json([
                'success' => true,
                'message' => $message,
                'test_mode' => $testMode
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan feedback. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Show submitted feedback details.
     */
    public function showResponse($responseId)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $response = FeedbackResponseModel::with([
            'form.questions' => function ($query) {
                $query->orderBy('order_index');
            },
            'answers.question',
            'pengajuan.lowongan.partner'
        ])
        ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
        ->findOrFail($responseId);

        return view('dashboard.mahasiswa.feedback.response', compact('response', 'mahasiswa'));
    }

    /**
     * Toggle test mode for feedback testing.
     */
    public function toggleTestMode(Request $request)
    {
        $currentMode = $request->session()->get('feedback_test_mode', false);
        $newMode = !$currentMode;

        $request->session()->put('feedback_test_mode', $newMode);

        $message = $newMode
            ? 'Test Mode diaktifkan. Anda dapat mengisi feedback untuk semua pengajuan magang.'
            : 'Test Mode dinonaktifkan. Kembali ke mode normal.';

        return response()->json([
            'success' => true,
            'test_mode' => $newMode,
            'message' => $message
        ]);
    }

    /**
     * Clear all test mode responses.
     */
    public function clearTestData(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        // Delete all test mode responses for this student
        $deletedCount = FeedbackResponseModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->where('is_test_mode', true)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "Berhasil menghapus {$deletedCount} data test feedback.",
            'deleted_count' => $deletedCount
        ]);
    }
}
