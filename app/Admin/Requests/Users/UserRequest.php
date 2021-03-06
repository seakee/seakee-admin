<?php
/**
 * File: UserRequest.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:11 上午
 * Description:
 */

namespace Admin\Requests\Users;


use Admin\Requests\Request;
use Route;

class UserRequest extends Request
{
    /**
     * @return array
     */
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

        //更改用户状态时不验证其他字段
        if (isset($this->status)) {
            return [];
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

    protected $rules = [
        'user_name' => 'required|string|min:5|max:15|unique:admin_users',
        'email'     => 'required|string|email|max:255|unique:admin_users',
        'mobile'    => 'required|mobile|unique:admin_users',
        'password'  => 'required|string|min:8|max:16|confirmed',
    ];
}
