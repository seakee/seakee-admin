<?php
/**
 * File: MenuController.php * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/9/4 16:11
 * Description:
 */

namespace App\Admin\Controllers\Menus;


use App\Admin\Requests\Menus\MenuRequest;
use App\Http\Controllers\Controller;
use App\Services\Menus\{MenuService};
use Illuminate\Http\Request;

class MenuController extends Controller
{
	/**
	 * @var MenuService
	 */
	protected $menuService;

	/**
	 * UserController constructor.
	 *
	 * @param MenuService $menuService
	 */
	public function __construct(MenuService $menuService)
	{
		$this->menuService = $menuService;
	}

	/**
	 * @return array|string
	 */
	public function index()
	{
		$menus = $this->menuService->all();

		return $this->menuService->tree($menus);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function paginate(Request $request)
	{
		return $this->menuService->paginate($request);
	}

	/**
	 * @param MenuRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(MenuRequest $request)
	{
		$menu = $this->menuService->create($request);

		if (empty($menu)){
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
		return $this->menuService->find($id);
	}

	/**
	 * @param string      $id
	 * @param MenuRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(string $id, MenuRequest $request)
	{
		$rs = $this->menuService->edit($request, $id);

		if (empty($rs)){
			return response()->json(['error' => 'updates failed'], 500);
		}

		clear_cache(['admin.permissions.' . $id, 'admin.roles.' . $id]);

		return response()->json(['msg' => 'success'],201);
	}

	/**
	 * @param string $ids
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(string $ids)
	{
		$rs = $this->menuService->delete($ids);

		return $rs ? response()->json(['msg' => 'success'],204) : response()->json(['error' => 'destruction failed'], 500);
	}
}