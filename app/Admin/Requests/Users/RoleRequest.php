<?php
/**
 * File: RoleRequest.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:07 上午
 * Description:
 */

namespace Admin\Requests\Users;


use Admin\Requests\Request;
use Route;

class RoleRequest extends Request
{
    /**
     * @return array
     */
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
