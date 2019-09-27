<?php
/**
 * File: Request.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:04 上午
 * Description:
 */

namespace Admin\Requests;


use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
