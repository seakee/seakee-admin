import Vue    from 'vue'
import Router from 'vue-router'

Vue.use(Router);

/* Layout */
import Layout from '@/views/layout/layout'

export const constantRouterMap = [
    {
        path     : '/',
        component: Layout
    },

    {
        path     : '/login',
        component: () => import('@/views/login')
    }
];

export default new Router({
    routes: constantRouterMap
})