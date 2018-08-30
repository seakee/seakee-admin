<?php
/**
 * File: UserController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:48
 * Description:
 */

namespace App\Admin\Controllers\Users;


use App\Admin\Requests\User\UserRequest;
use App\Http\Controllers\Controller;
use App\Service\User\AdminUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
	/**
	 * @var AdminUserService
	 */
	protected $userService;

	/**
	 * UserController constructor.
	 *
	 * @param AdminUserService $userService
	 */
	public function __construct(AdminUserService $userService)
	{
		$this->userService = $userService;
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function index(Request $request)
	{
		return $this->userService->paginate($request);
	}

	/**
	 * @param UserRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(UserRequest $request)
	{
		$params = $request->all();

		$params['password'] = bcrypt($params['password']);

		$user = $this->userService->create($params);

		if (empty($user)){
			return response()->json(['msg' => 'registration failed'], 500);
		}

		return response()->json(['msg' => 'success']);
	}

	/**
	 * @param string $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function show(string $id)
	{
		return $this->userService->find($id);
	}

	public function update()
	{
		
	}

	public function destroy(string $ids)
	{
		$ids = explode(',', $ids);

		$rs = $this->userService->delete($ids);

		return $rs ? response()->json(['msg' => 'success']) : response()->json(['msg' => 'failed'], 500);
	}
}