<?php

use Illuminate\Database\Seeder;
use App\Models\Users\AdminRole as Role;
use App\Models\Users\AdminUser as User;

class AdminUsersRoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//初始化权限
		$role = new Role();

		$role->name         = 'Super_Admin';
		$role->display_name = '超级管理员';
		$role->description  = '超级管理员，拥有所有权限';

		$role->save();

		//初始化管理员
		$user = new User();

		$user->user_name = 'admin';
		$user->email     = 'admin@admin.com';
		$user->phone     = '18888888888';
		$user->rank      = 1;
		$user->password  = bcrypt('admin123456');

		$user->save();

		if (!$user->save()) {
			Log::info('Unable to create user ' . $user->username, (array)$user->errors());
		} else {
			Log::info('Created user "' . $user->username . '" <' . $user->email . '>');
		}

		//授权
		$user->roles()->attach($role->id);
	}
}
