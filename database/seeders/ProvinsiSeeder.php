<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path('database/seeders/data/provinsi.csv');
        if (!file_exists($file)) {
            echo "File provinsi.csv tidak ditemukan!\n";
            return;
        }

        $handle = fopen($file, 'r');
        $header = fgetcsv($handle); // skip header

        while (($row = fgetcsv($handle)) !== false) {
            // Hilangkan tanda kutip jika ada
            $provinsi_id = trim($row[0], '"');
            $nama = trim($row[1], '"');

            DB::table('m_provinsi')->insert([
                'provinsi_id' => $provinsi_id,
                'nama' => $nama,
            ]);
        }
        fclose($handle);
    }
}