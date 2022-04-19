import { createWebHashHistory, createRouter } from 'vue-router';

export const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    { path: '/', redirect: '/LogIn' },
    { path: '/LogIn', name: 'LogIn', component: () => import('./views/LogIn.vue') },
    {
      path: '/HomePage', name: 'HomePage', component: () => import('./views/home/HomePage.vue'), redirect: { name: 'Collection' },
      children: [
        { path: '/Collection', name: 'Collection', component: () => import('./views/home/Collection.vue') },
        { path: '/Work', name: 'Work', component: () => import('./views/home/notes/Work.vue') },
        { path: '/Life', name: 'Life', component: () => import('./views/home/notes/Life.vue') },
        { path: '/Experience', name: 'Experience', component: () => import('./views/home/notes/Experience.vue') },
        { path: '/Plane', name: 'Plane', component: () => import('./views/home/Plane.vue') },
        { path: '/Diary', name: 'Diary', component: () => import('./views/home/Diary.vue') },
      ],
    }
  ]
})