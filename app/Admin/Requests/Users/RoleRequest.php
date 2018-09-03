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
use Route;

class RoleRequest extends Request
{
	public function rules()
	{
		$currentRouteName = Route::currentRouteName();

		$rules = $this->rules;

		if ($currentRouteName == 'admin.roles.update') {
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
			'name'         => '角色标识',
			'display_name' => '角色名称',
			'description'  => '角色描述',
		];
	}

	protected $rules = [
		'name'         => 'required|string|max:255|unique:admin_roles',
		'display_name' => 'required|string|max:255',
		'description'  => 'required|string|max:255',
	];
}