<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_periode')->insert([
            [
                'nama'       => 'Semester Ganjil 2023/2024',
                'tanggal_mulai' => '2025-09-01',
                'tanggal_selesai' => '2026-02-28',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'Semester Genap 2024/2025',
                'tanggal_mulai' => '2026-03-01',
                'tanggal_selesai' => '2026-08-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
