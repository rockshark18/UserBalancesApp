import {createRouter, createWebHistory} from "vue-router";

import HomePage from "@/pages/HomePage.vue";
import AboutPage from "@/pages/AboutPage.vue";
import Login from "@/pages/Login.vue";
import { getToken } from '@/util/cookies.js';

const routes = [
	{
		path: '/',
		name: 'Home',
		component: HomePage
	},
	{
		path: '/login',
		name: 'Login',
		component: Login
	},
	{
		path: '/about',
		name: 'About',
		component: AboutPage
	},
]

const router = createRouter({
	routes,
	history: createWebHistory(import.meta.env.BASE_URL )
})


router.beforeEach((to, from, next) => {
	const token = getToken();
	if (!token && (to.name === 'Home' || to.name === 'About')) {
		next('/login');
	} else {
		next();
	}
});

export default router;
