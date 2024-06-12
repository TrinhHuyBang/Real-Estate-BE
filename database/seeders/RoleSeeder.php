<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'post_manager'],
            ['id' => 2, 'name' => 'project_manager'],
            ['id' => 3, 'name' => 'news_manager'],
            ['id' => 4, 'name' => 'user_account_manager'],
        ]);
    }
}
