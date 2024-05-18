require('./bootstrap');

window.Vue = require('vue').default;
import router from './router'
import Vue from 'vue';
import Vuetify from 'vuetify'
import '../sass/app.scss' 
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

Vue.prototype.$formatDate = function(dateString) {
    const options = {
      day: '2-digit',
      month: 'short',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    };
    // const date = new Date(dateString);
    // return date.toLocaleDateString('en-GB', options);
  
    const date = new Date(dateString);
    const formattedDate = date.toLocaleDateString('en-GB', options);
    return formattedDate.replace(/,/g, ''); 
  };

// Vue.prototype.$formatCurrency = function(value) {
//     return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
// };
axios.interceptors.request.use(function (config) {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

Vue.prototype.$formatCurrency = function(value, currency = 'RM') {
    return `${currency} ${value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;
  };

const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(), // 添加这一行
    components: { App },
    template: '<App />'
});