<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keahlian = [
            ['nama' => 'Web Development'],
            ['nama' => 'Data Science'],
            ['nama' => 'Machine Learning'],
            ['nama' => 'Mobile Development'],
            ['nama' => 'Cybersecurity'],
            ['nama' => 'Cloud Computing'],
            ['nama' => 'UI/UX Design'],
            ['nama' => 'Game Development'],
            ['nama' => 'DevOps'],
            ['nama' => 'Blockchain Technology'],
            ['nama' => 'Artificial Intelligence'],
        ];

        DB::table('m_keahlian')->insert($keahlian);
    }
}
