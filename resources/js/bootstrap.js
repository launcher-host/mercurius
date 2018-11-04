import Vue          from 'vue';
import axios        from 'axios';
import BootstrapVue from 'bootstrap-vue';
import swal         from 'sweetalert';
import moment       from 'moment';
import vuescroll    from 'vuescroll/dist/vuescroll-native';

import 'vuescroll/dist/vuescroll.css';

window._       = require('lodash');
window.Vue     = Vue;
window.swal    = swal;
window.Bus     = new Vue();
window.axios   = axios;
window.moment  = moment;
window.Promise = require('promise');
window.Pusher  = require('pusher-js');


require('./bootstrap-mercurius');
require('./core/I18N.js');


Vue.use(BootstrapVue);


/**
 * Vue Scroll
 */
Vue.use(vuescroll);
Vue.prototype.$vuescrollConfig = {
    scrollPanel: {
        scrollingX: false,
    },
    bar: {
        hoverStyle: true,
        background: '#B1BDFF'
    },
    rail: {
        size: '8px',
        gutterOfSide: '0',
    },
};



/**
 * Load axios library and include CSRF token.
 */
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.Mercurius.csrfToken
};



/**
 * Handle expired sessions, redirects user to sign in.
 * ------------------------------------------------------------|
 * Debug notes. With the web console, clear the session cookie,|
 * then click any link to run a axios request, it will return  | TODO
 * an error 419, but this is not running!!!                    |
 * ------------------------------------------------------------|
 */
window.axios.interceptors.response.use((response) => {
    if (response.status === 401 || response.status === 419) {
    console.log(response);
        window.axios.get('/logout');
        window.location.href = '/login';
        return;
    }
    return response;
});



import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: Mercurius.pusherKey,
    cluster: Mercurius.pusherCluster,
    encrypted: true,
});



const app = new Vue({
    el: '#mercurius',
    mixins: [require('./mercurius')],
});

