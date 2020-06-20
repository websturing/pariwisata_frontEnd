import Vue from 'vue';
import VueRouter from 'vue-router';

import urlBase from '@/js/url';
import login from '@/js/master/login';
import berita from '@/js/components/berita/berita';
import beritaForm from '@/js/components/berita/form';
import videos from '@/js/components/videos/data';
import videosForm from '@/js/components/videos/videos';
import gallery from '@/js/components/gallery/gallery';
import galleryForm from '@/js/components/gallery/form';

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
        {
            path: '/content/berita',
            name: 'content-berita',
            component: berita
        },
        {
            path: '/content/berita/form',
            name: 'content-berita-form',
            component: beritaForm
        },
        {
            path: '/content/videos',
            name: 'content-videos',
            component: videos
        },
        {
            path: '/content/videos/form',
            name: 'content-videos-form',
            component: videosForm
        },
        {
            path: '/content/gallery',
            name: 'content-gallery',
            component: gallery
        },
        {
            path: '/content/gallery/form',
            name: 'content-gallery-form',
            component: galleryForm
        },


    ]
});

export default router;
