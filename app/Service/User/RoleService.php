<?php
/**
 * File: RoleService.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:54
 * Description:
 */

namespace App\Service\User;


use App\Repository\User\AdminRoleRepository;

class RoleService
{
	protected $roleRepository;

	public function __construct(AdminRoleRepository $roleRepository)
	{
		$this->roleRepository = $roleRepository;
	}

	public function create(array $data)
	{
		$this->roleRepository->store($data);
	}

	public function edit(array $data, array $where)
	{
		$this->roleRepository->update($data, $where);
	}

	public function delete($ids)
	{
		$this->roleRepository->destroy($ids);
	}
}