
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue');

import VueTimeago from 'vue-timeago'
Vue.use(VueTimeago, {
  name: 'timeago', // component name, `timeago` by default
  locale: 'en-US',
  locales: {
    // you will need json-loader in webpack 1
    'en-US': require('vue-timeago/locales/vi-VN.json')
  }
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('listen', require('./components/Listen.vue'));
Vue.component('init', require('./components/Init.vue'));
Vue.component('profile', require('./components/views/profiles/Profile.vue'));
Vue.component('my-profile', require('./components/views/profiles/MyProfile.vue'));
Vue.component('profile-form', require('./components/views/profiles/ProfileForm.vue'));
Vue.component('follow', require('./components/views/profiles/Follow.vue'));

Vue.component('page-loading', require('./components/views/PageLoading.vue'));

//Notification
Vue.component('unread-notification', require('./components/UnreadNotification.vue'));

//Product components
Vue.component('product-form', require('./components/views/products/ProductForm.vue'));

import {store} from './store'

const app = new Vue({
    el: '#app',
    store
});


