<?php
/**
 * File: MenuRepository.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/9/4 16:15
 * Description:
 */

namespace App\Repositories\Menus;


use App\Models\Menus\Menu;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MenuRepository
{
	/**
	 * @var Menu
	 */
	protected $menu;

	/**
	 * MenuRepository constructor.
	 *
	 * @param Menu $menu
	 */
	public function __construct(Menu $menu)
	{
		$this->menu = $menu;
	}

	/**
	 * @param array $data
	 *
	 * @return Menu
	 */
	public function store(array $data): Menu
	{
		return $this->menu->create($data);
	}

	/**
	 * @param array $data
	 * @param int   $id
	 *
	 * @return bool
	 */
	public function update(array $data, int $id): bool
	{
		return $this->menu->where('id', $id)->update($data);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return int
	 */
	public function destroy($ids): int
	{
		return $this->menu->destroy($ids);
	}

	/**
	 * @param array $where
	 * @param int   $perPage
	 * @param int   $page
	 *
	 * @return LengthAwarePaginator
	 */
	public function paginate(array $where, int $perPage, int $page): LengthAwarePaginator
	{
		return $this->menu->where($where)->paginate($perPage,['id', 'icon', 'menu_name', 'route_name', 'father_id', 'sort', 'display', 'created_at'],'page', $page);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function find($ids)
	{
		return $this->menu->findOrFail($ids, ['id', 'icon', 'menu_name', 'route_name', 'father_id', 'sort', 'display', 'created_at']);
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function all(): Collection
	{
		return $this->menu->where('display', 1)->orderBy('sort', 'desc')->get();
	}
}