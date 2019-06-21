import Vue       from 'vue'
import Router    from 'vue-router'
import store     from '@/store'

Vue.use(Router);

/* Layout */
import Layout    from '@/views/layout/layout'

const router = new Router({
    routes: [
        {
            path     : '/',
            component: Layout
        },
        {
            path     : '/userCenter',
            component: Layout,
            children: [
                {
                    path: 'users/index',
                    name: 'userCenter.users.index',
                    component: () => import('@/views/userCenter/users/index')
                }
            ]

        },

        {
            path     : '/login',
            component: () => import('@/views/login')
        }
    ]
});

router.beforeEach((to, from, next) => {
    const token = store.getters.token;
    if (token) {
        if (to.path === '/login') {
            next({path: '/'});
        } else {
            if (store.getters.profile === null) {
                //获取登录用户信息
                store.dispatch('profile').then(res => {
                    next();
                }).catch(err => {
                    console.log(err);
                });
            } else {
                next();
            }
        }
    } else {
        if (to.path === '/login') {
            next();
        } else {
            next('/login');
        }
    }
});

export default router