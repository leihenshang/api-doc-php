import { createApp } from 'vue'
import App from './App.vue'
import './index.scss'
import Layui from '@layui/layui-vue'
import '@layui/layui-vue/lib/index.css'
import {router} from './router';

let app = createApp(App)
app.use(Layui)
app.use(router)
app.mount('#app')
