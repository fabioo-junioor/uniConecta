import { createRouter, createMemoryHistory } from "vue-router"

import Inicio from '../pages/Inicio.vue'
import Sobre from '../pages/Sobre.vue'
import Cursos from '../pages/Cursos.vue'
import MeusCursos from '../pages/MeusCursos.vue'
import Dashboard from '../pages/Dashboard.vue'
import EditarPerfil from '../pages/EditarPerfil.vue'

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
        path: '/meusCursos',
        name: 'meusCursos',
        component: MeusCursos

    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard

    },
    {
        path: '/editarPerfil',
        name: 'editarPerfil',
        component: EditarPerfil

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