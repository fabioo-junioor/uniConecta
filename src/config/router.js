import { createRouter, createWebHistory } from "vue-router"

import { getDadosUsuarioLocal } from "./global.js"
let dadosUsuario = getDadosUsuarioLocal()
let url = import.meta.env.VITE_URL_FRONT

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
        component: MeusCursos,
        beforeEnter: (_, __, next) => {
            const userLogado = (dadosUsuario != null) ? true : false
            if(userLogado){
                next()
                return

            }else{
                next('/')
                return

            }
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        beforeEnter: (_, __, next) => {
            const userLogado = (dadosUsuario != null) ? true : false
            if(userLogado){
                next()
                return

            }else{
                next(url)
                return
                
            }
        }
    },
    {
        path: '/editarPerfil',
        name: 'editarPerfil',
        component: EditarPerfil,
        beforeEnter: (_, __, next) => {
            const userLogado = (dadosUsuario != null) ? true : false
            if(userLogado){
                next()
                return

            }else{
                next('/')
                return

            }
        }
    },
    {
        path: '/*',
        redirect: url

    }
]
const router = createRouter({
    history: createWebHistory(),
    routes

})

export default router