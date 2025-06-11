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
        Schema::table('m_feedback_responses', function (Blueprint $table) {
            $table->boolean('is_test_mode')->default(false)->after('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_feedback_responses', function (Blueprint $table) {
            $table->dropColumn('is_test_mode');
        });
    }
};
