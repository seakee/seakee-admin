<?php
/**
 * File: admin.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 10:52 上午
 * Description:
 */

return [
    /*
     * 应用标题
     */
    'name'  => 'seakee-admin',

    /*
     * 路由配置
     */
    'route' => [
        // 路由前缀
        'prefix'     => 'admin',
        // 控制器命名空间前缀
        'namespace'  => 'Admin\\Controllers',
        // 默认中间件列表
        'middleware' => ['admin'],
    ],

    //缓存相关配置
    'cache' => [
        //缓存开关
        'enable' => true,
        //缓存时间（单位：min）
        'ttl'    => 10080,
    ],

    'cdn' => [
        'enable' => false,
    ],
];
