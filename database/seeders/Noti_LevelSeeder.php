<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Noti_LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notilevel = [
            ['name' => 'Oder'],
            ['name' => 'Comment'],
        ];
        DB::table('notiLevel')->insert($notilevel);
    }
}
