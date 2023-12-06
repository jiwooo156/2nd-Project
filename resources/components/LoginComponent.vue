<template>
	<div class="login_bg">
		<div class="login_frame center">
			<div  class="login_header" >
				<router-link :to="'/main'" class="login_header_a  pointer">이의이승</router-link>
			</div>
			<div class="login_container">
				<div>
					<div class="login_box">
						<input type="email" placeholder="이메일">
						<input type="password" placeholder="비밀번호">
					</div>
					<div>
						<button class="login_btn pointer">로그인</button>
						<div class="login_and">또는</div>
						<button class="login_kakao pointer">kakao로 로그인</button>
						<div class="login_sign">
							<router-link :to="'/signin'" class="pointer">회원가입</router-link>
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
	props: {

	},
	
	components: {

	},

	data() {
		return {
			setting: '',
		}
	},

	created() {

	},

	mounted() {

	},

	methods: {

	}
}
</script>