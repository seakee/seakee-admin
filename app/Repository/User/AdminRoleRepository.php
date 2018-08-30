<?php
/**
 * File: AdminRoleRepository.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:50
 * Description:
 */

namespace App\Repository\User;


use App\Models\Users\AdminRole;

class AdminRoleRepository
{
	/**
	 * @var AdminRole
	 */
	protected $role;

	/**
	 * AdminRoleRepository constructor.
	 *
	 * @param AdminRole $role
	 */
	public function __construct(AdminRole $role)
	{
		$this->role = $role;
	}

	/**
	 * @param array $data
	 *
	 * @return AdminRole
	 */
	public function store(array $data):AdminRole
	{
		return $this->role->create($data);
	}

	/**
	 * @param array $data
	 * @param array $where
	 *
	 * @return bool
	 */
	public function update(array $data, array $where)
	{
		return $this->role->where($where)->update($data);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return int
	 */
	public function destroy($ids)
	{
		return $this->role->destroy($ids);
	}
}