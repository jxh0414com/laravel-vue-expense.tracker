/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify);

import router from './router'
import store from './store/store'
import Navbar from './components/layout/Navbar'

store.dispatch('loadUser', localStorage.getItem('token')).then(() => {
    new Vue({
        el: '#app',
        router,
        store,
        vuetify: new Vuetify(),

        components: { Navbar }
    });
})
