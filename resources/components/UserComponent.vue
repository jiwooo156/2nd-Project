<template>
	<br>
<div class="user_black-bg" v-if="openModal">
	<div class="user_white-bg">
		<span>새로운 닉네임을 입력해주세요</span>
		<br>
		<input type="text">
		<button class="user_button">변경</button>
		<button class="user_button" @click="modalClose()">닫기</button>
	</div>
</div>

<div class="user_container">
	<div class="user_userInfo">		
		<div class="user_userInfo_text_center">
			<h1 class="user_h1">회원 정보</h1>
		</div>
	</div> 
	<br>
	<div class="user_subcontainer">
		<div class="user_box_top_red_center">
			<h2>회원 정보</h2>
		</div>
		<div class="user_vacant_box"></div>
	</div>
	<br>
	<div class="user_infocontainer">
		<div class="user_userInfo_text3">
			<h3>회원정보 설정</h3>
		</div>
		<table class="user_table">
			<tbody>
				<tr>
					<td class="user_rowname">회원번호</td>
					<td class="user_rowcontent"></td>
				</tr>
				
				<tr>					
					<td class="user_rowname">이메일</td>
					<td class="user_rowcontent">rlawldnd841@gmail.com</td>					
				</tr>
				<tr>
					<td class="user_rowname">비밀번호</td>
					<td class="user_rowcontent">*********<button type="submit" class="user_button" @click="openClick()">변경</button></td>
				</tr>
				<tr>
					<td class="user_rowname">닉네임</td>
					<td class="user_rowcontent">보성쿤<button type="submit" class="user_button">변경</button></td>
				</tr>
				<tr>
					<td class="user_rowname">탈퇴신청</td>
					<td class="user_rowcontent"><button type="submit" class="user_button_exit">탈퇴</button></td>
				</tr>	
			</tbody>
		</table>
	</div>
</div>
</template>
<script>

export default {
	name: 'UserComponent',
	props: {
	},

	components: {

	},

	data() {
		return {
			openModal: false,
		}
	},

	created() {
		console.log("유저시작")
		this.$store.dispatch('actionGetUser')
	},

	mounted() {

	},

	methods: {
		openClick(){
			this.openModal = true;
		},
		modalClose(){
			this.openModal = false;
		},
	},
}
</script>