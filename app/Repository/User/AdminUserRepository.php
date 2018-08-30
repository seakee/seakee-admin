<?php
/**
 * File: AdminUserRepository.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:49
 * Description:
 */

namespace App\Repository\User;


use App\Models\Users\AdminUser;

class AdminUserRepository
{
	/**
	 * @var AdminUser
	 */
	protected $user;

	/**
	 * AdminUserRepository constructor.
	 *
	 * @param AdminUser $user
	 */
	public function __construct(AdminUser $user)
	{
		$this->user = $user;
	}

	/**
	 * @param array $data
	 *
	 * @return AdminUser
	 */
	public function store(array $data): AdminUser
	{
		return $this->user->create($data);
	}

	/**
	 * @param array $data
	 * @param array $where
	 *
	 * @return bool
	 */
	public function update(array $data, array $where):bool
	{
		return $this->user->where($where)->update($data);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return int
	 */
	public function destroy($ids):int
	{
		return $this->user->destroy($ids);
	}
}