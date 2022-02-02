<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['id'=>1,'title'=>'breaking a new recourd','content'=>'After creating your personal access client' ,'user_id' => 1 , 'category_id' => 1],
            ['id'=>2,'title'=>'breaking a new recourd','content'=>'After  your personal access client' ,'user_id' => 1, 'category_id' => 1],
            ['id'=>3,'title'=>'breaking a new recourd','content'=>' creating your personal access client' ,'user_id' => 1 , 'category_id' => 2],
          
    
          ];
          Post::insert($data);
    }
}
