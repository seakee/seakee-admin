<?php

namespace App\Http\Middleware;

use App\Services\Users\{AdminRoleService, AdminPermissionService};
use Closure;
use Route;
use Auth;

class CheckPermission
{
	/**
	 * @var AdminRoleService
	 */
	protected $roleService;

	/**
	 * @var AdminPermissionService
	 */
	protected $permissionService;

	/**
	 * CheckPermission constructor.
	 *
	 * @param AdminRoleService       $roleService
	 * @param AdminPermissionService $permissionService
	 */
	public function __construct(AdminRoleService $roleService, AdminPermissionService $permissionService)
	{
		$this->roleService       = $roleService;
		$this->permissionService = $permissionService;
	}

	/**
	 * 白名单路由，放行不需要检查或刷新token的路由
	 *
	 * @var array
	 */
	protected $exceptRouteName = ['admin.login', 'admin.index'];

	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    $currentRouteName = Route::currentRouteName();

	    //属于白名单的路由直接放行
	    if (in_array($currentRouteName, $this->exceptRouteName)){
		    return $next($request);
	    }

    	$user  = Auth::user();
	    $roles = $this->roleService->current($user);

	    //超级管理员直接放行
	    if (!in_array('Super_Admin', array_column($roles->toArray(), 'name'))) {

		    $currentPermission = $this->permissionService->current($user, $roles);
		    $allPermission     = $this->permissionService->allName();

		    //检查权限是否已经定义
		    if (!in_array($currentRouteName, $allPermission)) {
			    return response()->json(['msg' => trans('auth.undefined')],400);
		    }

		    //检查是否有权限
		    if (!in_array($currentRouteName, $currentPermission)) {
		    	return response()->json(['msg' => trans('auth.forbidden')],403);
		    }

		    return $next($request);
	    }

        return $next($request);
    }
}
