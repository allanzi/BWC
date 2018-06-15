/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VeeValidate = require('vee-validate');
window.EventBus = new Vue();

const config = {
    locale: 'pt_BR',
    dictionary: {
        pt_BR: { messages: require('vee-validate/dist/locale/pt_BR') }
    }
};


window.Vue.use(window.VeeValidate, config);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('material-header', require('./components/HeaderComponent'));
Vue.component('index-card', require('./components/welcome/CardComponent'));
Vue.component('create-modal', require('./components/welcome/ModalCreateVehicleComponent'));
Vue.component('update-modal', require('./components/welcome/ModalUpdateVehicleComponent'));

const app = new Vue({
    el: '#app'
});
