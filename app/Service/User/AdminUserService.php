<?php
/**
 * File: AdminUserService.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:53
 * Description:
 */

namespace App\Service\User;


use App\Repository\User\AdminUserRepository;
use App\Models\Users\AdminUser;

class AdminUserService
{
	protected $userRepository;

	public function __construct(AdminUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param array $data
	 *
	 * @return AdminUser
	 */
	public function create(array $data):AdminUser
	{
		return $this->userRepository->store($data);
	}

	/**
	 * @param array $data
	 * @param array $where
	 *
	 * @return bool
	 */
	public function edit(array $data, array $where):bool
	{
		return $this->userRepository->update($data, $where);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return int
	 */
	public function delete($ids):int
	{
		return $this->userRepository->destroy($ids);
	}
}