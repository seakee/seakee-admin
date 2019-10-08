<?php
/**
 * File: admin.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 10:52 上午
 * Description:
 */

return [
    /**
     * 应用标题
     */
    'name'    => 'SeakeeAdmin',

    /**
     * 版本号
     */
    'version' => '0.1.3',

    /**
     * 路由配置
     */
    'route'   => [
        // 路由前缀
        'prefix'     => 'admin',
        // 控制器命名空间前缀
        'namespace'  => 'Admin\\Controllers',
        // 默认中间件列表
        'middleware' => ['admin'],
    ],

    /**
     * 缓存相关配置
     */
    'cache'   => [
        //缓存开关
        'enable' => true,
        //缓存时间（单位：min）
        'ttl'    => 10080,
    ],

    /**
     * CDN配置
     */
    'cdn'     => [
        'enable' => false,
        'css'    => [
            'element-ui'   => '//cdn.bootcss.com/element-ui/2.10.1/theme-chalk/index.css',
            'font-awesome' => '//cdn.bootcss.com/font-awesome/5.9.0/css/all.min.css',
        ],
        'js'     => [
            'vue'        => '//cdn.bootcss.com/vue/2.6.10/vue.min.js',
            'element-ui' => '//cdn.bootcss.com/element-ui/2.10.1/index.js',
        ],
    ],

    /**
     * API配置
     */
    'api'     => [
        'baseURL' => '/admin/api/v1',
        'timeout' => 5000,
    ],
];
