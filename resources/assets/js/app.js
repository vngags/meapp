
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Progress from '../../../public/plugins/progress-bar/progress.js'
require('../../../public/plugins/progress-bar/progress.css')



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

//Home
Vue.component('index', require('./components/views/home/Index.vue'));


//Notification
Vue.component('unread-notification', require('./components/UnreadNotification.vue'));

//Product components
Vue.component('product-form', require('./components/views/products/ProductForm.vue'));
Vue.component('product-show', require('./components/views/products/Show.vue'));

import {store} from './store'





const app = new Vue({
    el: '#app',
    store
});

$(window).on('load', function() {
  $("body").removeClass("preload");
});

// YouTube like progress-bar
Progress.configure({ showSpinner: false });
Progress.start();
$(window).on('load', function () {
   Progress.done(true);
});
// YouTube like progress-bar

var navbar_top = $('.navbar-bottom').offset().top;
$(window).scroll(() => {
    if($(window).scrollTop() > navbar_top) {
      $('.navbar-bottom').addClass('fixed');
    }else{
      $('.navbar-bottom').removeClass('fixed');
    }

    // if($(window).scrollTop() >= ($('#heading-position').position().top + $('#heading-position').height() + 110)){
    //     $(".heading-fixed").addClass('is_active');
    // }else{
    //     $(".heading-fixed").removeClass('is_active');
    // }

    if($(window).scrollTop() > 300) {
      $('.cc-back-top').addClass('showing')
    }else{
      $('.cc-back-top').removeClass('showing')
    }
});


$('.back-to-top').on('click', () => {
  $("html, body").animate({scrollTop: 0}, 500);
});

$('#type-product').on('click', function() {
  $('#search-type .btn-label').text('Sản phẩm')
  $('#hidden-product-type').val('product')
  $('#q').focus()
})
$('#type-member').on('click', function() {
  $('#search-type .btn-label').text('Thành viên')
  $('#hidden-product-type').val('member')
  $('#q').focus()
})
$('#type-brand').on('click', function() {
  $('#search-type .btn-label').text('Thương hiệu')
  $('#hidden-product-type').val('brand')
  $('#q').focus()
})

