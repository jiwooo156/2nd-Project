/* 기본셋팅 1204 최정훈 */
require('./bootstrap');

import { createApp } from 'vue';
import OpenComponent from '../components/OpenComponent.vue';
import store from './store.js';
import VueCookies from "vue-cookies";
import router from './router.js';
import BootstrapVue3 from 'bootstrap-vue-3';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';

const app = createApp({
	components: {
		OpenComponent,
	}
})
.use(store)
.use(router)
.use(VueCookies)  //쿠키사용
.use(BootstrapVue3);

app.config.globalProperties.$cookies.config("1d");   //쿠키사용기간 ("1d") = 하루
app.mount('#app');  //마운트 처리



