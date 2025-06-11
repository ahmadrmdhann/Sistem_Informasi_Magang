<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_user')->insert([
            [
                'username' => 'admin',
                'nama' => 'Administrator',
                'level_id' => 1,
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'dosen1',
                'nama' => 'Moch. Zawaruddin Abdullah, S.ST., M.Kom',
                'level_id' => 2,
                'email' => 'dosen1@example.com',
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'dosen2',
                'nama' => 'Moch. Dusirman, S.ST., M.Kom',
                'level_id' => 2,
                'email' => 'dosen2@example.com',
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'ajul',
                'nama' => 'Dandi Azrul Syahputra',
                'level_id' => 3,
                'email' => 'mahasiswa1@example.com',
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'yanto',
                'nama' => 'Yantos inferno',
                'level_id' => 3,
                'email' => 'mahasiswa2@example.com',
                'password' => Hash::make('qwqwqw'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
