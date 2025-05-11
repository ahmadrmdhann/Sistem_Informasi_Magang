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
        $data= [
            [
                'user_id' => 1,
                'level_id' => 1,
                'username' => 'admin',
                'email' => 'admin@example.com',
                'nama'  => 'Nahdia Putri Safira',
                'password' => Hash::make('123456'),
            ],
            [
                'user_id' => 2,
                'level_id' => 2,
                'username' => 'adri',
                'email' => 'dosen@example.com',
                'nama'  => 'Mohammad Adri Favian, S.T',
                'password' => Hash::make('123456'),
            ],
            [
                'user_id' => 3,
                'level_id' => 3,
                'username' => 'mahasiswa',
                'email' => 'mahasiswa@example.com',
                'nama'  => 'Dandi Azrul Syahputra',
                'password' => Hash::make('123456'),
            ],


        ];
        DB::table('m_user')->insert($data);

    }
}
