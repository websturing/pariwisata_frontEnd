import Vue from 'vue';
import VueRouter from 'vue-router';

import urlBase from '@/js/url';
import login from '@/js/master/login';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: urlBase.urlBase,
    hash: false,
    routes: [
        {
            path: '/login',
            name: 'login',
            component: login
        },


    ]
});

export default router;
