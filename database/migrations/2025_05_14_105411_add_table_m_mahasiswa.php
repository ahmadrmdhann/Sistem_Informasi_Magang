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
            $table->string('nim')->unique()->nullable();
            $table->foreignId('prodi_id')->nullable()->constrained('m_prodi', 'prodi_id');
            $table->foreignId('keahlian_id')->nullable()->constrained('m_keahlian', 'keahlian_id');
            $table->foreignId('minat_id')->nullable()->constrained('m_keahlian', 'keahlian_id');
            $table->foreignId('lokasi_preferensi')->nullable()->constrained('m_kota_kabupaten', 'kabupaten_id');
            $table->text('sertifikat')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('foto_profil')->nullable();
            $table->text('tentang_saya')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->decimal('ipk', 4, 2)->nullable();
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
