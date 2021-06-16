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
    },

    {
        path: '/auth/:provider/callback',
        component: {
          template: '<div class="auth-component"></div>'
        }
    },

    { path: '/register', redirect: '/register/user-role' },

    {
        path: '/register/:step',
        name: 'register',
        component: require('./screens/register').default,
    },

    {
        path: '/register/:status/:step',
        name: 'complete-profile',
        component: require('./screens/complete-profile').default,
    },
];