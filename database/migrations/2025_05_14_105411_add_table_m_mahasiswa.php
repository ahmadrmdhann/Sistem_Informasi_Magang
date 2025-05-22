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
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->id('mahasiswa_id');
            $table->foreignId('user_id')->constrained('m_user', 'user_id')->onDelete('cascade');
            $table->string('nim')->unique();
            $table->foreignId('prodi_id')->constrained('m_prodi', 'prodi_id');
            $table->text('bidang_keahlian')->nullable();
            $table->text('lokasi_preferensi')->nullable();
            $table->text('sertifikat')->nullable();
            $table->string('cv_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa');
    }
};
