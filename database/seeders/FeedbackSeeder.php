<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FeedbackFormModel;
use App\Models\FeedbackQuestionModel;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample feedback form
        $form = FeedbackFormModel::create([
            'title' => 'Evaluasi Pengalaman Magang',
            'description' => 'Form evaluasi untuk menilai pengalaman mahasiswa selama menjalani program magang di perusahaan mitra.',
            'is_active' => true,
            'start_date' => now()->subDays(30),
            'end_date' => now()->addDays(30),
        ]);

        // Create sample questions
        $questions = [
            [
                'question_text' => 'Bagaimana Anda menilai kualitas bimbingan yang diberikan oleh supervisor di tempat magang?',
                'question_type' => 'rating',
                'options' => null,
                'is_required' => true,
                'order_index' => 1,
            ],
            [
                'question_text' => 'Seberapa relevan tugas-tugas yang diberikan dengan bidang studi Anda?',
                'question_type' => 'rating',
                'options' => null,
                'is_required' => true,
                'order_index' => 2,
            ],
            [
                'question_text' => 'Bagaimana Anda menilai fasilitas dan lingkungan kerja di tempat magang?',
                'question_type' => 'rating',
                'options' => null,
                'is_required' => true,
                'order_index' => 3,
            ],
            [
                'question_text' => 'Apakah Anda merasa program magang ini membantu mengembangkan keterampilan profesional Anda?',
                'question_type' => 'multiple_choice',
                'options' => ['Sangat membantu', 'Cukup membantu', 'Kurang membantu', 'Tidak membantu'],
                'is_required' => true,
                'order_index' => 4,
            ],
            [
                'question_text' => 'Ceritakan pengalaman paling berkesan selama menjalani program magang.',
                'question_type' => 'text',
                'options' => null,
                'is_required' => false,
                'order_index' => 5,
            ],
            [
                'question_text' => 'Apa saran Anda untuk perbaikan program magang di masa mendatang?',
                'question_type' => 'text',
                'options' => null,
                'is_required' => false,
                'order_index' => 6,
            ],
            [
                'question_text' => 'Apakah Anda akan merekomendasikan tempat magang ini kepada mahasiswa lain?',
                'question_type' => 'multiple_choice',
                'options' => ['Sangat merekomendasikan', 'Merekomendasikan', 'Netral', 'Tidak merekomendasikan'],
                'is_required' => true,
                'order_index' => 7,
            ],
            [
                'question_text' => 'Bagaimana Anda menilai komunikasi antara universitas dengan tempat magang?',
                'question_type' => 'rating',
                'options' => null,
                'is_required' => true,
                'order_index' => 8,
            ],
        ];

        foreach ($questions as $questionData) {
            FeedbackQuestionModel::create([
                'form_id' => $form->form_id,
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
                'options' => $questionData['options'],
                'is_required' => $questionData['is_required'],
                'order_index' => $questionData['order_index'],
            ]);
        }

        // Create another sample form
        $form2 = FeedbackFormModel::create([
            'title' => 'Evaluasi Kinerja Mahasiswa Magang',
            'description' => 'Form evaluasi untuk menilai kinerja dan kemampuan mahasiswa selama program magang.',
            'is_active' => false,
            'start_date' => null,
            'end_date' => null,
        ]);

        $questions2 = [
            [
                'question_text' => 'Bagaimana Anda menilai kemampuan teknis mahasiswa dalam menyelesaikan tugas?',
                'question_type' => 'rating',
                'options' => null,
                'is_required' => true,
                'order_index' => 1,
            ],
            [
                'question_text' => 'Seberapa baik kemampuan komunikasi mahasiswa?',
                'question_type' => 'rating',
                'options' => null,
                'is_required' => true,
                'order_index' => 2,
            ],
            [
                'question_text' => 'Apakah mahasiswa menunjukkan inisiatif dalam bekerja?',
                'question_type' => 'multiple_choice',
                'options' => ['Sangat baik', 'Baik', 'Cukup', 'Kurang'],
                'is_required' => true,
                'order_index' => 3,
            ],
            [
                'question_text' => 'Berikan komentar tambahan mengenai kinerja mahasiswa.',
                'question_type' => 'text',
                'options' => null,
                'is_required' => false,
                'order_index' => 4,
            ],
        ];

        foreach ($questions2 as $questionData) {
            FeedbackQuestionModel::create([
                'form_id' => $form2->form_id,
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
                'options' => $questionData['options'],
                'is_required' => $questionData['is_required'],
                'order_index' => $questionData['order_index'],
            ]);
        }
    }
}
