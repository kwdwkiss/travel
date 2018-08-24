import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: require('./pages/App'),
            children: [
                {name: 'index', path: '', component: require('./pages/Index')},
                {name: 'login', path: 'login', component: require('./pages/Login')},
                {name: 'register', path: 'register', component: require('./pages/Register')},
                {name: 'forget_password', path: 'forget_password', component: require('./pages/ForgetPassword')},
            ]
        }
    ]
});

export default router;