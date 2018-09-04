<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
	Route::post('login', 'AuthController@login')->name('admin.login');
	Route::post('logout', 'AuthController@logout')->name('admin.logout');
});

Route::group(['namespace' => 'Users'], function () {
	Route::get('users/{id}/roles','UserController@showRoles')->name('admin.users.roles');
	Route::put('users/{id}/roles','UserController@syncRoles')->name('admin.users.syncRoles');
	Route::apiResource('users', 'UserController', [
		'parameters' => ['users' => 'id'],
		'names'       => [
			'index'   => 'admin.users.index ',
			'store'   => 'admin.users.store ',
			'show'    => 'admin.users.show',
			'update'  => 'admin.users.update',
			'destroy' => 'admin.users.destroy',
		],
	]);

	Route::apiResource('roles', 'RoleController', [
		'parameters' => ['roles' => 'id'],
		'names'       => [
			'index'   => 'admin.roles.index ',
			'store'   => 'admin.roles.store ',
			'show'    => 'admin.roles.show',
			'update'  => 'admin.roles.update',
			'destroy' => 'admin.roles.destroy',
		],
	]);

	Route::apiResource('permissions', 'PermissionController', [
		'parameters' => ['permissions' => 'id'],
		'names'       => [
			'index'   => 'admin.permissions.index ',
			'store'   => 'admin.permissions.store ',
			'show'    => 'admin.permissions.show',
			'update'  => 'admin.permissions.update',
			'destroy' => 'admin.permissions.destroy',
		],
	]);
});
