<?php
/**
 * File: AdminPermissionRepository.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:50
 * Description:
 */

namespace App\Repositories\Users;


use App\Models\Users\AdminPermission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminPermissionRepository
{
	/**
	 * @var AdminPermission
	 */
	protected $permission;

	/**
	 * AdminPermissionRepository constructor.
	 *
	 * @param AdminPermission $permission
	 */
	public function __construct(AdminPermission $permission)
	{
		$this->permission = $permission;
	}

	/**
	 * @param array $data
	 *
	 * @return AdminPermission
	 */
	public function store(array $data): AdminPermission
	{
		return $this->permission->create($data);
	}

	/**
	 * @param array $data
	 * @param int   $id
	 *
	 * @return bool
	 */
	public function update(array $data, int $id):bool
	{
		return $this->permission->where('id', $id)->update($data);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return int
	 */
	public function destroy($ids):int
	{
		return $this->permission->destroy($ids);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all(): Collection
	{
		return $this->permission->all();
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
		return $this->permission->where($where)->paginate($perPage,['id', 'name', 'display_name', 'description', 'created_at'],'page', $page);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function find($ids)
	{
		return $this->permission->findOrFail($ids, ['id', 'name', 'display_name', 'description', 'created_at']);
	}
}