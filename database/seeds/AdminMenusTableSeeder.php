<?php
/**
 * File: AdminMenusTableSeeder.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 1:41 下午
 * Description:
 */

use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-home',
            'name' => '管理中心',
            'route_name' => '#',
            'path' => '/managerCenter',
            'father_id' => -1,
            'sort' => 99,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-users',
            'name' => '用户中心',
            'route_name' => '#',
            'path' => '/userCenter',
            'father_id' => -1,
            'sort' => 98,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-dashboard',
            'name' => '仪表盘',
            'route_name' => 'admin.dashboard.index',
            'path' => '/managerCenter/dashboard/index',
            'father_id' => 1,
            'sort' => 10,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-gears',
            'name' => '系统配置',
            'route_name' => 'admin.config.index',
            'path' => '/managerCenter/config/index',
            'father_id' => 1,
            'sort' => 9,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-list-ul',
            'name' => '菜单管理',
            'route_name' => 'admin.menus.index',
            'path' => '/managerCenter/menus/index',
            'father_id' => 1,
            'sort' => 8,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-folder',
            'name' => '文件管理',
            'route_name' => 'admin.file.index',
            'path' => '/managerCenter/file/index',
            'father_id' => 1,
            'sort' => 7,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-user',
            'name' => '用户管理',
            'route_name' => 'admin.user.index',
            'path' => '/userCenter/users/index',
            'father_id' => 2,
            'sort' => 10,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-address-card',
            'name' => '角色管理',
            'route_name' => 'admin.role.index',
            'path' => '/userCenter/roles/index',
            'father_id' => 2,
            'sort' => 9,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('admin_menus')->insert([
            'icon' => 'fas fa-user-lock',
            'name' => '权限管理',
            'route_name' => 'admin.permission.index',
            'path' => '/userCenter/permissions/index',
            'father_id' => 2,
            'sort' => 8,
            'display' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}