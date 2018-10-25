<?php
/**
 * File: UserRequest.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:06
 * Description:
 */

namespace App\Admin\Requests\Users;


use App\Admin\Requests\Request;
use Route;

class UserRequest extends Request
{
	public function rules()
	{
		$currentRouteName = Route::currentRouteName();

		$rules = $this->rules;

		if ($currentRouteName == 'admin.users.update') {
			$rules['user_name'] = $rules['user_name'] . ',user_name,' . $this->id;
			$rules['mobile']    = $rules['mobile'] . ',mobile,' . $this->id;
			$rules['email']     = $rules['email'] . ',email,' . $this->id;
			$rules['password']  = 'sometimes|' . $rules['password'];
		}

		return $rules;
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'user_name' => '用户名',
			'email'     => 'E-mail',
		];
	}

	protected $rules =  [
		'user_name' => 'required|string|min:4|max:255|unique:admin_users',
		'email'     => 'required|string|email|max:255|unique:admin_users',
		'mobile'    => 'required|mobile|unique:admin_users',
		'password'  => 'required|string|min:6|confirmed',
	];
}