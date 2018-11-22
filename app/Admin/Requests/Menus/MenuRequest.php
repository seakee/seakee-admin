<?php
/**
 * File: MenuRequest.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:06
 * Description:
 */

namespace App\Admin\Requests\Menus;


use App\Admin\Requests\Request;

class MenuRequest extends Request
{
	public function rules()
	{
		return $this->rules;
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'icon'       => '菜单图标',
			'name'       => '菜单名称',
			'route_name' => '路由名称',
			'father_id'  => '父ID',
			'sort'       => '排序值',
			'display'    => '是否显示',
		];
	}

	protected $rules = [
		'icon'       => 'required',
		'name'       => 'required',
		'route_name' => 'required|route_exists',
		'father_id'  => 'required',
		'sort'       => 'numeric',
		'display'    => 'required',
	];
}