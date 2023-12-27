/* 
        기본셋팅 1204 최정훈 
        css 오픈소스 추가 1214 차민지
    */
		require('./bootstrap');
		import { createApp } from 'vue';
		import OpenComponent from '../components/OpenComponent.vue';
		import store from './store.js';
		import VueCookies from "vue-cookies";
		import router from './router.js';
		// AOS import
		import AOS from 'aos';
		import 'aos/dist/aos.css';
		// animate import
		import 'animate.css';
		// fontawesome import
		import { library } from '@fortawesome/fontawesome-svg-core';
		import { fas } from '@fortawesome/free-solid-svg-icons';
		import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
		import BootstrapVue3 from 'bootstrap-vue-3';
		import 'bootstrap/dist/css/bootstrap.css'
		import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'
		library.add(fas);
		const app = createApp({
			components: {
				OpenComponent,
			}
		})
		.use(store)
		.use(router)
		.component('font-awesome-icon', FontAwesomeIcon)
		.use(VueCookies);  //쿠키사용
		AOS.init();
		app.config.globalProperties.$cookies.config("1d");   //쿠키사용기간 ("1d") = 하루
		app.mount('#app')
		app.use(BootstrapVue3);  //마운트 처리