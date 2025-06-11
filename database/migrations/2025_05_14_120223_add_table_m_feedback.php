<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old simple feedback table if it exists
        Schema::dropIfExists('m_feedback');

        // Create feedback forms table for admin to manage form templates
        Schema::create('m_feedback_forms', function (Blueprint $table) {
            $table->id('form_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        // Create feedback questions table
        Schema::create('m_feedback_questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->foreignId('form_id')->constrained('m_feedback_forms', 'form_id')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['rating', 'text', 'multiple_choice']);
            $table->json('options')->nullable(); // For multiple choice questions
            $table->boolean('is_required')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        // Create feedback responses table (one per student per form)
        Schema::create('m_feedback_responses', function (Blueprint $table) {
            $table->id('response_id');
            $table->foreignId('form_id')->constrained('m_feedback_forms', 'form_id')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswa', 'mahasiswa_id')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->nullable()->constrained('m_pengajuan_magang', 'id')->onDelete('cascade');
            $table->timestamp('submitted_at');
            $table->timestamps();

            // Ensure one response per student per form
            $table->unique(['form_id', 'mahasiswa_id']);
        });

        // Create feedback answers table (individual answers to questions)
        Schema::create('m_feedback_answers', function (Blueprint $table) {
            $table->id('answer_id');
            $table->foreignId('response_id')->constrained('m_feedback_responses', 'response_id')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('m_feedback_questions', 'question_id')->onDelete('cascade');
            $table->text('answer_text')->nullable();
            $table->integer('rating_value')->nullable(); // For 1-10 rating questions
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_feedback_answers');
        Schema::dropIfExists('m_feedback_responses');
        Schema::dropIfExists('m_feedback_questions');
        Schema::dropIfExists('m_feedback_forms');
    }
};
