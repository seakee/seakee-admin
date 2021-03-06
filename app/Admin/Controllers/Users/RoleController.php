<?php
/**
 * File: RoleController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:08 上午
 * Description:
 */

namespace Admin\Controllers\Users;


use Admin\Requests\Users\RoleRequest;
use App\Http\Controllers\Controller;
use App\Services\Admin\Users\{RoleService, PermissionService};
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * RoleController constructor.
     *
     * @param RoleService       $roleService
     * @param PermissionService $permissionService
     */
    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService       = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        return $this->roleService->paginate($request);
    }

    /**
     * @param RoleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $user = $this->roleService->create($request);

        if (empty($user)){
            return json_response(500, trans('error.create_failed'));
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
        return $this->roleService->find($id);
    }

    /**
     * @param string      $id
     * @param RoleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $id, RoleRequest $request)
    {
        $rs = $this->roleService->edit($request, $id);

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
        $rs = $this->roleService->delete($ids);

        if (empty($rs)){
            return json_response(500, trans('error.destroy_failed'));
        }

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return json_response(204);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPermissions(string $id)
    {
        $role = $this->roleService->find($id);

        if (empty($role)){
            return json_response(404, trans('error.not_found'));
        }

        if (in_array('Super_Admin', $role->toArray())){
            $permission = $this->permissionService->all();
        } else {
            $permission = $role->permissions;
        }

        return json_response(200, 'success', $permission);
    }

    /**
     * @param string  $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncPermissions(string $id, Request $request)
    {
        $permIds = array_filter(explode(",", $request->input('permission_ids')));
        $role    = $this->roleService->find($id);

        $this->permissionService->find($permIds);

        $rs = $role->permissions()->sync($permIds);

        if (empty($rs)){
            return json_response(500, trans('error.grant_permission_failed'));
        }

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return json_response(201);
    }
}
