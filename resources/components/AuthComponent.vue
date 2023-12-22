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
					class="sign_commsg font_air bold"
				> {{ auth_email }} 로<br>
				이메일이 전송되었습니다.</div>
				<div
					v-if="email_flg&&auth_flg&&!(timeout_flg)&&!(repeat_flg)"
					class="sign_commsg font_air bold"
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
		input_all(){
			this.inputAll();
			this.inputRight();
			this.inputLeft();
		},
		input_left(){
			this.inputLeft();
		},
		input_right(){
			this.inputRight();
		}
	},
	created() {
		this.$store.commit('setLoading',true)
		console.log('크리에이티드')
	},

	mounted() {
		this.$store.commit('setLoading',false)
		console.log('마운티드')
	},

	methods: {
		// 이메일인증보내기
		email_auth(){
			this.$store.commit('setLoading',true)
			const URL = '/authemail'
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
					console.log(this.email_flg = true)
					this.timer1();			
					this.$store.commit('setLoading',false)
				}else if(res.data.code === "E12"){
					console.log("엘스")
					this.errorMsg = []
					this.auth_err = res.data.errorMsg;
					this.timeout_flg = false;
					this.re_auth_email = true;
					this.$store.commit('setLoading',false)
				}else if(res.data.code === "E13"){
					console.log("엘스")
					this.auth_err = ""
					this.timeout_flg = false;
					this.errorMsg = []
					this.repeat_flg = true
					this.$store.commit('setLoading',false)
				}
			})
			.catch(err => {
				console.log("캐치")
				this.auth_err="";
				this.errorMsg=err.response.data.errorMsg
				this.$store.commit('setLoading',false)
			})
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
		// 시간연장
		reset_auth_time(){
			this.$store.commit('setLoading',true)
			const URL = '/authemail/time'
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
					this.timer1();
					this.$store.commit('setLoading',false)
				}else{
					console.log(res.data)
					console.log("엘스")
					this.$store.commit('setLoading',false)
				}
			})
			.catch(err => {
				console.log("실패")
				this.$store.commit('setLoading',false)
			})
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
			let minutes = 5;
			let seconds = 0;
			const updateTimer = () => {
				this.timer = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
				if (minutes === 0 && seconds === 0) {
					// this.auth_flg=false;
					this.re_auth_email=true;
					this.timeout_flg=true;
					clearInterval(this.timerId);
				} else {
					if (seconds === 0) {
						minutes--;
						seconds = 59;
					} else {
						seconds--;
					}
				}
			};
			this.timerId = setInterval(updateTimer, 1000);
		},
		timerstop(){
			clearInterval(this.timerId);
		},
		inputLeft(){
		if(this.input_right&&this.input_left){
				this.input_all = true
			}else if(!(this.input_left)){
				this.input_all=false
			}
		},
		inputRight(){
			if(this.input_right&&this.input_left){
				this.input_all = true
			}else if(!(this.input_right)){
				this.input_all=false
			}else if(!(this.input_left)){
				this.input_all=false
			}
		},
		inputAll(){
			if(this.input_all){
				this.input_right = true
				this.input_left = true
			}else{
				if(!(this.input_right)){
					this.input_right = false
				}else if(!(this.input_left)){
					this.input_left = false
				}else{
					this.input_left = false
					this.input_right = false
				}
				this.re_auth_email =false
				this.auth_err = '';
			}
		},

	},
	beforeRouteLeave(to, from, next) {
		this.$store.commit('setErrMsg','');
		this.timerstop();
		this.input_all = false
		this.input_right = false
		this.input_left = false
		this.repeat_flg = false
		next();
	},
			
		}
</script>