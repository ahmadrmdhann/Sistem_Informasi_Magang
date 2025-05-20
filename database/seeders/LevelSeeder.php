<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_level')->insert([
            [
                'level_nama' => 'Administrator',
                'level_kode' => 'ADM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_nama' => 'Dosen',
                'level_kode' => 'DSN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_nama' => 'Mahasiswa',
                'level_kode' => 'MHS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
