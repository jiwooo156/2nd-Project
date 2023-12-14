<template>
	<div class="login_bg">
		<div class="login_frame center">
			<div  class="login_header" >
				<router-link :to="'/main'" class="login_header_a  pointer">이의이승</router-link>
			</div>
			<div class="login_container">
				<div>
					<div class="login_box">
						<input type="email" placeholder="이메일" id="login_email">
						<input type="password" placeholder="비밀번호" id="login_pw">
					</div>
					<div>
						<button class="login_btn pointer"
							@click="login"
						>로그인</button>
						<div class="login_and">또는</div>
						<button class="login_kakao pointer">kakao로 로그인</button>
						<div class="login_sign">
							<router-link :to="'/authemail'" class="pointer">회원가입</router-link>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'LoginComponent',
	data() {
		return {
			setting: '',
		}
	},

	created() {
		let boo = localStorage.getItem('nick') ?  true : false;
		this.$store.commit('setLocalFlg', boo);
	},

	methods: {
		login(){	
			this.$store.dispatch('actionLogin');
		}
	},
}
</script>