<?php

namespace App\Http\Controllers;

use App\Models\FeedbackFormModel;
use App\Models\FeedbackQuestionModel;
use App\Models\FeedbackResponseModel;
use App\Models\FeedbackAnswerModel;
use App\Models\PengajuanMagangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminFeedbackController extends Controller
{
    /**
     * Display a listing of feedback forms.
     */
    public function index()
    {
        $forms = FeedbackFormModel::withCount(['questions', 'responses'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.admin.feedback.index', compact('forms'));
    }

    /**
     * Show the form for creating a new feedback form.
     */
    public function create()
    {
        return view('dashboard.admin.feedback.create');
    }

    /**
     * Store a newly created feedback form in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:rating,text,multiple_choice',
            'questions.*.is_required' => 'boolean',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'string|max:255',
        ]);

        // Custom validation for multiple choice questions
        $validator->after(function ($validator) use ($request) {
            if ($request->has('questions')) {
                foreach ($request->questions as $index => $question) {
                    if ($question['question_type'] === 'multiple_choice') {
                        if (empty($question['options']) || count($question['options']) === 0) {
                            $validator->errors()->add(
                                "questions.{$index}.options",
                                'Pertanyaan pilihan ganda harus memiliki minimal satu pilihan jawaban.'
                            );
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->route('admin.feedback.create')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Create the feedback form
            $form = FeedbackFormModel::create([
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->boolean('is_active', true),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            // Create questions
            foreach ($request->questions as $index => $questionData) {
                FeedbackQuestionModel::create([
                    'form_id' => $form->form_id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'options' => $questionData['options'] ?? null,
                    'is_required' => $questionData['is_required'] ?? true,
                    'order_index' => $index + 1,
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Form feedback berhasil dibuat.',
                    'form' => $form
                ]);
            }

            return redirect()->route('admin.feedback.index')
                ->with('success', 'Form feedback berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat membuat form feedback.'
                ], 500);
            }

            return redirect()->route('admin.feedback.create')
                ->with('error', 'Terjadi kesalahan saat membuat form feedback.')
                ->withInput();
        }
    }

    /**
     * Display the specified feedback form.
     */
    public function show($id)
    {
        $form = FeedbackFormModel::with(['questions' => function ($query) {
            $query->orderBy('order_index');
        }])->findOrFail($id);

        return view('dashboard.admin.feedback.show', compact('form'));
    }

    /**
     * Show the form for editing the specified feedback form.
     */
    public function edit($id)
    {
        $form = FeedbackFormModel::with(['questions' => function ($query) {
            $query->orderBy('order_index');
        }])->findOrFail($id);

        return view('dashboard.admin.feedback.edit', compact('form'));
    }

    /**
     * Update the specified feedback form in storage.
     */
    public function update(Request $request, $id)
    {
        $form = FeedbackFormModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:rating,text,multiple_choice',
            'questions.*.is_required' => 'boolean',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'string|max:255',
        ]);

        // Custom validation for multiple choice questions
        $validator->after(function ($validator) use ($request) {
            if ($request->has('questions')) {
                foreach ($request->questions as $index => $question) {
                    if ($question['question_type'] === 'multiple_choice') {
                        if (empty($question['options']) || count($question['options']) === 0) {
                            $validator->errors()->add(
                                "questions.{$index}.options",
                                'Pertanyaan pilihan ganda harus memiliki minimal satu pilihan jawaban.'
                            );
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->route('admin.feedback.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Update the feedback form
            $form->update([
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->boolean('is_active', true),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            // Delete existing questions
            $form->questions()->delete();

            // Create new questions
            foreach ($request->questions as $index => $questionData) {
                FeedbackQuestionModel::create([
                    'form_id' => $form->form_id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'options' => $questionData['options'] ?? null,
                    'is_required' => $questionData['is_required'] ?? true,
                    'order_index' => $index + 1,
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Form feedback berhasil diperbarui.',
                    'form' => $form
                ]);
            }

            return redirect()->route('admin.feedback.index')
                ->with('success', 'Form feedback berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui form feedback.'
                ], 500);
            }

            return redirect()->route('admin.feedback.edit', $id)
                ->with('error', 'Terjadi kesalahan saat memperbarui form feedback.')
                ->withInput();
        }
    }

    /**
     * Remove the specified feedback form from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $form = FeedbackFormModel::findOrFail($id);
            $form->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Form feedback berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.feedback.index')
                ->with('success', 'Form feedback berhasil dihapus.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus form feedback.'
                ], 500);
            }

            return redirect()->route('admin.feedback.index')
                ->with('error', 'Terjadi kesalahan saat menghapus form feedback.');
        }
    }

    /**
     * Toggle the active status of a feedback form.
     */
    public function toggleStatus($id)
    {
        try {
            $form = FeedbackFormModel::findOrFail($id);
            $form->update(['is_active' => !$form->is_active]);

            $status = $form->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->route('admin.feedback.index')
                ->with('success', "Form feedback berhasil {$status}.");
        } catch (\Exception $e) {
            return redirect()->route('admin.feedback.index')
                ->with('error', 'Terjadi kesalahan saat mengubah status form feedback.');
        }
    }

    /**
     * Display all feedback responses.
     */
    public function responses(Request $request)
    {
        $query = FeedbackResponseModel::with(['form', 'mahasiswa.user', 'mahasiswa.prodi']);

        // Apply filters
        if ($request->filled('form_id')) {
            $query->where('form_id', $request->form_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('mahasiswa.user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('mahasiswa', function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%");
            });
        }

        $responses = $query->orderBy('submitted_at', 'desc')->paginate(15);
        $forms = FeedbackFormModel::orderBy('title')->get();

        return view('dashboard.admin.feedback.responses', compact('responses', 'forms'));
    }

    /**
     * Display a specific feedback response.
     */
    public function showResponse($id)
    {
        $response = FeedbackResponseModel::with([
            'form',
            'mahasiswa.user',
            'mahasiswa.prodi',
            'answers.question'
        ])->findOrFail($id);

        return view('dashboard.admin.feedback.response-detail', compact('response'));
    }
}
