<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_dosen')->insert([
            [
                'user_id' => 2, // Pastikan sesuai dengan id pada seeder m_user
                'nidn' => '198012345',
                'bidang_minat' => 'Sistem Informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
