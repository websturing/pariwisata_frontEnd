import './bootstrap';
import Vue from 'vue';
import Routes from '@/js/routes.js';

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';

require('froala-editor/js/froala_editor.pkgd.min.js')

// Require Froala Editor css files.
require('froala-editor/css/froala_editor.pkgd.min.css')
require('froala-editor/css/froala_style.min.css')

// Import and use Vue Froala lib.
import VueFroala from 'vue-froala-wysiwyg'
Vue.use(VueFroala)

Vue.use(ElementUI, {
    locale
});


const app = new Vue({
    el: '#app',
    router: Routes,
    data: {
        activeContent: true,
        activeLogin: false
    },
});
