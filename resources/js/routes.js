import Login from './components/login/Login.vue'
import Home from './components/Home.vue'

export const routes = [
    {
        path: '/',
        component: Login,
    },
    {
        path: '/home',
        component: Home
    }
]