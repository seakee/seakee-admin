import Vue    from 'vue'
import Router from 'vue-router'
import store  from '@/store'

Vue.use(Router);

/* Layout */
import Layout from '@/views/layout/layout'

import userCenterRouter    from './modules/userCenter'
import managerCenterRouter from './modules/managerCenter';

const router = new Router({
    routes: [
        {
            path     : '/',
            component: Layout,
            name     : 'admin'
        },
        {
            path     : '/errorPage',
            component: Layout,
            meta     : {
                title   : '错误'
            },
            children : [
                {
                    path     : '404',
                    name     : 'errorPage.404',
                    meta     : {
                        title   : '404'
                    },
                    component: () => import('@/views/errorPage/404')
                }
            ]
        },
        {
            path     : '/login',
            name     : 'admin.login',
            meta     : {
                title   : '登录'
            },
            component: () => import('@/views/login')
        },
        userCenterRouter,
        managerCenterRouter,
        {
            path    : '*',
            redirect: '/errorPage/404'
        }
    ]
});

router.beforeEach((to, from, next) => {

    document.title = to.meta.title ? to.meta.title : '首页 - seakee-admin';

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