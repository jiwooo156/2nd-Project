<template>
	<br>
	<div class="userChk_container">
		<div class="user_subcontainer">
			<div class="userchk_box_top_red_center">
				<h2 class="user_h2">회원 정보</h2>
			</div>
		<div class="userchk_vacant_box"></div>
	</div>
	<br>
		<h4 class="font_air bold">본인확인을 위해 비밀번호를 입력해주세요</h4>
		<br>		
		<div>
			<span
				class="sign_errmsg font_air bold"
				>{{ $store.state.varErr[0] }}</span>
				<br><br>
			<input type="password" placeholder="비밀번호" id="userchk_pw">
		</div>
		<br><br>
			<button
			@click="chk_pw"
			class="userChk_button font_air bold"
			>확인</button>
		<button class="userChk_button font_air bold"><router-link class="userChk_button font_air bold" to="/main">취소</router-link></button>
	</div>
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