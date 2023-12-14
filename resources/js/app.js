/* 기본셋팅 1204 최정훈 */
require('./bootstrap');

import { createApp } from 'vue';
import OpenComponent from '../components/OpenComponent.vue';
import store from './store.js';
import VueCookies from "vue-cookies";
import router from './router.js';

const app = createApp({
	components: {
		OpenComponent,
	}
})
.use(store)
.use(router)
.use(VueCookies);  //쿠키사용

app.config.globalProperties.$cookies.config("1d");   //쿠키사용기간 ("1d") = 하루
app.mount('#app');  //마운트 처리



