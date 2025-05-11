<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LowonganMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_lowongan_magang')->insert([
            [
                'perusahaan_id' => 1,
                'judul_lowongan' => 'Software Engineer Intern',
                'deskripsi' => 'Bertanggung jawab untuk membantu pengembangan aplikasi web.',
                'kuota' => 10,
                'sisa_kuota' => 10,
                'batas_pendaftaran' => '2025-06-30',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'perusahaan_id' => 2,
                'judul_lowongan' => 'Graphic Designer Intern',
                'deskripsi' => 'Membantu tim desain dalam membuat konten visual.',
                'kuota' => 5,
                'sisa_kuota' => 3,
                'batas_pendaftaran' => '2025-07-15',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'perusahaan_id' => 3,
                'judul_lowongan' => 'Digital Marketing Intern',
                'deskripsi' => 'Membantu tim pemasaran digital dalam kampanye online.',
                'kuota' => 8,
                'sisa_kuota' => 8,
                'batas_pendaftaran' => '2025-08-01',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}