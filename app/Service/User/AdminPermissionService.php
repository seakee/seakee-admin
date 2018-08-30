<?php
/**
 * File: AdminPermissionService.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:54
 * Description:
 */

namespace App\Service\User;


use App\Models\Users\AdminPermission;
use Cache;
use App\Repository\User\AdminPermissionRepository;

class AdminPermissionService
{
	/**
	 * @var AdminPermissionRepository
	 */
	protected $permissionRepository;

	/**
	 * AdminPermissionService constructor.
	 *
	 * @param AdminPermissionRepository $permissionRepository
	 */
	public function __construct(AdminPermissionRepository $permissionRepository)
	{
		$this->permissionRepository = $permissionRepository;
	}

	/**
	 * @param array $data
	 *
	 * @return AdminPermission
	 */
	public function create(array $data):AdminPermission
	{
		return $this->permissionRepository->store($data);
	}

	/**
	 * @param array $data
	 * @param array $where
	 *
	 * @return bool
	 */
	public function edit(array $data, array $where):bool
	{
		return $this->permissionRepository->update($data, $where);
	}

	public function delete($ids):int
	{
		return $this->permissionRepository->destroy($ids);
	}

	/**
	 * @param $user
	 * @param $roles
	 *
	 * @return array
	 */
	public function current($user, $roles): array
	{
		return Cache::remember('admin.permissions.' . $user->id, config('cache.ttl'), function () use ($roles){
			foreach ($roles as $role){
				$permission[] = array_get($role->permisson->toArray(), 'name');
			}

			return $permission ?? [];
		});
	}

	/**
	 * @return array
	 */
	public function allName(): array
	{
		return Cache::remember('admin.allName', config('cache.ttl'), function (){
			return array_column($this->permissionRepository->all()->toArray(), 'name');
		});
	}
}