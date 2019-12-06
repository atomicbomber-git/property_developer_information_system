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

require('./components/CreateVendorForm.jsx');
require('./components/AddContactPersonsForm.jsx')
require('./components/UpdateDeliveryOrderPricesForm')
require('./components/UpdateInvoicePaymentForm')
require('./components/CreateInvoiceForm')

/* Load global functions */
window.currencyDataTableRenderer = require('./helpers/number').currencyDataTableRenderer

/* Initialize Vue */
window.Vue = require('vue');

/* Register all vue components */
Vue.component('delivery-order-create', () =>
    import ( /* webpackChunkName:"/js/components/delivery-order-create" */ './vue-components/DeliveryOrderCreate.vue'));
Vue.component('delivery-order-edit', () =>
    import ( /* webpackChunkName:"/js/components/delivery-order-edit" */ './vue-components/DeliveryOrderEdit.vue'));
Vue.component('internal-delivery-order-create', () =>
    import ( /* webpackChunkName:"/js/components/delivery-order-create" */ './vue-components/InternalDeliveryOrderCreate.vue'));
Vue.component('item-create', () =>
    import ( /* webpackChunkName:"/js/components/item-create" */ './vue-components/ItemCreate.vue'));
Vue.component('item-edit', () =>
    import ( /* webpackChunkName:"/js/components/item-edit" */ './vue-components/ItemEdit.vue'));
Vue.component('storage-stock-adjustment-create', () =>
    import ( /* webpackChunkName:"/js/components/storage-stock-adjustment-create" */ './vue-components/StorageStockAdjustmentCreate.vue'));
Vue.component('delivery-order-price-edit', () =>
    import ( /* webpackChunkName:"/js/components/delivery-order-price-edit" */ './vue-components/DeliveryOrderPriceEdit.vue'));

const app = new Vue({
    el: '#app'
});