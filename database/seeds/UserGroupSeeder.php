<?php

use Illuminate\Database\Seeder;
use App\UserGroup;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('user_groups')->delete();
    
      	UserGroup::create([

         'user_id'		=>		'1',
         'group_id'   		=>		'1',

      ]);
    }
}
