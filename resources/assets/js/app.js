
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/DeliveryOrderInputForm.jsx');
require('./components/CreateVendorForm.jsx');
require('./components/AddContactPersonsForm.jsx')
require('./components/UpdateDeliveryOrderPricesForm')
require('./components/UpdateInvoicePaymentForm')
require('./components/CreateInvoiceForm')

/* Initialize Vue */
window.Vue = require('vue');
const app = new Vue({
    el: '#app'
});

/* Register all vue components */
Vue.component('delivery-order-create', () => import(/* webpackChunkName:"/js/components/delivery-order-create" */ './vue-components/DeliveryOrderCreate.vue'));
