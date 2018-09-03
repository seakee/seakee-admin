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
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

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
	 * @param Request $request
	 *
	 * @return AdminRole
	 */
	public function create(Request $request): AdminRole
	{
		$data = filter_request_params(['name', 'display_name', 'description'], $request);

		return $this->roleRepository->store($data);
	}

	/**
	 * @param Request $request
	 * @param int     $id
	 *
	 * @return bool
	 */
	public function edit(Request $request, int $id): bool
	{
		$data = filter_request_params(['name', 'display_name', 'description'], $request);

		return $this->roleRepository->update($data, $id);
	}

	/**
	 * @param string $ids
	 *
	 * @return int
	 */
	public function delete($ids): int
	{
		$ids = explode(',', $ids);

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

		return $this->roleRepository->paginate($where, $perPage, $page);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function find($ids)
	{
		return $this->roleRepository->find($ids);
	}
}