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
            return json_response(500, trans('error.create_failed'));
        }

        clear_cache('menus');

        return json_response(201);
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
            return json_response(500, trans('error.update_failed'));
        }

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
        $rs = $this->menuService->delete($ids);

        clear_cache('menus');

        return $rs ? json_response(204) : json_response(500, trans('error.destroy_failed'));
    }
}
