<?php
/**
 * File: MenuService.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 3:59 下午
 * Description:
 */

namespace App\Services\Admin\Menus;


use App\Models\Menus\Menu;
use App\Repositories\Admin\Menus\MenuRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Cache;
use Arr;

class MenuService
{
    /**
     * @var MenuRepository
     */
    protected $menuRepository;

    /**
     * MenuService constructor.
     *
     * @param MenuRepository $menuRepository
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @return MenuRepository
     */
    public function getMenuRepository(): MenuRepository
    {
        return $this->menuRepository;
    }

    /**
     * @param MenuRepository $menuRepository
     */
    public function setMenuRepository(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @param Request $request
     *
     * @return Menu
     */
    public function create(Request $request): Menu
    {
        $data = filter_request_params(['icon', 'name', 'route_name', 'path', 'father_id', 'sort', 'display'], $request);

        return $this->menuRepository->store($data);
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return bool
     */
    public function edit(Request $request, int $id): bool
    {
        $data = filter_request_params(['icon', 'name', 'route_name', 'path', 'father_id', 'sort', 'display'], $request);

        return $this->menuRepository->update($data, $id);
    }

    /**
     * @param string $ids
     *
     * @return int
     */
    public function delete($ids): int
    {
        $ids = explode(',', $ids);

        return $this->menuRepository->destroy($ids);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(Request $request): LengthAwarePaginator
    {
        $where = filter_request_params(['name', 'route_name', 'path', 'display',], $request);
        $perPage = $request->get('per_page', 15);
        $page = $request->get('page', 1);

        return $this->menuRepository->paginate($where, $perPage, $page);
    }

    /**
     * @param array|int $ids
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find($ids)
    {
        return $this->menuRepository->find($ids);
    }

    /**
     * @return array
     */
    public function list(): array
    {
        return $this->menuRepository->list()->toArray();
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return Cache::remember('admin.allMenus', config('cache.ttl'), function () {
            return $this->menuRepository->all()->toArray();
        });
    }

    /**
     * @param $currentPermission
     * @param $user
     *
     * @return mixed
     */
    public function current($currentPermission, $user)
    {
        return Cache::remember('admin.menus.' . $user->id, config('cache.ttl'), function () use ($currentPermission, $user) {
            $allMenu = $this->all();
            $roles   = array_column($user->roles->toArray(), 'name');

            $currentUserMenu = [];
            if (!in_array('Super_Admin', $roles)) {
                foreach ($allMenu as $menu) {
                    if (in_array($menu['route_name'], $currentPermission)) {
                        //查找父菜单
                        if ($menu['father_id'] != -1) {
                            foreach ($allMenu as $m) {
                                if ($menu['father_id'] == $m['id']) {
                                    $currentUserMenu[] = $m;
                                }
                            }
                        }
                        $currentUserMenu[] = $menu;
                    }
                }
            } else {
                $currentUserMenu = $allMenu;
            }

            //过滤重复菜单
            $currentUserMenu = array_filter_repeat($currentUserMenu, 'id');

            return $currentUserMenu;
        });
    }

    /**
     * 获取菜单树形数组
     *
     * @param $menus
     * @param bool $simple
     * @param int $father_id
     *
     * @return array
     */
    public function tree($menus, $simple = false, $father_id = -1)
    {
        return $this->setMenuTree($menus, $father_id, $simple);
    }

    /**
     * 设置菜单树形数组
     *
     * @param $menus
     * @param $father_id
     * @param $simple
     *
     * @return array
     */
    protected function setMenuTree(&$menus, $father_id, $simple)
    {
        if (!empty($menus)) {
            foreach ($menus as $menu) {
                if ($menu['father_id'] == $father_id) {
                    $nodes = $this->setMenuTree($menus, $menu['id'], $simple);
                    if ($simple){
                        $menu = Arr::only($menu, ['icon', 'name', 'route_name', 'path']);
                    }
                    $result[] = empty($nodes) ? $menu : array_merge($menu, ['nodes' => $nodes]);
                }
            }
        }

        return $result ?? [];
    }
}
