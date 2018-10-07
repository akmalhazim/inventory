
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')
import VueRouter from 'vue-router'
import VueSweetalert2 from 'vue-sweetalert2';

import store from './store'
import App from './components/App'
import { getCookie, deleteCookie } from './cookie'

import { routes } from './routes'

Vue.use(VueRouter)
Vue.use(VueSweetalert2)


const router = new VueRouter({
    mode: 'history',
    routes
})
/**
 * Start of Axios settings
 * @type {string}
 */

axios.defaults.baseURL = '/api/';

/**
 * End of Axios Settings
 */


Vue.mixin({
    methods: {
        j() {
            window.$('.message a').click(function(){
                event.preventDefault()
                window.$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
            });
        },
        enableTooltip() {
            Vue.nextTick(function () {
                window.$(document).ready(function(){
                    $('[data-toggle="tooltip"]').tooltip();
                });
            })

        }
    },
    mounted() {
        this.enableTooltip()
    }
})

/**
 * Vue-Router mock up
 **/

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!store.state.isLoggedIn || store.state.isLoggedIn == null) {
            if(getCookie('auth')) {
                axios.post('/auth/me', {}, {
                    headers: {
                        Authorization: 'Bearer '+getCookie('auth')
                    }
                })
                    .then(res => {
                        store.commit('login',getCookie('auth'))
                        next()
                    })
                    .catch(err => {
                        deleteCookie('auth')
                        next({
                            path: '/auth/login',
                            query: { redirect: to.fullPath }
                        })
                    })
            } else {
                next({
                    path: '/auth/login',
                    query: { redirect: to.fullPath }
                })
            }
        } else {
            next()
        }
    } else {
        next() // make sure to always call next()!
    }
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    render: h => h(App),
    router,
    store
}).$mount('#app');
