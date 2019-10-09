<?php
/**
 * File: MenuController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 3:53 下午
 * Description:
 */

namespace Admin\Controllers\Menus;


use Admin\Requests\Menus\MenuRequest;
use App\Http\Controllers\Controller;
use App\Services\Admin\Menus\MenuService;
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
        $menus = $this->menuService->list();

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
            return response()->json(['message' => 'creates failed'], 500);
        }

        clear_cache('menus');

        return response()->json(['message' => 'success'],201);
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
            return response()->json(['message' => 'updates failed'], 500);
        }

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
        $rs = $this->menuService->delete($ids);

        clear_cache('menus');

        return $rs ? response()->json(['message' => 'success'],204) : response()->json(['message' => 'destruction failed'], 500);
    }
}
