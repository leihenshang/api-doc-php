import { createApp } from 'vue'
import App from './App.vue'
import './index.scss'
import {router} from './router';
import naive from 'naive-ui'

let app = createApp(App)
app.use(router)
app.use(naive)
app.mount('#app')
