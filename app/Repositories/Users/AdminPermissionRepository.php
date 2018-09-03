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
	 * @param array $where
	 *
	 * @return bool
	 */
	public function update(array $data, array $where):bool
	{
		return $this->permission->where($where)->update($data);
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
}