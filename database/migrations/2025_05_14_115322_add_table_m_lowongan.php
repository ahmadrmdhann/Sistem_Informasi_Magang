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
        Schema::create('m_lowongan', function (Blueprint $table) {
            $table->id('lowongan_id');
            $table->foreignId('partner_id')->constrained('m_partner', 'partner_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->text('persyaratan');
            $table->foreignId('kabupaten_id')->constrained('m_kota_kabupaten', 'kabupaten_id');
            $table->foreignId('keahlian_id')->constrained('m_keahlian', 'keahlian_id');
            $table->foreignId('periode_id')->constrained('m_periode', 'periode_id');
            $table->integer('kuota');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_lowongan', function (Blueprint $table) {
            $table->dropForeign(['kabupaten_id']);
            $table->dropColumn('kabupaten_id');

        });
        Schema::dropIfExists('m_lowongan');
    }
};