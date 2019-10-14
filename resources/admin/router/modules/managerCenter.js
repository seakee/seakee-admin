import Layout from '@/views/layout/layout'

let managerCenterRouter = {
    path     : '/managerCenter',
    name     : 'managerCenter',
    redirect : '/managerCenter/dashboards/index',
    meta     : {
        title   : '管理中心'
    },
    component: Layout,
    children : [
        {
            path     : 'dashboards/index',
            name     : 'managerCenter.dashboards.index',
            meta     : {
                title   : '仪表盘',
                activeIndex : '/managerCenter/dashboards/index'
            },
            component: () => import('@/views/managerCenter/dashboards/index')
        },
        {
            path     : 'configs/index',
            name     : 'managerCenter.configs.index',
            meta     : {
                title   : '系统配置',
                activeIndex : '/managerCenter/configs/index'
            },
            component: () => import('@/views/managerCenter/configs/index')
        },
        {
            path     : 'menus/index',
            name     : 'managerCenter.menus.index',
            meta     : {
                title   : '菜单管理',
                activeIndex : '/managerCenter/menus/index'
            },
            component: () => import('@/views/managerCenter/menus/index')
        },
        {
            path     : 'menus/create',
            name     : 'managerCenter.menus.create',
            meta     : {
                title   : '新增菜单',
                activeIndex : '/managerCenter/menus/index'
            },
            component: () => import('@/views/managerCenter/menus/create')
        },
        {
            path     : 'menus/edit/:id(\\d+)',
            name     : 'managerCenter.menus.edit',
            meta     : {
                title   : '编辑菜单',
                activeIndex : '/managerCenter/menus/index'
            },
            component: () => import('@/views/managerCenter/menus/edit')
        }
    ]

};

export default managerCenterRouter
