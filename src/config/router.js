import { createRouter, createMemoryHistory } from "vue-router"

const routes = [
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