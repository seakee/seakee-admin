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
use Illuminate\Validation\Factory;
use Route;

class UserRequest extends Request
{
	public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null, Factory $factory)
	{
		parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

		$name = 'is_mobile';

		$test = function ($_, $value) {
			return is_phone_number($value);
		};

		$errorMessage = '手机号码不正确';

		$factory->extend($name, $test, $errorMessage);
	}

	public function rules()
	{
		$currentRouteName = Route::currentRouteName();

		$rules = $this->rules;

		if ($currentRouteName == 'admin.users.update') {
			$rules['user_name'] = $rules['user_name'] . ',user_name,' . $this->id;
			$rules['phone']     = $rules['phone'] . ',phone,' . $this->id;
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
			'phone'     => '手机号',
			'email'     => 'E-mail',
		];
	}

	protected $rules =  [
		'user_name' => 'required|string|min:4|max:255|unique:admin_users',
		'email'     => 'required|string|email|max:255|unique:admin_users',
		'phone'     => 'required|is_mobile|unique:admin_users',
		'password'  => 'required|string|min:6|confirmed',
	];
}