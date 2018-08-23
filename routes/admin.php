<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('auth')->namespace('Auth')->group(function($router) {
	$router->post('login', 'AuthController@login');
	$router->post('logout', 'AuthController@logout');


});

Route::middleware('refresh.token')->group(function($router) {
	$router->get('profile','HomeController@profile');
});
