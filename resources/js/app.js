import './bootstrap'
import { createApp } from 'vue'
import router from './router/index'
import '@mdi/font/css/materialdesignicons.css'
import App from './web/App.vue';


// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import NavbarComponent from "@/Components/Navbar.vue";
import DrawerComponent from "@/Components/Drawer.vue";




const app = createApp(App);
const vuetify = createVuetify({
    components,
    directives,
})


app.use(router);
app.use(vuetify)
app.component('Navbar', NavbarComponent);
app.component('Drawer', DrawerComponent);
app.mount('#app');