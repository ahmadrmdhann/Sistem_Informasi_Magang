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
                'kabupaten_id'    => 3171, // Jakarta Pusat
                'keahlian_id'     => 1,
                'periode_id'      => 1,
                'kuota'           => 5,
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
                'kabupaten_id'    => 3273, // Kota Bandung
                'keahlian_id'     => 4,
                'periode_id'      => 1,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(14)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(4)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 3,
                'judul'           => 'Magang UI/UX Designer',
                'deskripsi'       => 'Merancang antarmuka pengguna yang menarik dan user-friendly.',
                'persyaratan'     => 'Menguasai Figma, Adobe XD, dan prinsip-prinsip desain.',
                'kabupaten_id'    => 3578, // Kota Surabaya
                'keahlian_id'     => 7,
                'periode_id'      => 2,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(10)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 4,
                'judul'           => 'Magang Mobile Developer',
                'deskripsi'       => 'Mengembangkan aplikasi mobile Android dan iOS.',
                'persyaratan'     => 'Menguasai Flutter atau React Native, Dart/JavaScript.',
                'kabupaten_id'    => 3471, // Kota Yogyakarta
                'keahlian_id'     => 8,
                'periode_id'      => 1,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(21)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(5)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 5,
                'judul'           => 'Magang Digital Marketing',
                'deskripsi'       => 'Mengelola kampanye pemasaran digital dan media sosial.',
                'persyaratan'     => 'Memahami SEO, SEM, dan platform media sosial.',
                'kabupaten_id'    => 1271, // Kota Medan
                'keahlian_id'     => 3,
                'periode_id'      => 2,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(5)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 6,
                'judul'           => 'Magang Quality Assurance',
                'deskripsi'       => 'Melakukan pengujian software untuk memastikan kualitas produk.',
                'persyaratan'     => 'Memahami testing methodology dan tools testing.',
                'kabupaten_id'    => 3374, // Kota Semarang
                'keahlian_id'     => 9,
                'periode_id'      => 1,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(12)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(4)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 7,
                'judul'           => 'Magang DevOps Engineer',
                'deskripsi'       => 'Mengelola infrastructure dan deployment aplikasi.',
                'persyaratan'     => 'Menguasai Docker, Jenkins, dan cloud platform.',
                'kabupaten_id'    => 7371, // Kota Makassar
                'keahlian_id'     => 10,
                'periode_id'      => 2,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(18)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(6)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 8,
                'judul'           => 'Magang Content Writer',
                'deskripsi'       => 'Menulis konten untuk website dan platform digital.',
                'persyaratan'     => 'Kemampuan menulis yang baik dan pemahaman SEO.',
                'kabupaten_id'    => 5171, // Kota Denpasar
                'keahlian_id'     => 2,
                'periode_id'      => 1,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(8)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 9,
                'judul'           => 'Magang Network Administrator',
                'deskripsi'       => 'Mengelola dan memelihara infrastruktur jaringan.',
                'persyaratan'     => 'Memahami networking, CISCO, dan troubleshooting.',
                'kabupaten_id'    => 1671, // Kota Palembang
                'keahlian_id'     => 11,
                'periode_id'      => 2,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(15)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(4)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'partner_id'      => 10,
                'judul'           => 'Magang Cybersecurity Analyst',
                'deskripsi'       => 'Menganalisis dan mengamankan sistem dari ancaman cyber.',
                'persyaratan'     => 'Memahami security tools dan ethical hacking.',
                'kabupaten_id'    => 3573, // Kota Malang
                'keahlian_id'     => 12,
                'periode_id'      => 1,
                'kuota'           => 5,
                'tanggal_mulai'   => Carbon::now()->addDays(25)->format('Y-m-d'),
                'tanggal_akhir'   => Carbon::now()->addMonths(5)->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
