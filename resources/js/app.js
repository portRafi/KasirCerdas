import { createApp } from 'vue';
import KasirApp from './components/.vue';

const app = createApp({});
app.component('kasir-app', KasirApp);
app.mount('#app'); // Akan mengaitkan Vue ke elemen HTML dengan ID 'app'
