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
                'alamat'     => 'Jl. Merdeka No. 123, Jakarta Pusat',
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
            [
                'nama'       => 'PT Digital Inovasi',
                'alamat'     => 'Jl. Sudirman No. 67, Surabaya',
                'telepon'    => '03145678901',
                'email'      => 'hello@digitalinovasi.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'CV Mitra Teknologi',
                'alamat'     => 'Jl. Diponegoro No. 89, Yogyakarta',
                'telepon'    => '02749876543',
                'email'      => 'info@mitrateknologi.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'PT Solusi Digital Indonesia',
                'alamat'     => 'Jl. Gatot Subroto No. 156, Medan',
                'telepon'    => '06132165487',
                'email'      => 'contact@solusidiital.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'CV Kreasi Teknologi',
                'alamat'     => 'Jl. Ahmad Yani No. 234, Semarang',
                'telepon'    => '02478965412',
                'email'      => 'info@kreasiteknologi.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'PT Inovasi Maju Bersama',
                'alamat'     => 'Jl. Thamrin No. 78, Makassar',
                'telepon'    => '04112369874',
                'email'      => 'hello@inovasimaju.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'CV Smart Solution',
                'alamat'     => 'Jl. Pahlawan No. 91, Denpasar',
                'telepon'    => '03615975346',
                'email'      => 'contact@smartsolution.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'PT Teknologi Masa Depan',
                'alamat'     => 'Jl. Pemuda No. 345, Palembang',
                'telepon'    => '07114785236',
                'email'      => 'info@teknologimasadepan.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'CV Digital Kreatif',
                'alamat'     => 'Jl. Veteran No. 512, Malang',
                'telepon'    => '03418529637',
                'email'      => 'hello@digitalkreatif.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
