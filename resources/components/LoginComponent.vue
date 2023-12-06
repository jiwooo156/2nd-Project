<template>
	<div class="login_frame">
		<div class="login_header">이의이승</div>
		<div class="login_container">
			<div>
				<div class="login_box">
					<input type="email" placeholder="이메일">
					<input type="password" placeholder="비밀번호">
				</div>
					<button class="login_btn">로그인</button>
					<div class="login_and">또는</div>
					<button class="login_kakao">카카오로 로그인</button>
					<router-link :to="'/signin'" class="login_sign">회원가입</router-link>
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