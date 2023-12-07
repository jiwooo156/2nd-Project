/* 기본셋팅 1204 최정훈 */

import { createStore } from "vuex";
import axios from "axios";   //엑시오스 사용
import router from  "./router.js";    //라우터 사용
import VueCookies from "vue-cookies";    //쿠키사용



const store = createStore({
	// state() : data를 저장하는 영역
	state() {
		return {
			emailFlg: 0,
			nickFlg: 0,
			varErr: [],
		}
	},

	// mutations : 데이터 수정용 함수 저장 영역
	mutations: {
		setEmailFlg(state, int){
			state.emailFlg = int;
		},
		setNickFlg(state, boo){
			state.nickFlg = boo;
		},
		setErrMsg(state, data){
			state.varErr=data;
		},
	},

	// actions : ajax로 서버에 데이터를 요청할 때나 시간 함수등 비동기 처리는 actions에 정의
	actions: {
		// 이메일 중복확인
		actionEmailChk(context){
			let email = document.querySelector('#signin_email').value
			const URL = '/api/signin/email'
			const HEADER = {
				headers: {
					'Authorization': 'Bearer team5',
					'Content-Type': 'multipart/form-data',
				}
			};
			const formData = new FormData();
			formData.append('email', email);
			axios.post(URL, formData, HEADER)
			.then(res => {
				context.commit('setErrMsg','');
				if(res.data.code === "0"){
					if(res.data.data.length === 0){
						context.commit('setEmailFlg',1);
						document.querySelector('#signin_email').readOnly = true;
						document.querySelector('#signin_email').style.backgroundColor = 'rgb(169 183 200)';		
					}else if(res.data.data.length > 0){
						console.log("있을때")
						context.commit('setEmailFlg',2);
					}
				}else{
					console.log('else')
				}
			})
			.catch(err => {
				console.log(err.response.data);
				context.commit('setErrMsg',err.response.data.errorMsg);
			})
		},

		// 닉네임 중복확인
		actionNickChk(context){
			if(context.state.emailFlg===1){
				let nick = document.querySelector('#signin_nick').value
				const URL = '/api/signin/nick'
				const HEADER = {
					headers: {
						'Authorization': 'Bearer team5',
						'Content-Type': 'multipart/form-data',
					}
				};
				const formData = new FormData();
				formData.append('nick', nick);
				axios.post(URL, formData, HEADER)
				.then(res => {
					context.commit('setErrMsg','');
					if(res.data.code === "0"){
						if(res.data.data.length === 0){
							context.commit('setNickFlg',1);
							document.querySelector('#signin_nick').readOnly = true;
							document.querySelector('#signin_nick').style.backgroundColor = 'rgb(169 183 200)';		
						}else if(res.data.data.length > 0){
							console.log("있을때")
							context.commit('setNickFlg',2);
						}
					}else{
						console.log('else')
					}
				})
				.catch(err => {
					console.log(err.response.data);
					context.commit('setErrMsg',err.response.data.errorMsg);
				})
			}else{
				alert("이메일 인증을 해주세요")
			}
		},

		// 회원가입
		actionSignIn(context){
			if(context.state.emailFlg===1){
				let email = document.querySelector('#signin_email')
				let pw = document.querySelector('#signin_pw')
				let pwchk = document.querySelector('#signin_pw_chk')
				let name = document.querySelector('#signin_name')
				let nick = document.querySelector('#signin_nick')
				let birthdate = document.querySelector('#signin_birthdate')
				let phone = document.querySelector('#signin_phone')
				let gender = document.querySelector('#signin_gender').value
				if (gender === "남자"){
					gender = "M"
				}else if(gender === "여자"){
					gender = "F"
				}
				const URL = '/api/signin'
				const HEADER = {
					headers: {
						'Authorization': 'Bearer team5',
						'Content-Type': 'multipart/form-data',
					}
				};
				const formData = new FormData();
				formData.append('email', email.value);
				formData.append('pw', pw.value);
				formData.append('pw_chk', pwchk.value);
				formData.append('name', name.value);
				formData.append('nick', nick.value);
				formData.append('birthdate', birthdate.value);
				formData.append('phone', phone.value);
				formData.append('gender', gender);
				console.log(pw.value);
				axios.post(URL, formData, HEADER)
				.then(res => {
				
					if(res.data.code === "0"){
						alert("회원가입에 성공 했습니다.");
						context.commit('setErrMsg',[]);
						email.value = '';
						pw.value = '';
						pwchk.value = '';
						name.value = '';
						nick.value = '';
						birthdate.value = '';
						phone.value = '';
						router.push('/login')
					}else{
						context.commit('setErrMsg',res.data.errorMsg);
					}
				})
				.catch(err => {
					context.commit('setErrMsg',err.response.data.errorMsg);
				})
			}else{
				alert("닉네임 인증을 해주세요")
			}
		},
		

	},
});


export default store;