<template>
	<span
		class="sign_errmsg"
	>{{ $store.state.varErr[0] }}</span>
	<input type="password" placeholder="비밀번호" id="userchk_pw">
	<button
		@click="chk_pw"
	>확인</button>
	<router-link to="/main">취소</router-link>
</template>
<script>
export default {
	name: 'UserChk',

	created() {

	},

	methods: {
		chk_pw(){	
			this.$store.dispatch('actionUserChk');
		}
	}
}
</script>