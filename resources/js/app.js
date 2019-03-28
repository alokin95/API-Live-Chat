
require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueCookies from 'vue-cookies'
import 'bulma/css/bulma.css'


Vue.use(VueCookies)
Vue.use(VueRouter)

// set default config
VueCookies.config('7d')

// set global cookie
VueCookies.set('theme','default');
VueCookies.set('hover-time','1s');

import router from './routes';

window.Vue = require('vue');

window.Event = new Vue();

const app = new Vue({
    el: '#app',

    router
});
