/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue'
import ProductPrice from './components/ProductPrice.vue'
import ProductAdd from './components/ProductAdd.vue'
import ProductUpdate from './components/ProductUpdate.vue'
import MachineRent from './components/MachineRent.vue'
import MachineRentUpdate from './components/MachineRentUpdate.vue'
import CountryAdd from './components/CountryAdd.vue'
import CountryUpdate from './components/CountryUpdate.vue'
import swal from 'sweetalert2'
window.swal = swal;
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})


Vue.component('product-price', require('./components/ProductPrice.vue'));
Vue.component('product-add', require('./components/ProductAdd.vue'));
Vue.component('product-update', require('./components/ProductUpdate.vue'));
Vue.component('machine-rent', require('./components/MachineRent.vue'));
Vue.component('machine-rent-update', require('./components/MachineRentUpdate.vue'));
Vue.component('country-add', require('./components/CountryAdd.vue'));
Vue.component('country-update', require('./components/CountryUpdate.vue'));

axios.defaults.baseURL = '/wizefresh/public/'
const app = new Vue({
    el: '#app',
    components: {
        ProductPrice,
        'product-add': ProductAdd,
        'product-update': ProductUpdate,
        'machine-rent-update': MachineRentUpdate,
        'country-add': CountryAdd,
        'country-update': CountryUpdate,
        'machine-rent': MachineRent,



    },


});