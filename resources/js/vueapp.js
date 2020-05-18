import Vue from 'vue'
import Example from './components/ExampleComponent'
import RegisterComponent from "./components/RegisterComponent";
import LoginComponent from "./components/LoginComponent";
import VueAuth from '@websanova/vue-auth'
import VueAxios from "vue-axios";
import VueRouter from 'vue-router'
import auth from "./auth";
import axios from 'axios'
import AppComponent from "./components/AppComponent";
import 'es6-promise/auto'

window.Vue = Vue;

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Example,
            meta: {
                auth: false
            }
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterComponent,
            meta: {
                auth: false
            }
        },
        {
            path: '/login',
            name: 'login',
            component: LoginComponent,
            meta: {
                auth: false
            }
        },
    ],
});
Vue.use(VueRouter);
Vue.router = router;

// Set Vue authentication
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
Vue.use(VueAuth, auth);

Vue.component('app', AppComponent);

const app = new Vue({
    el: '#app',
    router,
});
