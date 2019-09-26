<?php
/**
 * File: UserRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:30 上午
 * Description:
 */

namespace App\Repositories\Admin\Users;


use App\Models\Users\AdminUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
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
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->user->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->user->destroy($ids);
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
        return $this->user->where($where)->paginate($perPage,['id', 'user_name', 'avatar', 'email', 'mobile', 'status', 'rank', 'created_at'],'page', $page);
    }

    /**
     * @param array|int $ids
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find($ids)
    {
        $columns = ['id', 'user_name', 'avatar', 'email', 'mobile', 'status', 'rank', 'created_at'];

        if (is_array($ids)){
            return $this->user->findMany($ids, $columns);
        }

        return $this->user->findOrFail($ids, $columns);
    }
}
