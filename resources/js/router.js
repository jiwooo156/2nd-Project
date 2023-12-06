/* 기본셋팅 1204 최정훈 */
import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/MainComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';
import SigninComponent from '../components/SigninComponent.vue';
import UserComponent from '../components/UserComponent.vue';

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
		component : LoginComponent
	},
	{
		path: "/signin",
		component : SigninComponent
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