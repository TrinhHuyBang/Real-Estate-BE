<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'view_any_post'],
            ['id' => 2, 'name' => 'view_post'],
            ['id' => 3, 'name' => 'update_post'],
            ['id' => 4, 'name' => 'delete_post'],
            ['id' => 5, 'name' => 'view_any_project'],
            ['id' => 6, 'name' => 'view_project'],
            ['id' => 7, 'name' => 'update_project'],
            ['id' => 8, 'name' => 'delete_project'],
            ['id' => 9, 'name' => 'view_any_news'],
            ['id' => 10, 'name' => 'view_news'],
            ['id' => 11, 'name' => 'create_news'],
            ['id' => 12, 'name' => 'update_news'],
            ['id' => 13, 'name' => 'delete_news'],
            ['id' => 14, 'name' => 'view_any_user_account'],
            ['id' => 15, 'name' => 'view_user_account'],
            ['id' => 16, 'name' => 'update_user_account'],
        ]);
    }
}
