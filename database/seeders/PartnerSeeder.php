<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_partner')->insert([
            [
                'nama'       => 'PT Teknologi Nusantara',
                'alamat'     => 'Jl. Merdeka No. 123, Jakarta',
                'telepon'    => '02112345678',
                'email'      => 'info@teknologinusantara.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'CV Data Solusi',
                'alamat'     => 'Jl. Asia Afrika No. 45, Bandung',
                'telepon'    => '02287654321',
                'email'      => 'contact@datasolusi.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
