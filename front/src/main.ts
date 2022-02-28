import { createApp } from 'vue'
import App from './App.vue'
import './index.scss'
import {router} from './router'
import naive from 'naive-ui'
import VueAxiosPlugin from 'vue-axios-plugin'

let app = createApp(App)
app.use(router)
app.use(naive)

app.use(VueAxiosPlugin, {
    // 请求拦截处理
    reqHandleFunc: config => config,
    reqErrorFunc: error => Promise.reject(error),
    // 响应拦截处理
    resHandleFunc: response => response,
    resErrorFunc: error => Promise.reject(error)
  })

app.mount('#app')
