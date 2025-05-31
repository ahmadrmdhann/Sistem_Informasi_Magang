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
        Schema::create('m_kota_kabupaten', function (Blueprint $table) {
            $table->id('kabupaten_id');
            $table->foreignId('provinsi_id')->constrained('m_provinsi', 'provinsi_id')->onDelete('cascade');
            $table->string('nama', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kota_kabupaten');
    }
};