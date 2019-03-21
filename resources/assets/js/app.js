
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter);

let routes = [
    {path: '/',   component: require('./components/Dashboard')},
    {path: '/projects/',    component: require('./components/Project')},
    {path: '/members/',     component: require('./components/Member')},
]

const router = new VueRouter({
    routes: routes,
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('vue-app', require('./components/App.vue'));
Vue.component('vue-project', require('./components/Project.vue'));
Vue.component('vue-dashboard', require('./components/Dashboard.vue'));
Vue.component('vue-member', require('./components/Member.vue'));
Vue.component('form-member', require('./components/children/FormCreateEditMember.vue'));

const app = new Vue({
    el: '#app',
    router: router,
});

