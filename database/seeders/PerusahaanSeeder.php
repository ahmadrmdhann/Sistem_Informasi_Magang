<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_perusahaan')->insert([
            [
                'nama_perusahaan' => 'PT Teknologi Nusantara',
                'email' => 'info@teknologinusantara.com',
                'telepon' => '02112345678',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'website' => 'https://teknologinusantara.com',
                'logo' => 'logos/teknologi_nusantara.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT Kreatif Media',
                'email' => 'contact@kreatifmedia.com',
                'telepon' => '02298765432',
                'alamat' => 'Jl. Asia Afrika No. 45, Bandung',
                'website' => 'https://kreatifmedia.com',
                'logo' => 'logos/kreatif_media.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT Solusi Digital',
                'email' => 'hello@solusidigital.com',
                'telepon' => '03156789012',
                'alamat' => 'Jl. Pahlawan No. 78, Surabaya',
                'website' => 'https://solusidigital.com',
                'logo' => 'logos/solusi_digital.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}