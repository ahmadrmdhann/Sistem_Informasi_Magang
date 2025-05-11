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
        Schema::create('m_lowongan_magang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perusahaan_id'); 
            $table->string('judul_lowongan'); 
            $table->text('deskripsi');
            $table->integer('kuota'); 
            $table->integer('sisa_kuota'); 
            $table->date('batas_pendaftaran'); 
            $table->boolean('status')->default(true); 
            $table->timestamps();

   
            $table->foreign('perusahaan_id')->references('id')->on('m_perusahaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_lowongan_magang');
    }
};
