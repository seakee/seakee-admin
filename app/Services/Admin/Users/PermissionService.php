<?php
/**
 * File: PermissionService.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:14 上午
 * Description:
 */

namespace App\Services\Admin\Users;


use App\Models\Users\AdminPermission;
use App\Repositories\Admin\Users\PermissionRepository;
use Cache;
use Arr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;


class PermissionService
{
    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * AdminPermissionService constructor.
     *
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return PermissionRepository
     */
    public function getPermissionRepository(): PermissionRepository
    {
        return $this->permissionRepository;
    }

    /**
     * @param PermissionRepository $permissionRepository
     */
    public function setPermissionRepository(PermissionRepository $permissionRepository)
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
        $tags       = ['admin', 'permissions', 'user'];
        $permission = cache_tags($tags, $user->id);

        if (empty($permission)){
            if (in_array('Super_Admin', array_column($roles->toArray(), 'name'))){
                $permission = $this->allName();
            } else {
                foreach ($roles as $role){
                    $permission[] = array_column($role->permissions->toArray(), 'name');
                }
                $permission = array_keys(array_flip(Arr::collapse($permission  ?? [])));
            }

            cache_tags($tags, $user->id, $permission);
        }

        return $permission;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $tags        = ['admin', 'permissions',];
        $permissions = cache_tags($tags, 'all');

        if (empty($permissions)){
            $permissions = $this->permissionRepository->all()->toArray();
            cache_tags($tags, 'all', $permissions);
        }

        return $permissions;
    }

    /**
     * @return array
     */
    public function allName(): array
    {
        $tags            = ['admin', 'permissions', 'name'];
        $permissionNames = cache_tags($tags, 'all');

        if (empty($permissionNames)){
            $permissionNames = array_column($this->all(), 'name');
            cache_tags($tags, 'all', $permissionNames);
        }

        return $permissionNames;
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
