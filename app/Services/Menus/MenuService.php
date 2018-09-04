<?php
/**
 * File: MenuService.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/9/4 16:16
 * Description:
 */

namespace App\Services\Menus;

use App\Repositories\Menu\MenuRepository;
use App\Models\Menus\Menu;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
	public function create(Request $request):Menu
	{
		$data = filter_request_params(['icon', 'name', 'route_name', 'father_id', 'sort', 'display'], $request);

		return $this->menuRepository->store($data);
	}

	/**
	 * @param Request $request
	 * @param int     $id
	 *
	 * @return bool
	 */
	public function edit(Request $request, int $id):bool
	{
		$data = filter_request_params(['icon', 'name', 'route_name', 'father_id', 'sort', 'display'], $request);

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
		$where   = filter_request_params(['name', 'route_name', 'display',], $request);
		$perPage = $request->get('per_page', 15);
		$page    = $request->get('page', 1);

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
}