require('./bootstrap')
import App from './App.vue'
import VueRouter from 'vue-router'
import Router from './router'
import Vue from 'vue'
import vuetify from './plugin/vuetify'
import axios from 'axios'

Vue.use(VueRouter)
axios.defaults.baseURL = process.env.APP_URL
console.log(process.env)

const router = new VueRouter(Router)

const app = document.getElementById('app')

new Vue({
    router,
    vuetify,
    render: function(createElement) {
        return createElement(App)
    }
}).$mount(app)
