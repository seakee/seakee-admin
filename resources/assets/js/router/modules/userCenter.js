import Layout    from '@/views/layout/layout'

const userCenterRouter = {
    path     : '/userCenter',
    component: Layout,
    redirect:'/userCenter/users/index',
    children: [
        {
            path: 'users/index',
            name: 'userCenter.users.index',
            component: () => import('@/views/userCenter/users/index')
        }
    ]

};

export default userCenterRouter
