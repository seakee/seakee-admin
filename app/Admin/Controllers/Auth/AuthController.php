<?php
/**
 * File: AuthController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 10:25 上午
 * Description:
 */

namespace Admin\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ThrottlesLogins;

    protected $username = 'account';

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        if ($token = $this->attemptLogin($request)) {
            return json_response(201, 'success', ['token' => 'bearer ' . $token]);
        }

        return json_response(400, trans('auth.failed'));
    }

    /**
     * 处理用户登出逻辑
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        return json_response();
    }

    protected function username()
    {
        return $this->username;
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
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

        if (is_mobile_number($login)) {
            return 'mobile';
        }

        return 'user_name';
    }
}
