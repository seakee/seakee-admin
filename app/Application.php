<?php
/**
 * File: Application.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 3:41 下午
 * Description:
 */

namespace App;

use App\Bootstrap\LoadConfiguration as LoadConfig;
use Illuminate\Foundation\Application as App;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

class Application extends App
{
    /**
     * Application constructor.
     *
     * @param null $basePath
     */
    public function __construct($basePath = null)
    {
        parent::__construct($basePath);

        $this->afterBootstrapping(LoadConfiguration::class, function ($app) {
            $app->make(LoadConfig::class)->handle();
        });
    }
}
