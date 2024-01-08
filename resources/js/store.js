/* 기본셋팅 1204 최정훈 */

import { createStore } from "vuex";
import axios from "axios";   //엑시오스 사용
import router from  "./router.js";    //라우터 사용
import VueCookies from "vue-cookies";    //쿠키사용



const store = createStore({
	// state() : data를 저장하는 영역
	state() {
		return {
			nickFlg: 0,
			varErr: [],
			localFlg: false,
			NowUser: "",
			NowEmail: "",
			userFlg: false,
			userInfo: [],
			openPwModal: false,
			openNickModal: false,
			openDelModal: false,
			NowUser: "",
			beforeUrl: "",
			loading: false,
			nsFlg: "",
			qtFlg: "",
			setCategoryFlg: "",
		}
	},

	// mutations : 데이터 수정용 함수 저장 영역
	mutations: {
		setNickFlg(state, int){
			state.nickFlg = int;
		},
		setErrMsg(state, data){
			state.varErr=data;
		},
		setLocalFlg(state, boo){
			state.localFlg=boo;
		},
		setNowUser(state, str){
			state.NowUser=str;
		},
		setNowEmail(state, str){
			state.NowEmail=str;
		},
		setUserFlg(state, boo){
			state.userFlg=boo;
		},
		setUserInfo(state, data){
			state.userInfo=data;
		},
		setPasswordModalFlg(state, boo){
			state.openPwModal=boo;
		},
		setNickModalFlg(state, boo){
			state.openNickModal=boo;
		},
		setDelModalFlg(state, boo){
			state.openDelModal=boo;
		},
		setBeforeUrl(state, str){
			state.beforeUrl=str;
		},
		setLoading(state, boo){
			state.loading=boo;
		},
		setNsFlg(state, str){
			state.nsFlg=str;
		},
		setQtFlg(state, str){
			state.qtFlg=str;
		},
		setCategoryFlg(state, str){
			state.categoryflg=str;
		},
	},

	// actions : ajax로 서버에 데이터를 요청할 때나 시간 함수등 비동기 처리는 actions에 정의
	actions: {
		// 메인 데이터 불러오기
		actionGetMainInfo(context) {
			context.commit('setLoading',true);
			const url = '/api/main';
			axios.get(url)
			.then(res => {
				context.commit('setMainInfo')
			})
			.catch(err => {
				console.log(err);
			})
			.finally(() => {
				context.commit('setLoading',false);
			});
		},
		// // 이메일 중복확인
		// actionEmailChk(context){
		// 	let email = document.querySelector('#signin_email').value
		// 	// const URL = '/api/signin/email'
		// 	// 1211 최정훈 수정 api로 안보내고 web으로 변경
		// 	// const URL = '/signin/email'
		// 	// const HEADER = {
		// 	// 	headers: {
		// 	// 		// 'Authorization': 'Bearer team5',
		// 	// 		// 1211 최정훈 수정 세션에서 로그인 auth로 관리하기에 베어러 토큰 필요 x
		// 	// 		'Content-Type': 'multipart/form-data',
		// 	// 	}
		// 	// };
		// 	// const formData = new FormData();
		// 	// formData.append('email', email);
		// 	// axios.get(URL, formData, HEADER)
		// 	// 1211 최정훈 수정 get형식이 옳은방식이라 수정
		// 	const URL = '/signin/email/?email='+email
		// 	axios.get(URL)
		// 	.then(res => {
		// 		context.commit('setErrMsg','');
		// 		if(res.data.code === "0"){
		// 			if(res.data.data.length === 0){
		// 				context.commit('setEmailFlg',1);
		// 				document.querySelector('#signin_email').readOnly = true;
		// 				document.querySelector('#signin_email').style.backgroundColor = 'rgb(169 183 200)';		
		// 			}else if(res.data.data.length > 0){
		// 				console.log("있을때")
		// 				context.commit('setEmailFlg',2);
		// 			}
		// 		}else{
		// 			console.log('else')
		// 		}
		// 	})
		// 	.catch(err => {
		// 		context.commit('setEmailFlg',0);
		// 		context.commit('setErrMsg',err.response.data.errorMsg);
		// 	})
		// },
		// 1214 수정 최정훈
		// 이메일 인증 과정으로 대체

		// // 닉네임 중복확인
		// actionNickChk(context){
		// 	clearTimeout(this.debounceTimeoutId);
		// 	this.debounceTimeoutId = setTimeout(() => {
		// 		let nick = document.querySelector('#signin_nick').value
		// 		// const URL = '/api/signin/nick'
		// 		// 1211 최정훈 수정 api로 안보내고 web으로 변경
		// 		// const URL = '/signin/nick'
		// 		// const HEADER = {
		// 		// 	headers: {
		// 		// 		// 'Authorization': 'Bearer team5',
		// 		// 		// 1211 최정훈 수정 세션에서 로그인 auth로 관리하기에 베어러 토큰 필요 x
		// 		// 		'Content-Type': 'multipart/form-data',
		// 		// 	}
		// 		// };
		// 		// const formData = new FormData();
		// 		// formData.append('nick', nick);
		// 		// 1211 최정훈 수정 get형식이 옳은방식이라 수정
		// 		const URL = '/signin/nick?nick='+nick
		// 		axios.get(URL)
		// 		.then(res => {
		// 			context.commit('setErrMsg','');
		// 			if(res.data.code === "0"){
		// 				if(res.data.data.length === 0){
		// 					context.commit('setNickFlg',1);	
		// 				}else if(res.data.data.length > 0){
		// 					console.log("있을때")
		// 					context.commit('setNickFlg',2);
		// 				}
		// 			}else{
		// 				context.commit('setNickFlg',0);
		// 				console.log('else')
		// 			}
		// 		})
		// 		.catch(err => {
		// 			context.commit('setNickFlg',0);
		// 			context.commit('setErrMsg',err.response.data.errorMsg);		
		// 		})
		// 	}, 200);
		// },	
		// 회원가입
		actionSignIn(context){
			context.commit('setLoading',true);
			if(context.state.nickFlg===1){
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
				// const URL = '/api/signin'
				// 1211 최정훈 수정 api로 안보내고 web으로 변경
				const URL = '/signin'
				const HEADER = {
					headers: {
						// 'Authorization': 'Bearer team5',
						// 1211 최정훈 수정 세션에서 로그인 auth로 관리하기에 베어러 토큰 필요 x
						'Content-Type': 'multipart/form-data',
					}
				};
				const formData = new FormData();
				formData.append('email', email.value);
				formData.append('password', pw.value);
				formData.append('pw_chk', pwchk.value);
				formData.append('name', name.value);
				formData.append('nick', nick.value);
				formData.append('birthdate', birthdate.value);
				formData.append('phone', phone.value);
				formData.append('gender', gender);
				axios.post(URL, formData, HEADER)
				.then(res => {		
					if(res.data.code === "0"){
						alert("회원가입에 성공 했습니다.");
						router.push('/login')
					}else{
						alert(res.data.errorMsg);
					}
				})
				.catch(err => {
					// 캣치
					console.log("캣치")
					alert(err.response.data.errorMsg);
				})
				.finally(() => {
					context.commit('setLoading',false);
				});
			}else{
				alert("닉네임 인증을 해주세요")
			}
		},
		// 로그인
		actionLogin(context){
			context.commit('setLoading',true);
			let email = document.querySelector('#login_email').value;
			let pw = document.querySelector('#login_pw').value;
				// const URL = '/api/login''
				// 1211 최정훈 수정 api로 안보내고 web으로 변경	
				const URL = '/login'
				const HEADER = {
					headers: {
						// 'Authorization': 'Bearer team5',
						// 1211 최정훈 수정 세션에서 로그인 auth로 관리하기에 베어러 토큰 필요 x
						'Content-Type': 'multipart/form-data',
					}
				};
				const formData = new FormData();
				formData.append('email', email);
				formData.append('password', pw);

				axios.post(URL,formData,HEADER)
				.then(res => {
					if(res.data.code === "0"){	
						localStorage.setItem('nick', res.data.data.nick);
						localStorage.setItem('email', email);
						context.commit('setLocalFlg', true);
						context.commit('setNowUser', localStorage.getItem('nick'));
						context.commit('setNowEmail', localStorage.getItem('email'));
						if(!(context.state.beforeUrl === "/login"||context.state.beforeUrl=== "signin"||context.state.beforeUrl=== "authemail")){
							router.push(context.state.beforeUrl)
						}else{
							router.push('/main')
						}
					}else if(res.data.code === "1"){
						alert('환영합니다. '+res.data.data.name+" 관리자님")
						localStorage.setItem('nick', res.data.data.nick);
						localStorage.setItem('email', email);
						localStorage.setItem('admin', res.data.data.id);
						context.commit('setLocalFlg', true);
						context.commit('setNowUser', localStorage.getItem('nick'));
						context.commit('setNowEmail', localStorage.getItem('email'));
						router.push('/admin')
					}else if(res.data.code === "E07"){
						alert('해당계정은. '+res.data.data.restaint_at+" 까지 이용이 제한된 이메일 입니다.\n"+"제재사유 : "+res.data.data.restaint)
					}else{
						console.log('else');
						alert(err.response.data.errorMsg);
					}
				})
				.catch(err => {
					console.log("제제진입 캣치")
					if(err.response.data.errorMsg.email){
						alert(err.response.data.errorMsg.email)
					}else if(err.response.data.errorMsg.password){
						alert(err.response.data.errorMsg.password)
					}else{
						alert(err.response.data.errorMsg[0])
					}
				})
				.finally(() => {
					context.commit('setLoading',false);
				});
		},
		// 로그아웃
		actionLogout(context){
				// // const URL = '/api/logout''
				// // 1211 최정훈 수정 api로 안보내고 web으로 변경	
				// const URL = '/logout'
				// const HEADER = {
				// 	headers: {
				// 		// 'Authorization': 'Bearer team5',
				// 		// 1211 최정훈 수정 세션에서 로그인 auth로 관리하기에 베어러 토큰 필요 x
				// 		'Content-Type': 'multipart/form-data',
				// 	}
				// };
				// const formData = new FormData();
				// formData.append('nick',context.state.NowUser);
				// 1211 최정훈 수정 get형식이 옳은방식이라 수정
				const URL = '/logout'
				axios.get(URL)
				.then(res => {
					if(res.data.code === "0"){	
						localStorage.clear();
						context.commit('setLocalFlg',false);
						context.commit('setNowUser','');
						context.commit('setUserFlg',false);
						console.log('code : 0');
						router.push('/main');
						console.log('code : push main');
					}
				})
				.catch(err => {
					alert(err.response.data.errorMsg)
				})
		},
		// 유저정보페이지 비밀번호 체크
		actionUserChk(context){
			context.commit('setLoading', true);
			let pw = document.querySelector('#userchk_pw').value;
			const URL = '/userchk'
			const HEADER = {
				headers: {
					'Content-Type': 'multipart/form-data',
				}
			};
			const formData = new FormData();
			formData.append('password', pw);
			axios.post(URL,formData,HEADER)
			.then(res => {
				if(res.data.code === "0"){	
					context.commit('setErrMsg','');
					context.commit('setUserFlg',true);
					router.push('/user')
				}else{
					context.commit('setErrMsg',res.data.errorMsg);
				}	
			})
			.catch(err => {
				if(err.response.data.code === "E03"){
					context.commit('setErrMsg',err.response.data.errorMsg.password);
					context.commit('setUserFlg',false);
				}else{
					context.commit('setErrMsg',err.response.data.errorMsg);
					context.commit('setUserFlg',false);
				}
			})
			.finally(() => {
				context.commit('setLoading', false);
			});
		},
		// 유저정보페이지 비밀번호 체크
		actionUserChk(context){
			let pw = document.querySelector('#userchk_pw').value;
			const URL = '/userchk'
			const HEADER = {
				headers: {
					'Content-Type': 'multipart/form-data',
				}
			};
			const formData = new FormData();
			formData.append('password', pw);
			axios.post(URL,formData,HEADER)
			.then(res => {
				if(res.data.code === "0"){	
					context.commit('setErrMsg','');
					context.commit('setUserFlg',true);
					router.push('/user')
				}else{
					context.commit('setErrMsg',res.data.errorMsg);
				}
			})
			.catch(err => {
				if(err.response.data.code === "E03"){
					context.commit('setErrMsg',err.response.data.errorMsg.password);
					context.commit('setUserFlg',false);
				}else{
					context.commit('setErrMsg',err.response.data.errorMsg);
					context.commit('setUserFlg',false);
				}
			})
		},
		// 유저페이지 비밀번호변경
		actionChangePw(context){
			let pw = document.querySelector('#user_pw').value;
			let pw_chk = document.querySelector('#user_pw_chk').value;
				const URL = '/user/pchk'
				const HEADER = {
					headers: {
						'Content-Type': 'multipart/form-data',
					}
				};
				const formData = new FormData();
				formData.append('password', pw);
				formData.append('pw_chk', pw_chk);

				axios.post(URL,formData,HEADER)
				.then(res => {
					if(res.data.code === "0"){	
						context.commit('setPasswordModalFlg',false);
						alert('정상처리되었습니다');
						router.push('/userchk')
					}else{
						alert(res.data.errorMsg);
					}
				})
				.catch(err => {
					alert("비밀번호의 값을 다시한번 확인해주세요");
				})
		},
		// 유저 탈퇴
		actiondeluser(context){
			let delflg = "0";
			let delmsg = "";
			let delreason = document.querySelector('#user_del_reason');
			delmsg = delreason.value;
			if(delmsg === "서비스 불만족"){
				delflg = "1";
			}else if(delmsg === "원하는 정보가 없음"){
				delflg = "2";
			}else if(delmsg === "불건전한 내용"){
				delflg = "3";
			}else if(delmsg === "기타"){
				let msg = document.querySelector('#user_del_reason_input').value;
				if(msg === ""){
					msg = "미입력"
				}
				delmsg = msg
			}
			const URL = '/user/del'
			const HEADER = {
				headers: {
					'Content-Type': 'multipart/form-data',
				}
			};
			const formData = new FormData();
			formData.append('del_flg', delflg);
			formData.append('del_msg', delmsg);

			axios.post(URL,formData,HEADER)
			.then(res => {
				if(res.data.code === "0"){
					alert("정상적으로 탈퇴 되었습니다");
					context.dispatch('actionLogout');
				}else{
					alert("회원탈퇴중 오류가 발생했습니다.");
				}
			
			})
			.catch(err => {
				alert(err.response.data)
			})
		},
	},
});


export default store;