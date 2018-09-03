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
use App\Services\Users\AdminRoleService;
use Illuminate\Http\Request;
use App\Admin\Requests\Users\RoleRequest;

class RoleController extends Controller
{
	protected $roleService;
	
	public function __construct(AdminRoleService $roleService)
	{
		$this->roleService = $roleService;
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
			return response()->json(['error' => 'registration failed'], 500);
		}

		return response()->json(['msg' => 'success']);
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
			return response()->json(['error' => 'update failed'], 500);
		}

		return response()->json(['msg' => 'success']);
	}

	/**
	 * @param string $ids
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(string $ids)
	{
		$rs = $this->roleService->delete($ids);

		return $rs ? response()->json(['msg' => 'success']) : response()->json(['error' => 'failed'], 500);
	}
}