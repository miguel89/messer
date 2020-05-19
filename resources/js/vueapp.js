import Vue from 'vue'
import Home from './components/HomeComponent'
import RegisterComponent from "./components/RegisterComponent";
import LoginComponent from "./components/LoginComponent";
import VueAuth from '@websanova/vue-auth'
import VueAxios from "vue-axios";
import VueRouter from 'vue-router'
import auth from "./auth";
import axios from 'axios'
import AppComponent from "./components/AppComponent";
import moment from 'moment'
import ListMessages from "./components/message/ListMessages";
import CreateMessageComponent from "./components/message/CreateMessageComponent";
import EditMessage from "./components/message/EditMessage";
import ViewMessageComponent from "./components/message/ViewMessageComponent";

require('./bootstrap');

window.Vue = Vue;

// application routes
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes: [
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
        {
            path: '/announcements',
            name: 'listAnnouncements',
            component: ListMessages,
            meta: {
                auth: true
            }
        },
        {
            path: '/announcements/create',
            name: 'createAnnouncement',
            component: CreateMessageComponent,
            meta: {
                auth: true
            }
        },
        {
            path: '/announcements/:id',
            name: 'viewAnnouncement',
            component: ViewMessageComponent,
            meta: {
                auth: true
            }
        },
        {
            path: '/announcements/:id/edit',
            name: 'editAnnouncement',
            component: EditMessage,
            meta: {
                auth: true
            }
        },
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                auth: undefined
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

// register date filters
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY')
    }
});

Vue.filter('formatFullDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY HH:MM')
    }
});

const app = new Vue({
    el: '#app',
    router,
});
