<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id'=>1,'name'=>'All'],
            ['id'=>2,'name'=>'Football'],
            ['id'=>3,'name'=>'BascetBall'],
            ['id'=>4,'name'=>'Archery'],
    
    
          ];
          Category::insert($data);
    }
}
