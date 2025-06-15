<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_mahasiswa')->insert([
            [
                'user_id' => 4, // Dandi Azrul Syahputra (Mahasiswa)
                'nim' => '23417200021',
                'prodi_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5, // Yantos inferno (Mahasiswa)
                'nim' => '2341720090',
                'prodi_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
