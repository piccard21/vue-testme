/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import 'busy-load';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import { store } from './store';

Vue.use(ElementUI, {locale});

Vue.component('ix-jumbotron', require('./components/Jumbotron.vue'));
Vue.component('ix-search', require('./components/Searchfield.vue'));
Vue.component('ix-nav-btn', require('./components/NavBtn.vue'));
Vue.component('ix-next-btn', require('./components/NextDomainSelectionBtn.vue'));
Vue.component('ix-authenticate-btn', require('./components/NextAuthenticateBtn.vue'));
Vue.component('ix-domain-list', require('./components/DomainList.vue'));
Vue.component('ix-order-list', require('./components/OrderList.vue'));
Vue.component('ix-order-process', require('./components/OrderProcess.vue'));
Vue.component('ix-authentification', require('./components/Authentification.vue'));
Vue.component('ix-tld-list', require('./components/TldList.vue'));
Vue.component('ix-steps', require('./components/Steps.vue'));

$(document).ready(function() {
	const app = new Vue({
		el: '#app',
    	store,
	});
})