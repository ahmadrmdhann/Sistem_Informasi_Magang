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
            echo "File kabupaten_kota.csv tidak ditemukan!\n";
            return;
        }

        $handle = fopen($file, 'r');
        $header = fgetcsv($handle); // skip header, default delimiter koma

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 5) continue; // skip baris tidak valid/kurang kolom
            
            // Ensure lat and lng are numeric
            $lat = is_numeric($row[3]) ? (float)$row[3] : 0;
            $lng = is_numeric($row[4]) ? (float)$row[4] : 0;
            
            DB::table('m_kota_kabupaten')->insert([
                'kabupaten_id' => $row[0],
                'provinsi_id' => $row[1],
                'nama' => trim($row[2], '"'),
                'lat' => $lat,
                'lng' => $lng,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        fclose($handle);
    }
}