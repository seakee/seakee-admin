import Vue    from 'vue'
import Router from 'vue-router'
import store  from '@/store'

Vue.use(Router);

/* Layout */
import Layout from '@/views/layout/layout'

import userCenterRouter from './modules/userCenter'

const router = new Router({
    routes: [
        {
            path     : '/',
            component: Layout
        },
        {
            path     : '/errorPage',
            component: Layout,
            children : [
                {
                    path     : '404',
                    name     : 'errorPage.404',
                    component: () => import('@/views/errorPage/404')
                }
            ]
        },
        {
            path     : '/login',
            component: () => import('@/views/login')
        },
        userCenterRouter,
        {
            path    : '*',
            redirect: '/errorPage/404'
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