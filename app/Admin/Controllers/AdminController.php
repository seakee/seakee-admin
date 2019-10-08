<?php
/**
 * File: AdminController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/21 17:20
 * Description:
 */

namespace Admin\Controllers;

use App\Http\Controllers\Controller;
use Arr;

class AdminController extends Controller
{
	public function index()
	{
	    $config = config('admin');
        Arr::forget($config, 'route');

	    $data['config'] = $config;

		return view('admin', $data);
	}
}
