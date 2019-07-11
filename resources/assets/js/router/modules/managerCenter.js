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
        }
    ]

};

export default managerCenterRouter
