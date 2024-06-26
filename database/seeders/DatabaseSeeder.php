<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostTypeSeeder::class);
        $this->call(ProjectTypeSeeder::class);
        $this->call(FieldSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostImageSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
