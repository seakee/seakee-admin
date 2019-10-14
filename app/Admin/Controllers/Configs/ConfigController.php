<?php
/**
 * File: ConfigController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/10/9 10:09 上午
 * Description:
 */

namespace Admin\Controllers\Configs;


use App\Http\Controllers\Controller;
use App\Supports\Configuration;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {

    }

    /**
     * Update Configuration, rewrite by file .config.yml
     *
     * @param Request       $request
     * @param Configuration $configuration
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(Request $request, Configuration $configuration)
    {
        $data = $request->all();

        // If the CDN option is updated, maintenance mode is turned on and
        // the front end project is rebuilt automatically
        if (isset($data['admin']['cdn'])){
            $data['admin']['maintenanceMode'] = true;
        }

        $configuration->set($data);
        
        // If the Cache option is updated,clear all cache
        if (isset($data['admin']['cache'])){
            clear_cache(['admin']);
        }

        return json_response();
    }
}
