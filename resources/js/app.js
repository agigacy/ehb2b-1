require('./bootstrap');

window.Vue = require('vue').default;
import router from './router'
import Vue from 'vue';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import App from './App.vue'
import axios from 'axios'; // 导入 axios

Vue.use(Vuetify)

// 添加请求拦截器
// axios.interceptors.request.use(function (config) {
//     const token = localStorage.getItem('token');
//     if (token) {
//         config.headers.Authorization = `Bearer ${token}`;
//     }
//     return config;
// });

Vue.prototype.$userId = () => localStorage.getItem('user_id');
Vue.prototype.$username = () => localStorage.getItem('username');


const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(), // 添加这一行
    components: { App },
    template: '<App />'
});