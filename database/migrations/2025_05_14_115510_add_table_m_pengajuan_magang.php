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
        Schema::create('m_pengajuan_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswa', 'mahasiswa_id');
            $table->foreignId('lowongan_id')->constrained('m_lowongan', 'lowongan_id');
            $table->enum('status', ['diajukan', 'diterima', 'ditolak']);
            $table->date('tanggal_pengajuan');
            $table->foreignId('dosen_id')->nullable()->constrained('m_dosen', 'dosen_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pengajuan_magang');
    }
};
