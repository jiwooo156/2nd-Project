/* 기본셋팅 1204 최정훈 */
import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/MainComponent.vue';

const routes = [
	{
		path: "/",
		redirect : '/main'
	},
	{
		path: "/main",
		component : MainComponent
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;