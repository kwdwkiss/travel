import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = window.store = new Vuex.Store({
    state: {
        user: laravel.user,
        taxonomy: laravel.taxonomy,
    },
    mutations: {
        user(state, payload) {
            axios.get(api.adminIndexUser).then(function (res) {
                state.user = res.data.data;
                if (payload && payload.callback instanceof Function) {
                    payload.callback();
                }
            }).catch(function () {
                state.user = null;
                if (payload && payload.callback instanceof Function) {
                    payload.callback();
                }
            });
        }
    }
});

export default store