<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProdiSeeder::class,
            LevelSeeder::class,
            KeahlianSeeder::class,
            UserSeeder::class,
            MahasiswaSeeder::class,
            DosenSeeder::class,
            PeriodeSeeder::class,
            PartnerSeeder::class,
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            LowonganSeeder::class,
            FeedbackSeeder::class,
        ]);
    }
}
