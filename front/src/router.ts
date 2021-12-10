import {createWebHashHistory,createRouter} from 'vue-router';

export const router = createRouter({
  history:createWebHashHistory(),
  routes:[
    {path:'/',redirect:'/LogIn'},
    {path:'/LogIn',name:'HomePage',component:()=>import('./views/LogIn.vue')}
  ]
})