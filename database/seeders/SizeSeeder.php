<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $size = [
            ['name' => '38'],
            ['name' => '39'],
            ['name' => '40'],
            ['name' => '41'],
            ['name' => '42'],
        ];
        DB::table('size')->insert($size);
    }
}
