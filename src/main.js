import { createApp } from 'vue'
import App from './App.vue'

// VueRouter
import router from './config/router.js'

// BootstrapVue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'


const vuetify = createVuetify({
    components,
    directives

})

createApp(App)
    .use(vuetify)
    .use(BootstrapVue)
    .use(IconsPlugin)
    .use(router)
    .mount('#app')
