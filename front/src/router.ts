import {createWebHashHistory,createRouter} from 'vue-router';

export const router = createRouter({
  history:createWebHashHistory(),
  routes:[
    {path:'/',redirect:'/LogIn'},
    {path:'/LogIn',name:'LogIn',component:()=>import('./views/LogIn.vue')},
    {path:'/HomePage',name:'HomePage',component:()=>import('./views/HomePage.vue')}
  ]
})