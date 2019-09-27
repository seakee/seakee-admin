<?php
/**
 * File: AdminUsersRoleSeeder.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 1:43 下午
 * Description:
 */

use App\Models\Users\{AdminRole, AdminUser};
use Illuminate\Database\Seeder;

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
        $role = new AdminRole();

        $role->name         = 'Super_Admin';
        $role->display_name = '超级管理员';
        $role->description  = '超级管理员，拥有所有权限';

        $role->save();

        //初始化管理员
        $user = new AdminUser();

        $user->user_name = 'admin';
        $user->email     = 'admin@admin.com';
        $user->mobile    = '18888888888';
        $user->rank      = 1;
        $user->password  = bcrypt('admin123456');

        $user->save();

        if (!$user->save()) {
            Log::info('Unable to create user ' . $user->user_name, (array)$user->errors());
        } else {
            Log::info('Created user "' . $user->user_name . '" <' . $user->email . '>');
        }

        //授权
        $user->roles()->attach($role->id);
    }
}
