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
            ['nama' => 'Web Development', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Content Writing', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Digital Marketing', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Data Analysis', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Data Science', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Frontend Development', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'UI/UX Design', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Mobile Development', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Quality Assurance', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'DevOps', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Network Administration', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Cybersecurity', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('m_keahlian')->insert($keahlian);
    }
}
