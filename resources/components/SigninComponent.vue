<template>
	<div class="sign_bg">
		<div class="sign_frame">
			<div  class="sign_header center" >
				<router-link :to="'/main'" class="sign_header_a  pointer">이의이승</router-link>
			</div>
			<div
				v-for="item in $store.state.varErr" :key="item" class="regist_err">{{ item[0] }}</div>
			<div>
				<div class="sign_container">
					<div class="sign_relative">
						<div>E-mail</div>
						<input type="email" placeholder="ㅁㅁㅁ@ㅁㅁㅁ.ㅁㅁ">
						<button class="sign_chk_btn pointer">중복확인</button>
					</div>
					<div>
						<div>비밀번호</div>
						<input type="password" placeholder="영어,숫자,!?~@# 8~20">
					</div>
					<div>
						<div>비밀번호확인</div>
						<input type="password" placeholder="비밀번호와 동일">
					</div>
					<div>
						<div>이름</div>
						<input type="text" placeholder="한글,영어 1~50">
					</div>
					<div class="sign_relative">
						<div>닉네임</div>
						<input type="text" placeholder="한글,영어,숫자 2~10">
						<button class="sign_chk_btn pointer">중복확인</button>
					</div>
					<div>
						<div>생년월일</div>
						<input type="text" placeholder="YYYYMMDD">
					</div>
					<div>
						<div>전화번호</div>
						<input type="text" placeholder="휴대폰번호">
					</div>
					<div>
						<div>성별</div>
						<select>
							<option>남자</option>
							<option>여자</option>
						</select>	
					</div>
					<div class="sign_footer_box center">
						<button class="sign_footer_btn pointer">회원가입</button>
						<router-link :to="'/main'" class="sign_footer_btn pointer">취소</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'SigninComponent',
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