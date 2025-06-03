<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path('database/seeders/data/kabupaten_kota.csv');
        if (!file_exists($file)) {
            echo "File regencies.csv tidak ditemukan!\n";
            return;
        }

        $handle = fopen($file, 'r');
        $header = fgetcsv($handle); // skip header, default delimiter koma

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 5) continue; // skip baris tidak valid/kurang kolom
            DB::table('m_kota_kabupaten')->insert([
                'kabupaten_id' => $row[0],
                'provinsi_id' => $row[1],
                'nama' => trim($row[2], '"'),
                'lat' => $row[3],
                'lng' => $row[4]
            ]);
        }
        fclose($handle);
    }
}