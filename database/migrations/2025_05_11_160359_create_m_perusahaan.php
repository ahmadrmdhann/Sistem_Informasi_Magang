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
        Schema::create('m_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan'); 
            $table->string('email')->unique(); 
            $table->string('telepon')->nullable(); 
            $table->text('alamat')->nullable();
            $table->string('website')->nullable(); 
            $table->string('logo')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_perusahaan');
    }
};
