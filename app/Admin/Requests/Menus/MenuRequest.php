<?php
/**
 * File: MenuRequest.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 3:55 下午
 * Description:
 */

namespace Admin\Requests\Menus;


use Admin\Requests\Request;

class MenuRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        //更改显示状态时不验证其他字段
        if (isset($this->display)) {
            return [];
        }

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
            'route_name' => '路由标识',
            'father_id'  => '上级菜单',
            'sort'       => '排序值',
            'display'    => '是否显示',
            'path'       => '前端路径',
        ];
    }

    protected $rules = [
        'icon'       => 'required',
        'name'       => 'required',
        'route_name' => 'required|route_exists',
        'father_id'  => 'required',
        'sort'       => 'numeric',
        'display'    => 'required',
        'path'       => 'required',
    ];
}
