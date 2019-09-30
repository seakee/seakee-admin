<?php
/**
 * File: RoleService.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:31 上午
 * Description:
 */

namespace App\Services\Admin\Users;


use App\Models\Users\AdminRole;
use App\Repositories\Admin\Users\RoleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Cache;

class RoleService
{
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * AdminRoleService constructor.
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return RoleRepository
     */
    public function getRoleRepository(): RoleRepository
    {
        return $this->roleRepository;
    }

    /**
     * @param RoleRepository $roleRepository
     */
    public function setRoleRepository(RoleRepository $roleRepository)
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
        $roles = Cache::tags(['admin', 'roles', 'user'])->get($user->id) ?: [];

        if (empty($roles)){
            $roles = $user->roles;
            Cache::tags(['admin', 'roles', 'user',])->put($user->id, $roles, config('cache.ttl'));
        }

        return $roles;
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
