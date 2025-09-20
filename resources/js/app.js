import { createApp } from 'vue'
import App from './App.vue'
import router from './router'              // we'll add a lightweight router
import axios from 'axios'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({ components, directives })

// set axios base
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || ''

// if you use token login, axios header is set after login
// create app
const app = createApp(App)
app.use(vuetify)
app.use(router)
app.config.globalProperties.$axios = axios
app.mount('#app')
