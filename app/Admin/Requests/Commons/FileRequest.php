<?php
/**
 * File: FileRequest.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/10/15 4:58 下午
 * Description:
 */

namespace Admin\Requests\Commons;


use Admin\Requests\Request;

class FileRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'avatar' => 'required|image|max:2048',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {

        return [
            'avatar' => '头像文件',
        ];
    }
}
