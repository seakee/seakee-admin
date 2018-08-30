<?php
/**
 * File: Request.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:05
 * Description:
 */

namespace App\Admin\Requests;


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