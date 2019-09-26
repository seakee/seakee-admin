<?php
/**
 * File: LoadConfiguration.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 3:42 下午
 * Description:
 */

namespace App\Bootstrap;

use App\Supports\Configuration;
use Illuminate\Contracts\Foundation\Application;

class LoadConfiguration
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * LoadAppConfig constructor.
     *
     * @param Application   $app
     * @param Configuration $configuration
     */
    public function __construct(Application $app, Configuration $configuration)
    {
        $this->app           = $app;
        $this->configuration = $configuration;
    }

    /**
     * Run handler, setting AppConfig.
     */
    public function handle()
    {
        $this->app->config->set($this->configuration->getAppConfig());
    }
}
