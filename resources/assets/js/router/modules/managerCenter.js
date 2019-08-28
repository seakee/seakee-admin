import Layout from '@/views/layout/layout'

const managerCenterRouter = {
    path     : '/managerCenter',
    name     : 'managerCenter',
    /*redirect : '/managerCenter/users/index',*/
    meta     : {
        title   : '管理中心'
    },
    component: Layout,
    children : [
        {
            path     : 'menus/index',
            name     : 'managerCenter.menus.index',
            meta     : {
                title   : '菜单管理'
            },
            component: () => import('@/views/managerCenter/menus/index')
        },
        {
            path     : 'menus/create',
            name     : 'managerCenter.menus.create',
            meta     : {
                title   : '新增菜单'
            },
            component: () => import('@/views/managerCenter/menus/create')
        }
    ]

};

export default managerCenterRouter
