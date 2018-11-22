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
	    $this->call(AdminMenusTableSeeder::class);
	    $this->call(AdminUsersRoleSeeder::class);
    }
}
