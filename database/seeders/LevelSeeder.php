<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $level = [
            ['name' => 'Admin'],
            ['name' => 'User'],
        ];
        DB::table('level')->insert($level);
    }
}
