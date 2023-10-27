import { createRouter, createWebHistory } from "vue-router"

import { getDadosUsuarioLocal } from "./global.js"
let dadosUsuario = await getDadosUsuarioLocal()

import Inicio from '../pages/Inicio.vue'
import Sobre from '../pages/Sobre.vue'
import Cursos from '../pages/Cursos.vue'
import MeusCursos from '../pages/MeusCursos.vue'
import Dashboard from '../pages/Dashboard.vue'
import EditarPerfil from '../pages/EditarPerfil.vue'
import PerfilUsuario from '../pages/PerfilUsuario.vue'

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
        path: '/perfilUsuario/:pk',
        name: 'perfilUsuario',
        component: PerfilUsuario,
        beforeEnter: (_, __, next) => {
            next()
            return

        }        
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
                next('/')
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
                console.log("edit-- ")
                return

            }
        }
    },
    {
        path: '/:pathMatch(.*)',
        name: 'inicio',
        component: Inicio,
        beforeEnter: (_, __, next) => {
            next()
            return

        }
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes

})

export default router