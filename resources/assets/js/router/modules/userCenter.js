import Layout from '@/views/layout/layout'

const userCenterRouter = {
    path     : '/userCenter',
    name     : 'userCenter',
    redirect : '/userCenter/users/index',
    meta     : {
        title   : '用户中心'
    },
    component: Layout,
    children : [
        {
            path     : 'users/index',
            name     : 'userCenter.users.index',
            meta     : {
                title   : '用户管理'
            },
            component: () => import('@/views/userCenter/users/index')
        },
        {
            path     : 'users/create',
            name     : 'userCenter.users.create',
            meta     : {
                title   : '新增用户'
            },
            component: () => import('@/views/userCenter/users/create')
        },
        {
            path     : 'users/edit/:id(\\d+)',
            name     : 'userCenter.users.edit',
            meta     : {
                title   : '编辑用户'
            },
            component: () => import('@/views/userCenter/users/edit')
        }
    ]

};

export default userCenterRouter
