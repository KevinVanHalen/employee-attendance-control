require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import StoreData from './store'
import {routes} from './routes'
import MainApp from './components/MainApp.vue'
import Vuetify from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'

Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(Vuetify)

const store = new Vuex.Store(StoreData)
const vuetify = new Vuetify();
const router = new VueRouter({
    routes,
    mode: 'history'
})

store.dispatch('getUser')

const app = new Vue({
    el: '#app',
    store,
    router,
    vuetify,
    components: {
        MainApp
    }
});
