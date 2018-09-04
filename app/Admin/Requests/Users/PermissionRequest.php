<?php
/**
 * File: RoleRequest.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:06
 * Description:
 */

namespace App\Admin\Requests\Users;


use App\Admin\Requests\Request;
use Illuminate\Validation\Factory;
use Route;

class PermissionRequest extends Request
{
	public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null, Factory $factory)
	{
		parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

		$name = 'route_exists';

		$test = function ($_, $value) {
			return Route::getRoutes()->hasNamedRoute($value);
		};

		$errorMessage = '路由不存在';

		$factory->extend($name, $test, $errorMessage);
	}

	public function rules()
	{
		$currentRouteName = Route::currentRouteName();

		$rules = $this->rules;

		if ($currentRouteName == 'admin.permissions.update') {
			$rules['name'] = $rules['name'] . ',name,' . $this->id;
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
			'name'         => '权限标识',
			'display_name' => '权限名称',
			'description'  => '权限描述',
		];
	}

	protected $rules = [
		'name'         => 'required|string|max:255|route_exists|unique:admin_permissions',
		'display_name' => 'required|string|max:255',
		'description'  => 'required|string|max:255',
	];
}