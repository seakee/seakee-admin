<?php
/**
 * File: PermissionController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:48
 * Description:
 */

namespace App\Admin\Controllers\Permissions;


use App\Admin\Requests\Users\PermissionRequest;
use App\Http\Controllers\Controller;
use App\Services\Users\AdminPermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
	/**
	 * @var AdminPermissionService
	 */
	protected $permissionService;

	/**
	 * PermissionController constructor.
	 *
	 * @param AdminPermissionService $permissionService
	 */
	public function __construct(AdminPermissionService $permissionService)
	{
		$this->permissionService = $permissionService;
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function index(Request $request)
	{
		return $this->permissionService->paginate($request);
	}

	/**
	 * @param PermissionRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(PermissionRequest $request)
	{
		$permission = $this->permissionService->create($request);

		if (empty($permission)){
			return response()->json(['error' => 'registration failed'], 500);
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
		return $this->permissionService->find($id);
	}

	/**
	 * @param string      $id
	 * @param PermissionRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(string $id, PermissionRequest $request)
	{
		$rs = $this->permissionService->edit($request, $id);

		if (empty($rs)){
			return response()->json(['error' => 'update failed'], 500);
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
		$rs = $this->permissionService->delete($ids);

		return $rs ? response()->json(['msg' => 'success'],204) : response()->json(['error' => 'failed'], 500);
	}
}