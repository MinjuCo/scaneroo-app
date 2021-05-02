import Vue from 'vue';
import axios from 'axios';
import Routes from './routes';
import VueRouter from 'vue-router';
import "./service-worker";
import Buefy from "buefy";
import "buefy/dist/buefy.css";

window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

let token = document.head.querySelector('meta[name="csrf-token"]');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.use(VueRouter);
Vue.use(Buefy);

Vue.prototype.$http = axios.create();

let routerBasePath = '/';

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: routerBasePath,
});

new Vue({
    el: '#scaneroo',
    
    router,

    data() {
        return {

        };
    },
});