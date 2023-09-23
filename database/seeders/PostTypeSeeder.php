<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_types')->insert([
            ['type' => 'Bán căn hộ chung cư'],
            ['type' => 'Bán nhà riêng'],
            ['type' => 'Bán nhà biệt thự liền kề'],
            ['type' => 'Bán nhà mặt phố'],
            ['type' => 'Bán nhà phố thương mại'],
            ['type' => 'Bán đất nền dự án'],
            ['type' => 'Bán đất'],
            ['type' => 'Bán trang trại, khu nghỉ dưỡng'],
            ['type' => 'Bán condotel'],
            ['type' => 'Bán kho, nhà xưởng'],
            ['type' => 'Bán loại bất động sản khác'],
            ['type' => 'Cho thuê căn hộ chung cư'],
            ['type' => 'Cho thuê nhà riêng'],
            ['type' => 'Cho thuê nhà biệt thự, liền kề'],
            ['type' => 'Cho thuê nhà mặt phố'],
            ['type' => 'Cho thuê nhà thương mại'],
            ['type' => 'Cho thuê nhà trọ, phòng trọ'],
            ['type' => 'Cho thuê văn phòng'],
            ['type' => 'Cho thuê, sang nhượng, cửa hàng, ki ốt'],
            ['type' => 'Cho thuê kho, nhà xưởng, đất'],
            ['type' => 'Cho thuê loại bất động sản khác']
        ]);
    }
}
