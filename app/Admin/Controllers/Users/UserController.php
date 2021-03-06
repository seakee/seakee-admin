<?php
/**
 * File: UserController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:10 上午
 * Description:
 */

namespace Admin\Controllers\Users;


use Admin\Requests\Users\UserRequest;
use App\Http\Controllers\Controller;
use App\Services\Admin\Menus\MenuService;
use App\Services\Admin\Users\{
    PermissionService, UserService, RoleService
};
use Illuminate\Http\Request;
use Auth, Arr;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * @var MenuService
     */
    protected $menuService;

    /**
     * UserController constructor.
     *
     * @param UserService       $userService
     * @param RoleService       $roleService
     * @param PermissionService $permissionService
     * @param MenuService            $menuService
     */
    public function __construct(UserService $userService, RoleService $roleService,
                                PermissionService $permissionService, MenuService $menuService)
    {
        $this->userService       = $userService;
        $this->roleService       = $roleService;
        $this->permissionService = $permissionService;
        $this->menuService       = $menuService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        return $this->userService->paginate($request);
    }

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request);

        if (empty($user)){
            return json_response(500, trans('error.reg_failed'));
        }

        return json_response(201);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show(string $id)
    {
        return $this->userService->find($id);
    }

    /**
     * @param string      $id
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $id, UserRequest $request)
    {
        $rs = $this->userService->edit($request, $id);

        if (empty($rs)){
            return json_response(500, trans('error.update_failed'));
        }

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return json_response(201);
    }

    /**
     * @param string $ids
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $ids)
    {
        $rs = $this->userService->delete($ids);

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return $rs ? json_response(204) : json_response(500, trans('error.destroy_failed'));
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showRoles(string $id)
    {
        $user = $this->userService->find($id);

        return json_response(200, 'success', $user->roles);
    }

    /**
     * @param string  $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncRoles(string $id, Request $request)
    {
        $roleIds = array_filter(explode(",", $request->input('role_ids')));
        $user    = $this->userService->find($id);

        $this->roleService->find($roleIds);

        $rs = $user->roles()->sync($roleIds);

        if (empty($rs)){
            return json_response(500, trans('error.grant_role_failed'));
        }

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return json_response(201);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showMenus(string $id)
    {
        $user = $this->userService->find($id);

        $permission = $this->permissionService->current($user, $user->roles);

        $menus = $this->menuService->current($permission, $user);

        return json_response(200, 'success', $menus);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPermissions(string $id)
    {
        $user = $this->userService->find($id);

        $permission = $this->permissionService->current($user, $user->roles);

        return json_response(200, 'success', $permission);
    }
}
