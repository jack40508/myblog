<?php

use Illuminate\Database\Seeder;
use App\Essaies\Essay;

class EssaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('essaies')->delete();
    
      	Essay::create([

         'name'         => 		'範例文章',
         'writer'		=>		'1',
         'group_id'   		=>		'1',
         'detail'		=>		'此篇文章是範例文章',

      ]);
    }
}
