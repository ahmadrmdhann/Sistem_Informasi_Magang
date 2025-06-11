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
        // Drop the old simple log_kegiatan table if it exists
        Schema::dropIfExists('log_kegiatan');

        // Create comprehensive activity logs table
        Schema::create('m_activity_logs', function (Blueprint $table) {
            $table->id('activity_id');
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswa', 'mahasiswa_id')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->constrained('m_pengajuan_magang', 'id')->onDelete('cascade');
            $table->foreignId('dosen_id')->nullable()->constrained('m_dosen', 'dosen_id')->onDelete('set null');
            
            // Activity details
            $table->date('activity_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('activity_title');
            $table->text('activity_description');
            $table->text('learning_objectives')->nullable();
            $table->text('challenges_faced')->nullable();
            $table->text('solutions_applied')->nullable();
            
            // Status and review
            $table->enum('status', ['pending', 'approved', 'needs_revision', 'rejected'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            
            // Metadata
            $table->boolean('is_weekly_summary')->default(false);
            $table->date('week_start_date')->nullable();
            $table->date('week_end_date')->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['mahasiswa_id', 'activity_date']);
            $table->index(['dosen_id', 'status']);
            $table->index(['pengajuan_id', 'status']);
        });

        // Create activity reviews table for supervisor feedback
        Schema::create('m_activity_reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->foreignId('activity_id')->constrained('m_activity_logs', 'activity_id')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('m_dosen', 'dosen_id')->onDelete('cascade');
            
            // Review details
            $table->enum('review_status', ['approved', 'needs_revision', 'rejected']);
            $table->text('feedback_comment')->nullable();
            $table->integer('rating')->nullable()->comment('1-5 rating scale');
            $table->text('suggestions')->nullable();
            
            // Review metadata
            $table->timestamp('reviewed_at');
            $table->boolean('is_final_review')->default(false);
            
            $table->timestamps();
            
            // Ensure one review per activity per supervisor
            $table->unique(['activity_id', 'dosen_id']);
        });

        // Create activity attachments table for file uploads
        Schema::create('m_activity_attachments', function (Blueprint $table) {
            $table->id('attachment_id');
            $table->foreignId('activity_id')->constrained('m_activity_logs', 'activity_id')->onDelete('cascade');
            
            // File details
            $table->string('original_filename');
            $table->string('stored_filename');
            $table->string('file_path');
            $table->string('file_type'); // image, document, etc.
            $table->string('mime_type');
            $table->bigInteger('file_size'); // in bytes
            
            // Metadata
            $table->text('description')->nullable();
            $table->boolean('is_primary')->default(false);
            
            $table->timestamps();
            
            $table->index(['activity_id', 'file_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_activity_attachments');
        Schema::dropIfExists('m_activity_reviews');
        Schema::dropIfExists('m_activity_logs');
    }
};
