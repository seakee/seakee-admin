<?php
/**
 * File: UserController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:48
 * Description:
 */

namespace App\Admin\Controllers\Users;


use App\Admin\Requests\User\UserRequest;
use App\Http\Controllers\Controller;
use App\Service\User\AdminUserService;

class UserController extends Controller
{
	protected $userService;

	public function __construct(AdminUserService $userService)
	{
		$this->userService = $userService;
	}

	public function store(UserRequest $request)
	{
		$params = $request->all();

		$params['password'] = bcrypt($params['password']);

		$user = $this->userService->create($params);

		if (empty($user)){
			return response()->json(['msg' => 'registration failed'], 500);
		}

		return response()->json(['msg' => 'success']);
	}
}