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
            return response()->json(['message' => 'creates failed'], 500);
        }

        return response()->json(['message' => 'success'],201);
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
            return response()->json(['message' => 'updates failed'], 500);
        }

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return response()->json(['message' => 'success'],201);
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
            return response()->json(['message' => 'destruction failed'], 500);
        }

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return response()->json(['message' => 'success'],204);
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
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json($role->permissions);
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
            return response()->json(['message' => 'sync failed'], 500);
        }

        clear_cache('roles');
        clear_cache('permissions');
        clear_cache('menus');

        return response()->json(['message' => 'success'],201);
    }
}
