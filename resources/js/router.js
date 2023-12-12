/* 기본셋팅 1204 최정훈 */
import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/MainComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';
import SigninComponent from '../components/SigninComponent.vue';
import UserComponent from '../components/UserComponent.vue';
import UserChk from '../components/UserChk.vue';
import store from './store.js'
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
			if (store.state.localFlg) {
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
			if (store.state.localFlg) {
				next('/');
			} else {
				next();
			}
		},
	},
	{
		path: "/userchk",
		component : UserChk,
		// 1211 최정훈 추가 유저페이지는 로그인 했을때만 이동가능
		beforeEnter: (to, from, next) => {
			if (!store.state.localFlg) {
				console.log('routes : userchk > /');
				next('/');
			} else {
				next();
			}
		}		
	},
	{
		path: "/user",
		component : UserComponent,
		// 1211 최정훈 추가 유저페이지는 로그인 했을때만 이동가능
		beforeEnter: (to, from, next) => {
			if (!store.state.userFlg) {
				console.log('routes : user > userchk');
				next('/userchk');
			} else {
				next();
			}
		}		
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;