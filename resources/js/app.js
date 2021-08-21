import Vue from 'vue';
import axios from 'axios';
import VueSocialauth from 'vue-social-auth';
import Routes from './routes';
import VueRouter from 'vue-router';
import "./service-worker";
import "@fortawesome/fontawesome-free/css/all.css";
import languageBundle from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';
import VueI18n from 'vue-i18n';
import Multiselect from 'vue-multiselect';

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
Vue.use(VueI18n);
Vue.use(VueSocialauth, {
    providers: {
        google: {
            clientId: process.env.MIX_GOOGLE_CLIENT_ID,
            redirectUri: window.google_redirect
        }
    }
});

Vue.component('multiselect', Multiselect)

Vue.prototype.$http = axios.create();
Vue.prototype.$voiceKey = process.env.MIX_VOICE_RSS_KEY;
Vue.prototype.$user = window.User;

let routerBasePath = '/';

const i18n = new VueI18n({
    locale: window.default_locale,
    messages: languageBundle,
});

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: routerBasePath,
});

router.beforeEach((to, from, next) => {
    let auth = window.authenticated;
    if (to.matched.some(record => record.meta.requiresAuth)) {
      // this route requires auth, check if logged in
      // if not, redirect to login page.
      if (!auth) {
        next({
          path: '/login',
          query: { redirect: to.fullPath }
        })
      } else {
        next()
      }
    } else {
      next() // make sure to always call next()!
    }

    if (to.matched.some(record => record.meta.hideForAuth)) {
        if (auth) {
            next({ path: '/home' });
        } else {
            next();
        }
    } else {
        next();
    }

  })

new Vue({
    el: '#scaneroo',

    i18n,

    router,

    data() {
        return {

        };
    },
});