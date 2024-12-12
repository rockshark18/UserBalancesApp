import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

import './assets/styles/reset.css'
import './assets/styles/fonts.css'
import './assets/styles/default.scss'
import './assets/styles/debug.css' // NOTE: debug only


import { createApp } from 'vue'
import App from './App.vue'
import router from "@/router/router";

const app = createApp(App)

app
	.use(router)
	.mount('#app');
