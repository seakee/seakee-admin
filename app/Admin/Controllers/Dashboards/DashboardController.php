<?php
/**
 * File: DashboardsController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/10/14 9:51 上午
 * Description:
 */

namespace Admin\Controllers\Dashboards;


use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

    }

    public function server()
    {
        $server = [
            ['key' => trans('admin.os'), 'value' => PHP_OS],
            ['key' => trans('admin.phpVersion'), 'value' => PHP_VERSION],
            ['key' => trans('admin.server'), 'value' => $_SERVER['SERVER_SOFTWARE']],
            ['key' => trans('admin.db'), 'value' => config('database.default')],
            ['key' => trans('admin.maxUploadSize'), 'value' => ini_get('upload_max_filesize')],
            ['key' => trans('admin.executeTime'), 'value' => ini_get('max_execution_time') . 's'],
            ['key' => trans('admin.serverIp'), 'value' => $_SERVER['SERVER_ADDR']],
            ['key' => trans('admin.disk'), 'value' => human_file_size(disk_free_space('.'))],
        ];

        return json_response(200, 'success', $server);
    }

    public function system()
    {
        $system = [
            ['key' => trans('admin.sysVersion'), 'value' => config('admin.version')],
            ['key' => trans('admin.laravelVersion'), 'value' => app()->version()],
            ['key' => trans('admin.timeZone'), 'value' => config('app.timezone')],
            ['key' => trans('admin.cache'), 'value' => config('admin.cache.enable') ? trans('admin.on') : trans('admin.off')],
            ['key' => trans('admin.cdn'), 'value' => config('admin.cdn.enable') ? trans('admin.on') : trans('admin.off')],
            ['key' => trans('admin.broadcastDriver'), 'value' => config('broadcasting.default')],
            ['key' => trans('admin.cacheDriver'), 'value' => config('cache.default')],
            ['key' => trans('admin.queueCon'), 'value' => config('queue.default')],
            ['key' => trans('admin.sessionDriver'), 'value' => config('session.driver')],
        ];

        return json_response(200, 'success', $system);
    }
}
