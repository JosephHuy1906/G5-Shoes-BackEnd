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
            CategorySeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
            LevelSeeder::class,
            StatusSeeder::class,
            NotiLevelSeeder::class,
        ]);
    }
}
