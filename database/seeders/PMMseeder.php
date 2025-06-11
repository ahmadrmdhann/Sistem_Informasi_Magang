<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PMMseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_pengajuan_magang')->insert([
            [
                'mahasiswa_id'      => 1,
                'lowongan_id'       => 1,
                'status'            => 'diajukan',
                'tanggal_pengajuan' => Carbon::now(),
                'dosen_id'          => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            
        ]);
    }
}
