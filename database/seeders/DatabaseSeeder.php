<?php

namespace Database\Seeders;

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
        // $this->call(CountrySeeder::class);
        // $this->call(CategoriesSeeder::class);
        // $this->call(UserSeeder::class);
        $this->call(PostsSeeder::class);
    }
}
