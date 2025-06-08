<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_lowongan')->insert([
            [
                'partner_id'      => 1,
                'judul'           => 'Magang Web Developer',
                'deskripsi'       => 'Bergabung sebagai web developer untuk membangun aplikasi internal.',
                'persyaratan'     => 'Menguasai Laravel, HTML, CSS, dan JavaScript.',
                'kabupaten_id'          => 1101,
                'keahlian_id' => 6,
                'periode_id'      => 1,
                'tanggal_mulai'   => Carbon::now()->addDays(7)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 2,
                'judul'           => 'Magang Data Analyst',
                'deskripsi'       => 'Menganalisis data bisnis dan membuat laporan.',
                'persyaratan'     => 'Menguasai Excel, SQL, dan dasar-dasar statistik.',
                'kabupaten_id'          => 1102,
                'keahlian_id' => 4,
                'periode_id'      => 1,
                'tanggal_mulai'   => Carbon::now()->addDays(14)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(4)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}