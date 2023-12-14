<template>
<div class="sign_bg">
		<div class="sign_frame">
			<div  class="sign_header center" >
				<router-link :to="'/main'" class="sign_header_a  pointer">이의이승</router-link>
			</div>
			<div>
				<div class="sign_container">
					<div class="sign_relative">
						<span>E-mail 인증하기</span>
						<span
							v-if="$store.state.emailFlg === 1" 
							class="sign_commsg"
						>사용 가능한 이메일 입니다.</span>
						<span
							v-if="$store.state.emailFlg === 2" 
							class="sign_errmsg"
						>이미 사용중인 이메일 입니다.</span>
						<span
							v-for="item in $store.state.varErr" :key="item"
							v-if="$store.state.emailFlg !== 1" 
							class="sign_errmsg"
						>{{ item[0] }}</span>
						<input type="text" placeholder="사용하실 이메일을 입력해주세요" autocomplete='off' v-model="auth_email" id="auth_email">
						<button class="sign_chk_btn pointer"
							v-if="$store.state.emailFlg !== 1" 
							@click="emailChk"
						>중복확인</button>
						<button class="sign_chk_btn pointer"
							v-if="$store.state.emailFlg === 1" 
							@click="del_email_chk"
						>다시쓰기</button>
						<br>
						<div
							v-if="$store.state.emailFlg === 1&&this.auth_flg"
							class="sign_commsg"
						>이메일이 전송되었습니다.5분 이내로 이메일의 링크를 클릭해 주세요</div>
						<div
						v-if="$store.state.emailFlg === 1" 
						class="sign_errmsg"
						>{{this.auth_err}}</div>
						<div
						v-if="$store.state.emailFlg === 1" 
						class="sign_errmsg"
						>{{this.auth_re}}</div>
						<button
							v-if="$store.state.emailFlg === 1&&this.auth_flg"
							@click="reset_auth_time"
						>
							시간연장
						</button>
						<span
							v-if="$store.state.emailFlg === 1&&this.auth_flg"
						>
							남은시간 : {{  }}
						</span>
						<button class="pointer"
							v-if="$store.state.emailFlg === 1&&!(this.auth_flg)&&!(this.re_auth_email)"
							@click="email_auth"
						>인증메일 발송</button>
						<button class="pointer"
							v-if="$store.state.emailFlg === 1&&!(this.auth_flg)&&(this.re_auth_email)"
							@click="email_re_auth"
						>다시보내기</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'AuthComponent',
	props: {

	},
	
	components: {

	},

	data() {
		return {
			auth_email: "",
			auth_flg: false,
			re_auth_email: false,
			auth_err: "",
			auth_re: "",
			timer: "",
			min: "",
			sec: "",
		}
	},

	created() {

	},

	mounted() {

	},

	methods: {
		// 이메일인증
		email_auth(){
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
					console.log("성공")
					this.auth_flg = true;
				}else{
					console.log(res.data)
					this.auth_err = res.data.errorMsg;
					this.re_auth_email = true;
				}
			})
			.catch(err => {
				console.log("실패")
				console.log(err.data.errorMsg);
			})
		},
		// 이메일 다시보내기
		email_re_auth(){
			const URL = '/authemail/resend'
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
					this.auth_err = '';
					this.auth_flg = true;
				}else{
					this.auth_err = res.data.errorMsg;
				}
			})
			.catch(err => {
				router.push('/error');
			})
		},
		// 시간연장
		reset_auth_time(){
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
					console.log("성공")
				}else{
					console.log(res.data)
					console.log("엘스")
				}
			})
			.catch(err => {
				console.log("실패")
			})
		},
		// 이메일중복확인
		emailChk(){
			const URL = '/signin/email/?email='+this.auth_email
			axios.get(URL)
			.then(res => {
				this.$store.commit('setErrMsg','');
				if(res.data.code === "0"){
					if(res.data.data.length === 0){
						this.$store.commit('setEmailFlg',1);
						document.querySelector('#auth_email').readOnly = true;
						document.querySelector('#auth_email').style.backgroundColor = 'rgb(169 183 200)';		
					}else if(res.data.data.length > 0){
						console.log("있을때")
						this.$store.commit('setEmailFlg',2);
					}
				}else{
					console.log('else')
				}
			})
			.catch(err => {
				this.$store.commit('setEmailFlg',0);
				this.$store.commit('setErrMsg',err.response.data.errorMsg);
			})
		},
		// 이메일 중복확인 취소
		del_email_chk(){
			this.$store.commit('setEmailFlg',0);
			document.querySelector('#auth_email').readOnly = false;
			document.querySelector('#auth_email').removeAttribute('style');
			this.auth_err = "",
			this.auth_re = "",
			this.auth_flg = false;
		},
		// 타이머
		timer(){

		}
	},
	beforeRouteLeave(to, from, next) {
		this.del_email_chk();
		this.$store.commit('setErrMsg','');
		next();
	},
}
</script>