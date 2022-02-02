<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id'=>1,'first_name'=>'esraa', 'last_name'=> 'nabeh','phone'=>'0258796' ,'email' => 'esraa@gmail.com' , 'password' => bcrypt('123') , 'view' =>3],
            ['id'=>2,'first_name'=>'esraa1', 'last_name'=> 'nabeh','phone'=>'0258788' ,'email' => 'esraa1@gmail.com' , 'password' => bcrypt('123') , 'view' => 100],
          
    
          ];
          User::insert($data);
    }
}
