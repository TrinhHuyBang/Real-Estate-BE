<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_types')->insert([
            ['type' => 'Căn hộ chung cư'],
            ['type' => 'Cao ốc văn phòng'],
            ['type' => 'Trung tâm thương mại'],
            ['type' => 'Khu đô thị mới'],
            ['type' => 'Khu phức hợp'],
            ['type' => 'Nhà ở xã hội'],
            ['type' => 'Khu nghỉ dưỡng, Sinh thái'],
            ['type' => 'Khu công nghiệp'],
            ['type' => 'Biệt thự, liền kề'],
            ['type' => 'Shophouse'],
            ['type' => 'Nhà mặt phố'],
            ['type' => 'Dự án khác'],
        ]);
    }
}
