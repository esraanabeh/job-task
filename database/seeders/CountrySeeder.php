<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id'=>1,'name'=>'egypt','code'=>'+20'],
            ['id'=>2,'name'=>'saudi','code'=>'+966'],
            ['id'=>3,'name'=>'kwit','code'=>'+877'],
           
    
          ];
          Country::insert($data);
    }
}
