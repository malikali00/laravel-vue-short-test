import { createApp } from 'vue';
import App from './layouts/App.vue';
import router from './router';
import store from './store';
import Header from './views/ui/Header.vue';
import Sidebar from './views/ui/Sidebar.vue';

// Create the Vue app instance
const app = createApp(App);

// Register the Header component globally
app.component('Header', Header);
app.component('Sidebar', Sidebar);

// Use Vue Router and Vuex
app.use(router).use(store);

// Mount the app to a DOM element
app.mount('#app');
