import { createRouter, createMemoryHistory } from "vue-router"

import LoginUser from '../pages/LoginUser.vue'
import Inicio from '../pages/Inicio.vue'
import Sobre from '../pages/Sobre.vue'

const routes = [
    {
        path: '/',
        name: 'inicio',
        component: Inicio
    },
    {
        path: '/sobre',
        name: 'sobre',
        component: Sobre
    },
    {
        path: '/loginUser',
        name: 'loginUser',
        component: LoginUser,
    
    },
    {
        path: '/*',
        redirect: '/'

    }
]
const router = createRouter({
    history: createMemoryHistory(),
    routes

})

export default router