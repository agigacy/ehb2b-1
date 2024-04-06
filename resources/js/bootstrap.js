import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');
window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.defaults.withCredentials = true;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     wsHost: 'localhost',
//     wsPort: 6001,
//     forceTLS: false
// });
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: 'localhost',
    wsPort: 6001,
    wssPort: 6001,
    disableStats: true,
    forceTLS: false,
});
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'local', // 与 .env 中的 PUSHER_APP_KEY 相匹配
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     forceTLS: false, // 本地环境通常不使用 TLS
//     disableStats: true,
//     // auth: {
//     //   headers: {
//     //     Authorization: 'Bearer ' + localStorage.getItem('token'),
//     //   },
//     // },
//   });

