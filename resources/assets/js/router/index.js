import Vue    from 'vue'
import Router from 'vue-router'

Vue.use(Router);

/* Layout */
import Layout from '../views/layout/layout'

export const constantRouterMap = [
    {
        path     : '/',
        component: Layout,
        hidden   : false
    }
];

export default new Router({
    routes: constantRouterMap
})