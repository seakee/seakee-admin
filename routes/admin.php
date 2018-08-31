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

Route::prefix('auth')->namespace('Auth')->group(function($router) {
	$router->post('login', 'AuthController@login')->name('admin.login');
	$router->post('logout', 'AuthController@logout')->name('admin.logout');
});

Route::group(['namespace' => 'Users'], function () {
	Route::apiResource('adminUser', 'UserController', ['parameters' => ['adminUser' => 'user_id']]);
});
