<?php
/**
 * File: PermissionController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:03 上午
 * Description:
 */

namespace Admin\Controllers\Users;


use Admin\Requests\Users\PermissionRequest;
use App\Services\Admin\Users\PermissionService;
use Illuminate\Http\Request;

class PermissionController
{
    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * PermissionController constructor.
     *
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
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
            return response()->json(['message' => 'creates failed'], 500);
        }

        clear_cache('permissions');

        return response()->json(['message' => 'success'],201);
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
            return response()->json(['message' => 'updates failed'], 500);
        }

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
        $rs = $this->permissionService->delete($ids);

        if (empty($rs)){
            return response()->json(['message' => 'destruction failed'], 500);
        }

        clear_cache('permissions');
        clear_cache('menus');

        return response()->json(['message' => 'success'],204);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function createBatch()
    {
        $routes = \Route::getRoutes()->getRoutesByName();

        $count   = count($routes);
        $failure = 0;
        foreach ($routes as $key => $route){
            if (!in_array($key, $this->permissionService->allName())){
                $data['name'] = $data['display_name'] = $data['description'] = $key;
                if (!$this->permissionService->getPermissionRepository()->store($data)){
                    $failure += 1;
                }
            } else {
                $count --;
            }
        }

        clear_cache('permissions');
        clear_cache('menus');

        return response()->json(['message' => '共新增' . $count . '条权限，其中成功' . ($count - $failure) . '条失败' . $failure . '条'], 201);
    }
}
