import Vue from 'vue';
import axios from 'axios';
import Routes from './routes';
import VueRouter from 'vue-router';

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

document.querySelector('#test').onclick = function changecontent(){
    var kader = document.querySelector('#test');
    var vertaling = document.querySelector('#vertaling');
    var text = document.querySelector('#text');
    if (text.style.display === "none") {
        kader.style.height= "18vh";
        text.style.display = "block";
        vertaling.style.display = "block";
      } else {
        kader.style.height= "4vh";
        text.style.display = "none";
        vertaling.style.display = "none";
      }
};