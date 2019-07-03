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
        },
        {
            path     : 'users/syncRoles/:id(\\d+)',
            name     : 'userCenter.users.syncRoles',
            meta     : {
                title   : '角色分配'
            },
            component: () => import('@/views/userCenter/users/syncRoles')
        },
        {
            path     : 'roles/index',
            name     : 'userCenter.roles.index',
            meta     : {
                title   : '角色管理'
            },
            component: () => import('@/views/userCenter/roles/index')
        },
        {
            path     : 'roles/create',
            name     : 'userCenter.roles.create',
            meta     : {
                title   : '新增角色'
            },
            component: () => import('@/views/userCenter/roles/create')
        },
        {
            path     : 'roles/edit/:id(\\d+)',
            name     : 'userCenter.roles.edit',
            meta     : {
                title   : '编辑角色'
            },
            component: () => import('@/views/userCenter/roles/edit')
        },
        {
            path     : 'roles/syncPermissions/:id(\\d+)',
            name     : 'userCenter.roles.syncRoles',
            meta     : {
                title   : '角色授权'
            },
            component: () => import('@/views/userCenter/roles/syncPermissions')
        },
        {
            path     : 'permissions/index',
            name     : 'userCenter.permissions.index',
            meta     : {
                title   : '权限管理'
            },
            component: () => import('@/views/userCenter/permissions/index')
        },
        {
            path     : 'permissions/create',
            name     : 'userCenter.permissions.create',
            meta     : {
                title   : '新增权限'
            },
            component: () => import('@/views/userCenter/permissions/create')
        },
        {
            path     : 'permissions/edit/:id(\\d+)',
            name     : 'userCenter.permissions.edit',
            meta     : {
                title   : '编辑权限'
            },
            component: () => import('@/views/userCenter/permissions/edit')
        }
    ]

};

export default userCenterRouter
