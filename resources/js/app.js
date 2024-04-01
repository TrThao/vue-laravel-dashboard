import './bootstrap'
import { createApp } from 'vue';
import App from './layouts/App.vue';
import  store  from './store';
import router from './router';


createApp(App).use(store).use(router).mount('#app');
