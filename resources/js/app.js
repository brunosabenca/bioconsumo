
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

import VueFuse from 'vue-fuse';
Vue.use(VueFuse);

import VueScrollTo from 'vue-scrollto';
Vue.use(VueScrollTo)

require('./bootstrap');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('flash', require("./components/Flash.vue"));
Vue.component('product-view', require('./pages/Product.vue'));
Vue.component('product-listing-view', require('./pages/ProductListing.vue'));
Vue.component('group-order-view', require('./pages/GroupOrder.vue'));
Vue.component('group-order-listing-view', require('./pages/GroupOrderListing.vue'));
Vue.component('user-order-view', require('./pages/UserOrder.vue'));
Vue.component('cart', require('./components/Cart.vue'));
Vue.component('new-group-order-view', require('./pages/NewGroupOrder.vue'));
Vue.component('new-product-view', require('./pages/NewProduct.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
