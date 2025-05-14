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
        Schema::create('m_keahlian_mahasiswa', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswa', 'user_id');
            $table->foreignId('keahlian_id')->constrained('m_keahlian', 'keahlian_id');
            $table->primary(['mahasiswa_id', 'keahlian_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_keahlian_mahasiswa');
    }
};
