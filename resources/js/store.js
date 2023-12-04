/* 기본셋팅 1204 최정훈 */

import { createStore } from "vuex";
import axios from "axios";   //엑시오스 사용
import router from  "./router.js";    //라우터 사용
import VueCookies from "vue-cookies";    //쿠키사용



const store = createStore({
	// state() : data를 저장하는 영역
	state() {
		return {

		}
	},

	// mutations : 데이터 수정용 함수 저장 영역
	mutations: {

	},

	// actions : ajax로 서버에 데이터를 요청할 때나 시간 함수등 비동기 처리는 actions에 정의
	actions: {

	},
});


export default store;