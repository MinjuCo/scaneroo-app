export default [
    { path: '/', redirect: '/home' },

    {
        path: '/home',
        name: 'home',
        component: require('./screens/app').default,
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: '/choose-language',
        name: 'language',
        component: require('./screens/choose-language').default,
    },

    {
        path: '/login',
        name: 'login',
        component: require('./screens/login').default,
        meta: {
            hideForAuth: true,
        },
    },

    {
        path: '/auth/:provider/callback',
        component: {
          template: '<div class="auth-component"></div>'
        },
        meta: {
            hideForAuth: true,
        },
    },

    { path: '/register/complete', redirect: '/register/complete/user-role' },

    { path: '/register', redirect: '/register/user-role' },

    {
        path: '/register/:step',
        name: 'register',
        component: require('./screens/register').default,
        meta: {
            hideForAuth: true,
        },
    },

    {
        path: '/register/:status/:step',
        name: 'complete-profile',
        component: require('./screens/complete-profile').default,
        meta: {
            hideForAuth: true,
        },
    },

    {
        path: '/favorite',
        name: 'favorite',
        component: require('./screens/favorite').default,
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: '/profile',
        name: 'profile',
        component: require('./screens/profile').default,
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: '/theme',
        name: 'theme',
        component: require('./screens/theme').default,
        meta: {
            requiresAuth: true,
        },
    },
];