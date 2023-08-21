import { createRouter, createMemoryHistory } from "vue-router"

import Cursos from '../pages/Cursos.vue'
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
        path: '/cursos',
        name: 'cursos',
        component: Cursos,
        
    
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