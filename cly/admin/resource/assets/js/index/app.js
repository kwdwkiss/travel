import '../bootstrap'
import Vue from 'vue'
import router from "./router";
import store from "./store";
import './element-ui';

axios.interceptors.response.use(function (response) {
    let errorMessage = null;

    if (response.data === '') {
        errorMessage = 'data is empty string';
    } else if (response.data.code !== 0) {
        errorMessage = response.data.message;
    }

    if (errorMessage) {
        Vue.prototype.$message.error(errorMessage);
        throw new Error(errorMessage);
    }
    return response;
}, function (error) {
    if (error.response) {
        if (error.response.status === 401) {//Unauthorized
            Vue.prototype.$message.error('用户未登录,请重新登录或3秒后自动跳转登录页面');
            setTimeout(function () {
                app.$router.push('/login');
            }, 3000);
        } else if (error.response.status === 419) {//csrf token invalid
            Vue.prototype.$message.error('token失效,手动刷新或3秒后自动刷新页面');
            setTimeout(function () {
                location.reload();
            }, 3000);
        } else {
            let message = error.response.data.message ? error.response.data.message : error.response.statusText;
            Vue.prototype.$message.error(message);
        }
    }
    return Promise.reject(error);
});

Vue.component('my-nav', require('./components/Nav'));
Vue.component('my-sms', require('./components/Sms'));

window.app = new Vue({
    el: '#app',
    template: '<router-view></router-view>',
    router,
    store,
});