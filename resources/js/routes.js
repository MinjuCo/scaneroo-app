export default [
    { path: '/', redirect: '/home' },

    {
        path: '/home',
        name: 'home',
        component: require('./screens/app').default,
    },
    {
        path: '/profile',
        name: 'profile',
        component: require('./screens/profile').default,
    },
    {
        path: '/favoriet',
        name: 'favoriet',
        component: require('./screens/favoriet').default,
    },
    {
        path: '/theme',
        name: 'theme',
        component: require('./screens/theme').default,
    },
    {
        path: '/nouriture',
        name: 'nouriture',
        component: require('./screens/nouriture').default,
    },
];