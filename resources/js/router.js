/* 기본셋팅 1204 최정훈 */
import { createWebHistory, createRouter } from 'vue-router';

const routes = [
	{
		path: "/",
		redirect : '/'
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;