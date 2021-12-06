import { createApp } from 'vue'
import App from './App.vue'
import './index.css'
import {router} from './router';

let app = createApp(App)
app.use(router)
app.mount('#app')
