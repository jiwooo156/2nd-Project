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
		library.add(fas);
		window.Kakao.init("65d6b7b6235f7ad25b6456ae67383066");
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
		app.mount('#app')  //마운트 처리