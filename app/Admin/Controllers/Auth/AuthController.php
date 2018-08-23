<?php
/**
 * File: AuthController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/22 14:18
 * Description:
 */

namespace App\Admin\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	/**
	 * Get a JWT token via given credentials.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request)
	{
		//$params = ['user_name' => 'admin', 'password' => 'admin123456'];
		$rules = [
			'user_name'   => [
				'required',
				'exists:admin_users',
			],
			'password' => 'required|string|min:6|max:20',
		];

		// 验证参数，如果验证失败，则会抛出 ValidationException 的异常
		$params = $this->validate($request, $rules);

		// 使用 Auth 登录用户，如果登录成功，则返回 201 的 code 和 token，如果登录失败则返回
		return ($token = Auth::guard('admin')->attempt($params))
			? response(['token' => 'bearer ' . $token], 201)
			: response(['error' => '账号或密码错误'], 400);
	}

	/**
	 * 处理用户登出逻辑
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
		Auth::guard('admin')->logout();

		return response(['message' => '退出成功']);
	}
}