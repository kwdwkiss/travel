import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: require('./pages/App'),
            children: [
                {name: 'index', path: '', component: require('./pages/Index')},

                {name: 'userIndex', path: 'user/index', component: require('./pages/user/Index')},
                {name: 'userCreate', path: 'user/create', component: require('./pages/user/Create')},
                {name: 'userUpdate', path: 'user/update/:id', component: require('./pages/user/Update')},

                {name: 'adminIndex', path: 'admin', component: require('./pages/admin/Index')},
                {name: 'adminCreate', path: 'admin/create', component: require('./pages/admin/Create')},
                {name: 'adminUpdate', path: 'admin/update/:id', component: require('./pages/admin/Update')},

                {name: 'infoIndex', path: 'info', component: require('./pages/info/Index')},
                {name: 'infoCreate', path: 'info/create', component: require('./pages/info/Create')},
                {name: 'infoUpdate', path: 'info/update/:id', component: require('./pages/info/Update')},

                //replace_routes
            ]
        },
        {
            name: 'login', path: '/login', component: require('./pages/Login'),
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (!store.state.user && to.name !== 'login') {
        next({name: 'login'});
    } else {
        next();
    }
});

export default router;