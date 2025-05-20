<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_prodi')->insert([
            [
                'prodi_nama' => 'Teknik Informatika',
                'prodi_kode' => 'TI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prodi_nama' => 'Sistem Informasi Bisnis',
                'prodi_kode' => 'SIB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prodi_nama' => 'Pengembangan Perangkat Lunak Situs',
                'prodi_kode' => 'PPLS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
