<template>
	<div class="login_bg">
		<div>
			<div>로그인</div>
			<div></div>
			<div>
				<div>
					<div>
						<div>E-mail</div>
						<input type="email">
					</div>
					<div>
						<div>비밀번호</div>
						<input type="password">
					</div>
					<button>로그인</button>
					<router-link :to="'/main'">취소</router-link>
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