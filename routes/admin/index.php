<?php
/**
 * File: index.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/27 10:08 上午
 * Description: Admin Routes
 * --------------------------------------------------------------------------
 * Here is where you can register Admin routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "Admin" middleware group. Now create something great!
 * --------------------------------------------------------------------------
 */

$config = config('admin.route');

Route::get('/', 'AdminController@index')
    ->middleware('web')
    ->name('admin.index');

Route::prefix('api')
    ->middleware($config['middleware'])
    ->group(function () {
        Route::prefix('v1')->group(base_path('routes/admin/v1.php'));
    });
