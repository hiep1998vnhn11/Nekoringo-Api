import HelloWorld from './pages/HelloWorld'

export default {
    mode: 'history',
    routes: [
        {
            path: '/admin',
            name: 'HelloWorld',
            component: HelloWorld
        }
    ]
}
