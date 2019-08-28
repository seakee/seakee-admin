import Vue from 'vue'

import ElementUI from 'element-ui'

import App    from './App.vue'
import router from './router'
import store  from './store'

Vue.use(ElementUI);

new Vue({
    el    : '#app',
    router,
    store,
    render: h => h(App)
});
