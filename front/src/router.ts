import {createWebHashHistory,createRouter} from 'vue-router';

export const router = createRouter({
  history:createWebHashHistory(),
  routes:[
    {path:'/',name:'HomePage',component:()=>import('./components/HomePage.vue')}
  ]
})