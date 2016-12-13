<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //	$this->call(UsersTableSeeder::class);
        $this->call(EssaySeeder::class);
        $this->call(EssayGroupSeeder::class);
        $this->call(UserGroupSeeder::class);
    }
}
