import Router from 'vue-router'
import Vue from 'vue'
import HelloWorld from './pages/HelloWorld'
import Layout from './pages/Main/Layout'
import Login from './pages/Auth/Login.vue'
import Dashboard from './pages/Main/Dashboard.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/admin/login',
            component: Login,
            name: 'Login',
            meta: {
                requiresVisitor: true
            }
        },
        {
            path: '/admin',
            component: Layout,
            meta: {
                requiresAuth: true
            },
            children: [
                {
                    path: 'dashboard',
                    name: 'Dashboard',
                    component: Dashboard
                },
                {
                    path: 'hello',
                    name: 'HelloWorld',
                    component: HelloWorld
                },
                {
                    path: '*',
                    redirect: 'dashboard'
                }
            ]
        }
    ]
})
