import Vue    from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export const constantRouterMap = [
    {
        path     : '/',
        component: require('../views/test.vue'),
        hidden   : false
    }
];

export default new Router({
    routes: constantRouterMap
})