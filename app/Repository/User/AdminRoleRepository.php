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
	protected $role;

	public function __construct(AdminRole $role)
	{
		$this->role = $role;
	}

	public function store(array $data)
	{
		return $this->role->create($data);
	}

	public function update(array $data, array $where)
	{
		return $this->role->where($where)->update($data);
	}

	public function destroy($ids)
	{
		return $this->role->destroy($ids);
	}
}