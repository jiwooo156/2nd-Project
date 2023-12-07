/* 기본셋팅 1204 최정훈 */

import { createStore } from "vuex";
import axios from "axios";   //엑시오스 사용
import router from  "./router.js";    //라우터 사용
import VueCookies from "vue-cookies";    //쿠키사용



const store = createStore({
	// state() : data를 저장하는 영역
	state() {
		return {
			emailFlg: false,
			nickFlg: false,
			varErr: [],
		}
	},

	// mutations : 데이터 수정용 함수 저장 영역
	mutations: {
		setEmailFlg(state, boo){
			state.emailFlg = boo;
		},
		setNickFlg(state, boo){
			state.nickFlg = boo;
		},
	},

	// actions : ajax로 서버에 데이터를 요청할 때나 시간 함수등 비동기 처리는 actions에 정의
	actions: {
		// 이메일 중복확인
		actionEmailChk(){
			let email = document.querySelector('#signin_email').value
			const URL = '/api/signin/'+email
			const HEADER = {
				headers: {
					'Authorization': 'Bearer team5',
				}
			};
			axios.get(URL, HEADER)
			.then(res => {
				if(res.data.code === "0"){
					if(res.data.data.length === 0){
						console.log("정상통과")
						context.commit('setIdFlg',1);
						document.querySelector('#u_id').readOnly = true;
					}else if(res.data.data.length > 0){
						context.commit('setIdFlg',2);
						console.log("flg2")
					}else {
						context.commit('setIdFlg',0);
						context.commit('setErrMsg',res.data.errorMsg);
						console.log("flg0")
					}
				}else{
					console.log('else')
					context.commit('setErrMsg',res.data.errorMsg);
				}
	
			})
			.catch(err => {
				console.log(err.response.data);
			})
		},

	},
});


export default store;