<?php
/**
 * File: Application.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/15 10:51
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