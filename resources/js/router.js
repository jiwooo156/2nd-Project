/* 기본셋팅 1204 최정훈 */
import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/MainComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';
import SigninComponent from '../components/SigninComponent.vue';
import UserComponent from '../components/UserComponent.vue';
import VueCookies from "vue-cookies";
const routes = [
	{
		path: "/",
		redirect : '/main'
	},
	{
		path: "/main",
		component : MainComponent
	},
	{
		path: "/login",
		component: LoginComponent,
		beforeEnter: (to, from, next) => {
			if (VueCookies.get('nick')) {
				next('/');
			} else {
				next();
			}
		},
	},
	{
		path: "/signin",
		component : SigninComponent,
		beforeEnter: (to, from, next) => {
			if (VueCookies.get('nick')) {
				console.log(VueCookies.get('nick'));
				next('/');
			} else {
				next();
			}
		},
	},
	{
		path: "/user",
		component : UserComponent
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;