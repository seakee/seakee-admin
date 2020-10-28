<?php
/**
 * File: admin.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 1:48 下午
 * Description: Admin Routes APIs v1
 */

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth',
], function () {
    Route::post('login', 'AuthController@login')->name('admin.login');
    Route::post('logout', 'AuthController@logout')->name('admin.logout');
    Route::get('profile', 'AuthController@profile')->name('admin.profile.show');
    Route::put('profile', 'AuthController@updateProfile')->name('admin.profile.update');
});

Route::group(['namespace' => 'Commons'], function () {
    Route::post('files/avatar', 'FileController@avatar')->name('admin.files.avatar');
});

Route::group(['namespace' => 'Users'], function () {
    Route::get('users/{id}/roles', 'UserController@showRoles')->name('admin.users.roles');
    Route::get('users/{id}/menus', 'UserController@showMenus')->name('admin.users.menus');
    Route::get('users/{id}/permissions', 'UserController@showPermissions')->name('admin.users.permissions');
    Route::put('users/{id}/roles', 'UserController@syncRoles')->name('admin.users.syncRoles');
    Route::apiResource('users', 'UserController', [
        'parameters' => ['users' => 'id'],
        'names'      => [
            'index'   => 'admin.users.index',
            'store'   => 'admin.users.store',
            'show'    => 'admin.users.show',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ],
    ]);

    Route::put('roles/{id}/permissions', 'RoleController@syncPermissions')->name('admin.roles.syncPermissions');
    Route::get('roles/{id}/permissions', 'RoleController@showPermissions')->name('admin.roles.permissions');
    Route::apiResource('roles', 'RoleController', [
        'parameters' => ['roles' => 'id'],
        'names'      => [
            'index'   => 'admin.roles.index',
            'store'   => 'admin.roles.store',
            'show'    => 'admin.roles.show',
            'update'  => 'admin.roles.update',
            'destroy' => 'admin.roles.destroy',
        ],
    ]);

    Route::post('permissions/batch', 'PermissionController@createBatch')->name('admin.roles.createBatch');
    Route::apiResource('permissions', 'PermissionController', [
        'parameters' => ['permissions' => 'id'],
        'names'      => [
            'index'   => 'admin.permissions.index',
            'store'   => 'admin.permissions.store',
            'show'    => 'admin.permissions.show',
            'update'  => 'admin.permissions.update',
            'destroy' => 'admin.permissions.destroy',
        ],
    ]);
});

Route::group(['namespace' => 'Menus'], function () {
    Route::apiResource('menus', 'MenuController', [
        'parameters' => ['menus' => 'id'],
        'names'      => [
            'index'   => 'admin.menus.index',
            'store'   => 'admin.menus.store',
            'show'    => 'admin.menus.show',
            'update'  => 'admin.menus.update',
            'destroy' => 'admin.menus.destroy',
        ],
    ]);
});

Route::group(['namespace' => 'Configs'], function () {
    Route::get('configs', 'ConfigController@index')->name('admin.configs.index');
    Route::put('configs', 'ConfigController@update')->name('admin.configs.update');
});

Route::group(['namespace' => 'Dashboards'], function () {
    Route::get('dashboards', 'DashboardController@index')->name('admin.dashboards.index');
    Route::get('dashboards/server', 'DashboardController@server')->name('admin.dashboards.server');
    Route::get('dashboards/system', 'DashboardController@system')->name('admin.dashboards.system');
});

Route::group(['namespace' => 'Blogs'], function () {
    Route::apiResource('posts', 'PostController', [
        'parameters' => ['posts' => 'id'],
        'names'      => [
            'index'   => 'admin.posts.index',
            'store'   => 'admin.posts.store',
            'show'    => 'admin.posts.show',
            'update'  => 'admin.posts.update',
            'destroy' => 'admin.posts.destroy',
        ],
    ]);
});
