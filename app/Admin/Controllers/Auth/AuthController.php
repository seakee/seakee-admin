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
use App\Services\Admin\Menus\MenuService;
use App\Services\Admin\Users\PermissionService;
use App\Services\Admin\Users\UserService;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Auth, Arr;

class AuthController extends Controller
{
    use ThrottlesLogins;

    protected $username = 'account';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * @var MenuService
     */
    protected $menuService;

    public function __construct(UserService $userService, PermissionService $permissionService, MenuService $menuService)
    {
        $this->permissionService = $permissionService;
        $this->menuService       = $menuService;
        $this->userService       = $userService;
    }

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
        $this->validate($request, [
            $this->username() => 'required|string',
            'password'        => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
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
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        $login      = $request->input($this->username());
        $loginField = $this->loginField($login);

        $credentials[$loginField] = $login;
        $credentials['status']    = 1;
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

    /**
     * Get the current profile
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $user = $this->userService->current();

        $profile = Arr::only($user->toArray(), [
            'id',
            'user_name',
            'avatar',
            'mobile',
            'email',
        ]);

        $roles      = $user->roles;
        $permission = $this->permissionService->current($user, $roles);
        $menus      = $this->menuService->current($permission, $user);

        $profile['roles'] = array_column($user->roles->toArray(), 'display_name');
        $profile['menus'] = $this->menuService->tree($menus, true);

        return json_response(200, 'success', $profile);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $credentials['password'] = $request->get('password_old');
        $credentials['id']       = Auth::id();
        $token                   = Auth::guard('admin')->attempt($credentials);

        if (!$token) {
            return json_response(400, trans('auth.failed'));
        }

        $request->headers->set('Authorization', 'Bearer ' . $token);

        $request->validate([
            'email'    => 'required|string|email|max:255|unique:admin_users,mobile,' . Auth::id(),
            'mobile'   => 'required|mobile|unique:admin_users,email,' . Auth::id(),
            'password' => 'sometimes|required|string|min:8|max:16|confirmed',
        ]);

        $rs = $this->userService->edit($request, Auth::id());

        if (empty($rs)) {
            return json_response(500, trans('error.update_failed'));
        }

        return json_response(201);
    }
}
