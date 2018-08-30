<?php
/**
 * File: AdminRoleService.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:54
 * Description:
 */

namespace App\Service\User;


use App\Models\Users\AdminRole;
use Cache;
use App\Repository\User\AdminRoleRepository;
use Illuminate\Database\Eloquent\Collection;

class AdminRoleService
{
	/**
	 * @var AdminRoleRepository
	 */
	protected $roleRepository;

	/**
	 * AdminRoleService constructor.
	 *
	 * @param AdminRoleRepository $roleRepository
	 */
	public function __construct(AdminRoleRepository $roleRepository)
	{
		$this->roleRepository = $roleRepository;
	}

	/**
	 * @param array $data
	 *
	 * @return AdminRole
	 */
	public function create(array $data): AdminRole
	{
		return $this->roleRepository->store($data);
	}

	/**
	 * @param array $data
	 * @param array $where
	 *
	 * @return bool
	 */
	public function edit(array $data, array $where): bool
	{
		return $this->roleRepository->update($data, $where);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return int
	 */
	public function delete($ids): int
	{
		return $this->roleRepository->destroy($ids);
	}

	/**
	 * @param $user
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function current($user): Collection
	{
		return Cache::remember('admin.roles.' . $user->id, config('cache.ttl'), function () use ($user) {
			return $user->roles;
		});
	}
}