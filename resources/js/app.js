/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import dependecies tambahan
import VueAxios from 'vue-axios';
import Axios from 'axios';
import Vuetify from "../plugins/vuetify"
import router from "./router"
import store from "./store"
Vue.use(VueAxios,Axios);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('drawer-admin', require('./components/menu/drawerAdmin.vue').default);
Vue.component('navbar', require('./components/menu/navbar.vue').default);
Vue.component('navbar-search', require('./components/menu/navbarSearch.vue').default);
Vue.component('footbar', require('./components/menu/footer.vue').default);
Vue.component('app-container', require('./components/appContainer.vue').default);
Vue.component('landing-page', require('./components/landing/container.vue').default);
Vue.component('search-page', require('./components/search/container.vue').default);
Vue.component('alert', require('./components/misc/alert.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify: Vuetify,
    router,
    store,
    el: '#app',
});

// import detail from './components/campaign/detailContainer.vue';

// const routes = [
//     {
//         name: 'detail',
//         path: '/campaign/detail/:id',
//         component: detail
//     }
// ]

// const routerr = new VueRouter({ mode: 'history', routes: routes });
// //new Vue(Vue.util.extend({ routerr }, app)).$mount("#app");