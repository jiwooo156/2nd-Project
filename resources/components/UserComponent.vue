<template>
	<br>
	<div class="user_userInfo">
		
		<div class="user_userInfo_text">
			<h1>회원 정보</h1>
		</div>
	</div> 
	<br>
	<div class="user_subcontainer">
		<div class="user_box_top_red">
			<h2>회원 정보</h2>
		</div>
		<div class="user_vacant_box"></div>
	</div>
	<br>
<div class="user_container">
	<div class="user_userInfo_text3">
		<h3>회원정보 설정</h3>
	</div>
	<table class="user_table">
		<tbody>
			<tr>
				<td class="user_rowname">회원번호</td>
				<td class="user_rowcontent">1871017772</td>
			</tr>
			<tr>
				<td class="user_rowname">이메일</td>
				<td class="user_rowcontent">rlawldnd841@gmail.com <button type="submit" class="user_button">변경</button></td>
			</tr>
			<tr>
				<td class="user_rowname">비밀번호</td>
				<td class="user_rowcontent">********* <button type="submit" class="user_button">변경</button></td>
			</tr>
			<tr>
				<td class="user_rowname">닉네임</td>
				<td class="user_rowcontent">보성쿤 <button type="submit" class="user_button">변경</button></td>
			</tr>
			<tr>
				<td class="user_rowname">탈퇴신청</td>
				<td class="user_rowcontent"><button type="submit" class="user_button_exit">탈퇴</button></td>
			</tr>
		</tbody>
	</table>
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