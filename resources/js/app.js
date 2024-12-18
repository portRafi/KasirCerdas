import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from './Pages/Kasir/dashboard.vue'; 

const routes = [
  {
    path: '/kasir/dashboard',
    component: Dashboard, 
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

createApp({}).use(router).mount('#app');
