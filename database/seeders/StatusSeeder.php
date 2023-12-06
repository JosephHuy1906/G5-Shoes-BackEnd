<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            ['name' => 'đang chờ xác nhận'],
            ['name' => 'đã xác nhận'],
            ['name' => 'đang giao hàng'],
            ['name' => 'đã giao hàng thành công'],
            ['name' => 'đã huỷ'],
        ];
        DB::table('status')->insert($status);
    }
}
