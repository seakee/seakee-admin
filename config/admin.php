<?php
/**
 * File: admin.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/21 17:16
 * Description:
 */

return [
	/*
     * 站点标题
     */
	'name' => 'Kiwi时光',

	/*
	 * 路由配置
	 */
	'route' => [
		// 路由前缀
		'prefix' => 'admin',
		// 控制器命名空间前缀
		'namespace' => 'App\\Admin\\Controllers',
		// 默认中间件列表
		'middleware' => ['web', 'admin'],
	],
];