<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Auth;

class CheckPermission
{
	/**
	 * 白名单路由，放行不需要检查或刷新token的路由
	 *
	 * @var array
	 */
	protected $exceptRouteName = ['admin.login', 'admin.logout'];

	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
	    $currentRouteName = Route::currentRouteName();

	    //属于白名单的路由直接放行
	    if (in_array($currentRouteName, $this->exceptRouteName)){
		    return $next($request);
	    }

    	$user = Auth::user();dd($user);

    	$roles = $user->roles->toArray();

        return $next($request);
    }
}
