<?php

use Illuminate\Database\Seeder;
use App\EssayGroup;

class EssayGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('essaygroups')->delete();
    
      	EssayGroup::create([

         'name'         => 		'未分類',
      ]);
    }
}
