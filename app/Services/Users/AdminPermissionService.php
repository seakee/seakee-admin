<?php
/**
 * File: AdminPermissionService.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:54
 * Description:
 */

namespace App\Services\Users;


use App\Models\Users\AdminPermission;
use Cache;
use App\Repositories\Users\AdminPermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
	 * @return AdminPermissionRepository
	 */
	public function getPermissionRepository(): AdminPermissionRepository
	{
		return $this->permissionRepository;
	}

	/**
	 * @param AdminPermissionRepository $permissionRepository
	 */
	public function setPermissionRepository(AdminPermissionRepository $permissionRepository)
	{
		$this->permissionRepository = $permissionRepository;
	}

	/**
	 * @param Request $request
	 *
	 * @return AdminPermission
	 */
	public function create(Request $request):AdminPermission
	{
		$data = filter_request_params(['name', 'display_name', 'description'], $request);

		return $this->permissionRepository->store($data);
	}

	/**
	 * @param Request $request
	 * @param int     $id
	 *
	 * @return bool
	 */
	public function edit(Request $request, int $id):bool
	{
		$data = filter_request_params(['name', 'display_name', 'description'], $request);

		return $this->permissionRepository->update($data, $id);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return int
	 */
	public function delete($ids):int
	{
		$ids = explode(',', $ids);

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
				$permission[] = array_get($role->permissions->toArray(), 'name');
			}

			return $permission ?? [];
		});
	}

	/**
	 * @return array
	 */
	public function allName(): array
	{
		return Cache::remember('admin.allPermissionNames', config('cache.ttl'), function (){
			return array_column($this->permissionRepository->all()->toArray(), 'name');
		});
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function paginate(Request $request): LengthAwarePaginator
	{
		$where   = filter_request_params(['name', 'display_name', 'description'], $request);
		$perPage = $request->get('per_page', 15);
		$page    = $request->get('page', 1);

		return $this->permissionRepository->paginate($where, $perPage, $page);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function find($ids)
	{
		return $this->permissionRepository->find($ids);
	}
}