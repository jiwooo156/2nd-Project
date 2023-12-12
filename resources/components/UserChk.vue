<template>

	<div class="user_container">
		<div class="user_userInfo">		
			<div class="user_userInfo_text_center">
				<h1 class="user_h1">회원 정보</h1>
				
			</div>
		</div> 
	</div>
	<br>
	<div class="userChk_container">
		<div class="user_subcontainer">
			<div class="user_box_top_red_center">
				<h2>회원 정보</h2>
			</div>
		<div class="user_vacant_box"></div>
	</div>
	<br>
		<h4>본인확인을 위해 비밀번호를 입력해주세요</h4>
		<br>		
		<div>
			<span
				class="sign_errmsg"
				>{{ $store.state.varErr[0] }}</span>
				<br><br>
			<input type="password" placeholder="비밀번호" id="userchk_pw">
		</div>
		<br><br>
			<button
			@click="chk_pw"
			class="userChk_button"
			>확인</button>
		<button class="userChk_button"><router-link class="userChk_button" to="/main">취소</router-link></button>
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