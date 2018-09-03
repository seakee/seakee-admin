<?php
/**
 * File: AdminUserRepository.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/27 16:49
 * Description:
 */

namespace App\Repositories\Users;


use App\Models\Users\AdminUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
		return $this->user->where($where)->paginate($perPage,['id', 'user_name', 'avatar', 'email', 'phone', 'status', 'rank', 'created_at'],'page', $page);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function find($ids)
	{
		return $this->user->findOrFail($ids, ['id', 'user_name', 'avatar', 'email', 'phone', 'status', 'rank', 'created_at']);
	}
}