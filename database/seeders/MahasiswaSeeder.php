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
                'user_id' => 3, // Pastikan sesuai dengan id pada seeder m_user
                'nim' => '23417200021',
                'prodi_id' => 1,
                'bidang_keahlian' => 'Software Engineering',
                'lokasi_preferensi' => 'Jakarta',
                'sertifikat' => 'Sertifikat A',
                'cv_file' => 'cv_mahasiswa1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
