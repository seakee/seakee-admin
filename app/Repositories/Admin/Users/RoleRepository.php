<?php
/**
 * File: RoleRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:30 上午
 * Description:
 */

namespace App\Repositories\Admin\Users;


use App\Models\Users\AdminRole;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleRepository
{
    /**
     * @var AdminRole
     */
    protected $role;

    /**
     * AdminRoleRepository constructor.
     *
     * @param AdminRole $role
     */
    public function __construct(AdminRole $role)
    {
        $this->role = $role;
    }

    /**
     * @param array $data
     *
     * @return AdminRole
     */
    public function store(array $data):AdminRole
    {
        return $this->role->create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->role->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids)
    {
        return $this->role->destroy($ids);
    }

    /**
     * @param array $where
     * @param int   $perPage
     * @param int   $page
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array $where, int $perPage, int $page): LengthAwarePaginator
    {
        return $this->role->where($where)->paginate($perPage,['id', 'name', 'display_name', 'description', 'created_at'],'page', $page);
    }

    /**
     * @param array|int $ids
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find($ids)
    {
        $columns = ['id', 'name', 'display_name', 'description', 'created_at'];

        if (is_array($ids)){
            return $this->role->findMany($ids, $columns);
        }

        return $this->role->findOrFail($ids, $columns);
    }
}
