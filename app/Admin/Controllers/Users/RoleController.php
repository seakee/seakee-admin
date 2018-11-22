<?php
/**
 * File: RoleController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/9/3 14:47
 * Description:
 */

namespace App\Admin\Controllers\Users;


use App\Http\Controllers\Controller;
use App\Services\Users\{AdminRoleService, AdminPermissionService};
use Illuminate\Http\Request;
use App\Admin\Requests\Users\RoleRequest;

class RoleController extends Controller
{
	/**
	 * @var AdminRoleService
	 */
	protected $roleService;

	/**
	 * @var AdminPermissionService
	 */
	protected $permissionService;

	/**
	 * RoleController constructor.
	 *
	 * @param AdminRoleService       $roleService
	 * @param AdminPermissionService $permissionService
	 */
	public function __construct(AdminRoleService $roleService, AdminPermissionService $permissionService)
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
			return response()->json(['error' => 'creates failed'], 500);
		}

		return response()->json(['msg' => 'success'],201);
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
			return response()->json(['error' => 'updates failed'], 500);
		}

		return response()->json(['msg' => 'success'],201);
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
			return response()->json(['error' => 'destruction failed'], 500);
		}

		return response()->json(['msg' => 'success'],204);
	}

	/**
	 * @param string $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showPermissions(string $id)
	{
		$role    = $this->roleService->find($id);

		if (empty($user)){
			return response()->json(['error' => 'not found'], 404);
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
		$permIds = explode(",", $request->input('permission_ids'));
		$role    = $this->roleService->find($id);

		$this->permissionService->find($permIds);

		$rs = $role->permissions()->sync($permIds);

		if (empty($rs)){
			return response()->json(['error' => 'sync failed'], 500);
		}

		clear_cache(['admin.permissions.' . $id, 'admin.allPermissionNames']);

		return response()->json(['msg' => 'success'],201);
	}
}