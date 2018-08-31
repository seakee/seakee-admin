<?php
/**
 * File: AdminUserService.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:53
 * Description:
 */

namespace App\Service\User;


use App\Repository\User\AdminUserRepository;
use App\Models\Users\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminUserService
{
	/**
	 * @var AdminUserRepository
	 */
	protected $userRepository;

	/**
	 * AdminUserService constructor.
	 *
	 * @param AdminUserRepository $userRepository
	 */
	public function __construct(AdminUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param Request $request
	 *
	 * @return AdminUser
	 */
	public function create(Request $request):AdminUser
	{
		$data = filter_request_params(['user_name', 'email', 'phone', 'password'], $request);

		$data['password'] = bcrypt($data['password']);

		return $this->userRepository->store($data);
	}

	/**
	 * @param Request $request
	 * @param int     $id
	 *
	 * @return bool
	 */
	public function edit(Request $request, int $id):bool
	{
		$data = filter_request_params(['user_name', 'email', 'phone', 'password'], $request);

		return $this->userRepository->update($data, $id);
	}

	/**
	 * @param string $ids
	 *
	 * @return int
	 */
	public function delete($ids): int
	{
		$ids = explode(',', $ids);

		return $this->userRepository->destroy($ids);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function paginate(Request $request): LengthAwarePaginator
	{
		$where   = filter_request_params(['user_name', 'email', 'phone'], $request);
		$perPage = $request->get('per_page', 15);
		$page    = $request->get('page', 1);

		return $this->userRepository->paginate($where, $perPage, $page);
	}

	/**
	 * @param array|int $ids
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function find($ids)
	{
		return $this->userRepository->find($ids);
	}
}