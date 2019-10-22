<?php
/**
 * File: UserService.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:34 上午
 * Description:
 */

namespace App\Services\Admin\Users;


use App\Models\Users\AdminUser;
use App\Repositories\Admin\Users\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * AdminUserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    /**
     * @param UserRepository $userRepository
     */
    public function setUserRepository(UserRepository $userRepository)
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
        $data = filter_request_params(['user_name', 'email', 'mobile', 'password'], $request);

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
        $data = filter_request_params(['user_name', 'email', 'mobile', 'password', 'avatar', 'status'], $request);

        if (isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }

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
        $where   = filter_request_params(['user_name', 'email', 'mobile'], $request);
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

    /**
     * @param array $where
     *
     * @return mixed
     */
    public function get(array $where)
    {
        return $this->userRepository->get($where);
    }
}
