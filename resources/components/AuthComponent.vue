<template>
<div class="sign_bg">
		<div class="auth_frame">
			<div  class="sign_header center" >
				<router-link :to="'/main'" class="sign_header_a  pointer"><img src="/img/logo.png" alt="" class="login_logo"></router-link>
			</div>
			<div>
				<div class="auth_container" v-if="!(this.auth_flg)&&!(this.repeat_flg)">
					<div>
					</div>
					<div class="auth_check">
						<div class="auth_check_left">
							<div class="auth_check_msg">
								<SecConsent class="auth_consent"></SecConsent>
							</div>
							<div class="auth_input_div">
								<input type="checkbox" id="sign_check_input_left" class="pointer" v-model="input_left">
								<label for="sign_check_input_left" class="pointer font_air bold">개인정보수집동의<span class="font_air bold">(필수)</span></label>
							</div>
						</div>
						<div class="auth_check_right">
							<div class="auth_check_msg">
								<ConsentComponent class="auth_consent"></ConsentComponent>
							</div>
							<div class="auth_input_div">
								<input type="checkbox" id="auth_check_input_right" class="pointer" v-model="input_right">
								<label for="auth_check_input_right" class="pointer font_air bold">유저약관<span class="font_air bold">(필수)</span></label>
							</div>
						</div>
					</div>
					<div class="sign_all_agree">
						<div class="auth_input_div">
							<input type="checkbox" id="auth_check_input_all" class="pointer" v-model="input_all">
							<label for="auth_check_input_all" class="pointer font_air bold">전체동의</label>
						</div>
						<br>
					</div>
					<div class="auth_relative" v-if="input_all">
						<span class="font_air bold">E-mail 인증하기</span>
						<div
							v-if="!(this.email_flg)"
							v-for="item in errorMsg" :key="item"
							class="auth_errmsg font_air bold"
						>{{ item[0] }}</div>
						<div class="auth_relative">
						<input type="text" placeholder="사용하실 이메일을 입력해주세요" autocomplete='off' v-model="auth_email" id="auth_email" class="auth_container_input font_air bold">
						<button class="auth_absolute auth_chk_btn pointer font_air bold"
							@click="email_auth"
						>인증하기</button>
						</div>
					</div>
					<br>
				</div>
			</div>
			<div
				class="auth_success_div center font_air bold"
			>
				<div
					v-if="email_flg&&auth_flg&&!(timeout_flg)&&!(repeat_flg)"
					class="sign_commsg font_air bold auth_com_msg_t"
				> {{ auth_email }} 로<br>
				이메일이 전송되었습니다.</div>
				<div
					v-if="email_flg&&auth_flg&&!(timeout_flg)&&!(repeat_flg)"
					class="font_air bold"
				>5분 이내로 이메일의 링크를 클릭하여 회원가입을 이어가 주세요.</div>
				<div
					v-if="repeat_flg"
					class="sign_errmsg font_air bold"
				>10분이내 최대 3번 이메일 인증이 가능합니다. 잠시 후 다시 시도해 주세요</div>
				<button
					class="pointer auth_chk_btn font_air bold"
					v-if="repeat_flg"
				><router-link to="/main" class="font_air bold">나가기</router-link></button>	
				<div
					v-if="timeout_flg"
					class="auth_errmsg font_air bold"
				>인증시간이 만료되었습니다.</div>
				<div
					class="auth_errmsg font_air bold"
					v-if="!(email_flg)"
				>{{this.auth_err}}</div>
				<!-- <button 
					class="pointer auth_button"
					v-if="!(email_flg)&&!(auth_flg)&&re_auth_email||timeout_flg"
					@click="email_re_auth"
				>다시보내기</button> -->
				<!-- 다시보내기 통합 -->
				<div class="auth_success_bottom">
					<div>
						<span
							v-if="this.email_flg&&this.auth_flg&&!(timeout_flg)&&!(repeat_flg)"
							class="font_air bold"
						>
							남은시간 : {{this.timer}}
						</span>
					</div>
					<div>
						<button
							class="pointer auth_chk_btn font_air bold "
							v-if="this.email_flg&&this.auth_flg&&!(timeout_flg)&&!(repeat_flg)"
							@click="reset_auth_time"
						>시간연장</button>
						<button
							class="pointer auth_chk_btn font_air bold"
							v-if="(this.email_flg&&this.auth_flg&&!(timeout_flg)&&!(repeat_flg))||timeout_flg"
							@click="email_auth"
						>다시보내기</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import ConsentComponent from './ConsentComponent.vue'
import SecConsent from './SecConsent.vue'

export default {
	name: 'AuthComponent',
	props: {

	},
	
	components: {
		ConsentComponent,SecConsent
	},

	data() {
		return {
			timerId: null, 
			auth_email: "",
			auth_flg: false,
			re_auth_email: false,
			auth_err: "",
			timer: "",
			timeout_flg: false,
			input_left: false,
			input_right: false,
			input_all: false,
			email_flg: false,
			repeat_flg: false,
			errorMsg:[],
		}
	},
	watch: {
		// 전체 동의 클릭시
		input_all(){
			this.inputAll();
			this.inputRight();
			this.inputLeft();
		},
		// 왼쪽 동의 클릭
		input_left(){
			this.inputLeft();
		},
		// 오른쪽 동의 클릭
		input_right(){
			this.inputRight();
		}
	},
	created() {
		// 로컬스토리지에 저장된 정보있는지 확인
		let boo = localStorage.getItem('nick') ?  true : false;
		this.$store.commit('setLocalFlg', boo);
		// 로딩기능켜기
		this.$store.commit('setLoading',true);
	},

	mounted() {
		// 로딩기능끄기
		this.$store.commit('setLoading',false);

	},

	methods: {
		// 이메일인증보내기
		email_auth(){
			this.$store.commit('setLoading',true);
			const URL = '/authemail';
			const HEADER = {
				headers: {
					'Content-Type': 'multipart/form-data',
				}
			};
			const formData = new FormData();
			formData.append('email', this.auth_email);
			axios.post(URL,formData,HEADER)
			.then(res => {
				if(res.data.code === "0"){	
					this.email_flg = true
					this.auth_flg = true;
					this.timeout_flg = false;
					this.timer1();			
				// }else if(res.data.code === "E12"){
				// 	this.errorMsg = []
				// 	this.auth_err = res.data.errorMsg;
				// 	this.timeout_flg = false;
				// 	this.re_auth_email = true;
				// 1228 수정 최정훈 이미발송되었습니다 상황 삭제
				}else if(res.data.code === "E13"){
					this.auth_err = ""
					this.timeout_flg = false;
					this.errorMsg = []
					this.repeat_flg = true
				}
			})
			.catch(err => {

				this.auth_err="";
				this.errorMsg=err.response.data.errorMsg;
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// // 이메일 다시보내기
		// email_re_auth(){
		// 	const URL = '/authemail/resend'
		// 	const HEADER = {
		// 		headers: {
		// 			'Content-Type': 'multipart/form-data',
		// 		}
		// 	};
		// 	const formData = new FormData();
		// 	formData.append('email', this.auth_email);
		// 	axios.post(URL,formData,HEADER)
		// 	.then(res => {
		// 		if(res.data.code === "0"){	
		// 			console.log("이메일 다시보내기 댄")
		// 			this.email_flg = true
		// 			this.auth_err = '';
		// 			this.auth_flg = true;
		// 			this.timeout_flg = false;
		// 			this.timer1();	
		// 		}else if(res.data.code === "E13"){
		// 			console.log("엘스")
		// 			this.auth_err = ""
		// 			this.errorMsg = []
		// 			this.repeat_flg = true
		// 		}else{
		// 			console.log("이메일 다시보내기 앨스")
		// 			this.auth_err = res.data.errorMsg;
		// 		}
		// 	})
		// 	.catch(err => {
		// 		console.log("이메일 다시보내기 캐치")
		// 	})
		// },
		// 1228 수정 최정훈 이메일 다시보내기는 기존 발송으로 통합 

		// 시간연장
		reset_auth_time(){
			this.$store.commit('setLoading',true);
			const URL = '/authemail/time';
			const HEADER = {
				headers: {
					'Content-Type': 'multipart/form-data',
				}
			};
			const formData = new FormData();
			formData.append('email', this.auth_email);
			axios.post(URL,formData,HEADER)
			.then(res => {
				if(res.data.code === "0"){	
					// 타이머 함수 호출
					this.timer1();
				}else{
					alert(res.data.errorMsg);
				}
			})
			.catch(err => {
				alert(err.response.data.errorMsg);
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// // 이메일중복확인
		// emailChk(){
		// 	const URL = '/signin/email/?email='+this.auth_email
		// 	axios.get(URL)
		// 	.then(res => {
		// 		this.$store.commit('setErrMsg','');
		// 		if(res.data.code === "0"){
		// 			if(res.data.data.length === 0){
		// 				this.$store.commit('setemail_flg',1);
		// 				document.querySelector('#auth_email').readOnly = true;
		// 				document.querySelector('#auth_email').style.backgroundColor = 'rgb(169 183 200)';		
		// 			}else if(res.data.data.length > 0){
		// 				console.log("있을때")
		// 				this.$store.commit('setemail_flg',2);
		// 			}
		// 		}else{
		// 			console.log('else')
		// 		}
		// 	})
		// 	.catch(err => {
		// 		this.$store.commit('setemail_flg',0);
		// 		this.$store.commit('setErrMsg',err.response.data.errorMsg);
		// 	})
		// },
		// 1218 수정 최정훈 멘토님이말씀하신대로 기능 한개로 통합

		// // 이메일 중복확인 취소
		// del_email_chk(){
		// 	this.$store.commit('setemail_flg',0);
		// 	document.querySelector('#auth_email').readOnly = false;
		// 	document.querySelector('#auth_email').removeAttribute('style');
		// 	this.timerstop()
		// 	this.re_auth_email = false
		// 	this.auth_err = "",
		// 	this.auth_re = "",
		// 	this.auth_flg = false;
		// 	this.timeout_flg=false;
		// },
		// 1218 수정 최정훈 멘토님이말씀하신대로 기능 한개로 통합
		// 타이머
		timer1() {
			if (this.timerId) {
				clearInterval(this.timerId);
			}
			// 초기셋팅 분
			let minutes = 5;
			// 초기셋팅 초
			let seconds = 0;
			const updateTimer = () => {
				// 출력될 타이머의 모양
				this.timer = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
				// 시간종료시
				if (minutes === 0 && seconds === 0) {
					// 재전송플래그
					this.re_auth_email=true;
					// 시간종료플래그
					this.timeout_flg=true;
					// 타이머 종료
					clearInterval(this.timerId);
				// 시간종료 아닐시
				} else {
					// 초가 0이되면
					if (seconds === 0) {
						// 분-1
						minutes--;
						// 초59초 셋팅
						seconds = 59;
					} else {
						// 초 -1
						seconds--;
					}
				}
			};
			// 타이머 기능 1초마다 호출하여 출력
			this.timerId = setInterval(updateTimer, 1000);
		},
		// 타이머종료
		timerstop(){
			clearInterval(this.timerId);
		},

		// 왼쪽약관 클릭시
		inputLeft(){
		if(this.input_right&&this.input_left){
				this.input_all = true;
			}else if(!(this.input_left)){
				this.input_all=false;
			}
		},
		
		// 오른쪽약관 클릭시
		inputRight(){
			if(this.input_right&&this.input_left){
				this.input_all = true;
			}else if(!(this.input_right)){
				this.input_all=false;
			}else if(!(this.input_left)){
				this.input_all=false;
			}
		},
		// 전체동의 클릭시
		inputAll(){
			if(this.input_all){
				this.input_right = true;
				this.input_left = true;
			}else{
				if(!(this.input_right)){
					this.input_right = false;
				}else if(!(this.input_left)){
					this.input_left = false;
				}else{
					this.input_left = false;
					this.input_right = false;
				}
				this.re_auth_email =false;
				this.auth_err = '';
			}
		},

	},
	beforeRouteLeave(to, from, next) {
		this.$store.commit('setErrMsg','');
		this.timerstop();
		this.input_all = false;
		this.input_right = false;
		this.input_left = false;
		this.repeat_flg = false;
		next();
	},
			
		}
</script>