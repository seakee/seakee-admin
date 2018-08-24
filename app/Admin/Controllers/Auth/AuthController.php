<?php
/**
 * File: AuthController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/22 14:18
 * Description:
 */

namespace App\Admin\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
	use ThrottlesLogins;

	protected $username = 'account';

	public function login(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		if ($token = $this->attemptLogin($request)) {
			return response()->json(['msg' => 'success', 'token' => 'bearer ' . $token], 201);
		}

		return response()->json(['msg' => trans('auth.failed')], 400);
	}

	/**
	 * 处理用户登出逻辑
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
		Auth::guard('admin')->logout();

		return response()->json(['msg' => 'success'], 200);
	}

	protected function username()
	{
		return $this->username;
	}

	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return void
	 */
	protected function validateLogin(Request $request)
	{
		$this->validate($request, [$this->username() => 'required|string', 'password' => 'required|string',]);
	}

	/**
	 * Attempt to log the user into the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return bool
	 */
	protected function attemptLogin(Request $request)
	{
		return Auth::guard('admin')->attempt($this->credentials($request));
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		$login      = $request->input($this->username());
		$loginField = $this->loginField($login);

		$credentials[$loginField] = $login;
		$credentials['password']  = $request->input('password');

		return $credentials;
	}

	/**
	 * Get the login field
	 *
	 * @param $login
	 *
	 * @return string
	 */
	protected function loginField($login)
	{
		if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
			return 'email';
		}

		if (is_phone_number($login)) {
			return 'phone';
		}

		return 'user_name';
	}
}