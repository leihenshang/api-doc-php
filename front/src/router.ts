import { createWebHashHistory, createRouter } from 'vue-router';

export const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    { path: '/', redirect: '/LogIn' },
    { path: '/LogIn', name: 'LogIn', component: () => import('./views/LogIn.vue') },
    {
      path: '/HomePage', name: 'HomePage', component: () => import('./views/home/HomePage.vue'), redirect: { name: 'ProjectList' },
      children: [
        { path: '/ProjectList', name: 'ProjectList', component: () => import('./views/home/ProjectList.vue') },
        { path: '/MyNote', name: 'MyNote', component: () => import('./views/home/MyNote.vue') },
      ],
    }
  ]
})