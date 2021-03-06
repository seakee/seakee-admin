<?php
/**
 * File: Admin.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 10:55 上午
 * Description:
 */

namespace App\Http\Middleware;

use App\Models\Users\AdminUser;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //处理维护模式的请求
        if (config('admin.maintenanceMode')) {

            $data['message'] = trans('admin.maintenance');
            $retryAfter      = 60;

            header("Retry-After: " . $retryAfter);

            if (in_array('api', explode('/', $request->getPathInfo()))) {
                return response()->json($data, 503);
            }

            return response()->view('maintenance', $data, 503);
        }

        //为后台加载JWT eloquent配置文件，用于后台账号的登录和token刷新
        config(['jwt.user' => '\App\Models\Users\AdminUser']);
        config(['auth.providers.users.model' => AdminUser::class]);

        return $next($request);
    }
}
