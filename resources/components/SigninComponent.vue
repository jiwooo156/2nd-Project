<template>
	<div class="sign_bg">
		<div class="sign_frame">
			<div  class="sign_header center" >
				<router-link :to="'/main'" class="sign_header_a  pointer">이의이승</router-link>
			</div>
			<div>
				<div class="sign_container">
					<div class="sign_relative">
						<div>E-mail</div>
						<input type="email" placeholder="ㅁㅁㅁ@ㅁㅁㅁ.ㅁㅁ" id="signin_email">
						<button class="sign_chk_btn pointer"
							@click="email_chk"
						>중복확인</button>
					</div>
					<div>
						<span>비밀번호</span>
						<span v-show="err_pw" class="sign_errmsg">비밀번호 형식이 올바르지 않습니다.</span>
						<span v-show="com_pw" class="sign_commsg">사용가능한 비밀번호 입니다.</span>
						<input type="password" placeholder="영어,숫자,특수문자(!?~@#)최소1개포함 8~20"  v-model="pw">
					</div>
					<div>
						<span>비밀번호확인</span>
						<span v-show="err_pw_chk" class="sign_errmsg">비밀번호와 일치하지 않습니다.</span>
						<span v-show="com_pw_chk" class="sign_commsg">비밀번호와 일치합니다.</span>
						<input type="password" placeholder="비밀번호와 동일" v-model="pw_chk">
					</div>
					<div>
						<span>이름</span>
						<span v-show="err_name" class="sign_errmsg">이름 형식이 올바르지 않습니다.</span>
						<span v-show="com_name" class="sign_commsg">사용가능한 이름 입니다.</span>
						<input type="text" placeholder="한글 2~10" v-model="name">
					</div>
					<div class="sign_relative">
						<div
							@click="nick_chk"
						>닉네임</div>
						<input type="text" placeholder="한글,영어,숫자 2~10">
						<button class="sign_chk_btn pointer">중복확인</button>
					</div>
					<div>
						<span>생년월일</span>
						<span v-show="err_birthdate" class="sign_errmsg">생년월일 형식이 올바르지 않습니다.</span>
						<span v-show="com_birthdate" class="sign_commsg">사용가능한 생년월일 입니다.</span>
						<input type="text" placeholder="YYYYMMDD"  v-model="birthdate">
					</div>
					<div>
						<span>전화번호</span>
						<span v-show="err_phone" class="sign_errmsg">전화번호 형식이 올바르지 않습니다.</span>
						<span v-show="com_phone" class="sign_commsg">사용가능한 전화번호 입니다.</span>
						<input type="text" placeholder="휴대폰번호" v-model="phone" max="11" min="11">
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
			pw: "",
			pw_chk: "",
			name: "",
			birthdate: "",
			phone: "",
			err_pw: false,
			com_pw: false,
			err_pw_chk: false,
			com_pw_chk: false,
			err_name: false,
			com_name: false,
			err_birthdate: false,
			com_birthdate: false,
			err_phone: false,
			com_phone: false,
		}
	},
	watch: {
		pw(){
			this.pwval()
		},
		pw_chk(){
			this.pwchkval()
		},
		name(){
			this.nameval()
		},
		birthdate(){
			this.birthdateval()
		},
		phone(){
			this.phoneval()
		},
	},
	created() {

	},

	mounted() {
	
	},

	methods: {
		pwval(){
			const VAR = /^(?=.*[a-zA-Z\d])(?=.*\d)(?=.*[~!@#?])[a-zA-Z\d~!@#?]{8,20}$/
			if(!VAR.test(this.pw)||!this.pw){
				this.err_pw = true;
				this.com_pw = false;
				return;
			}
			this.err_pw = false;
			this.com_pw = true;
		},
		pwchkval(){
			if(this.pw_chk !== this.pw||!this.pw_chk){
				this.err_pw_chk = true;
				this.com_pw_chk = false;
				return
			}
			this.err_pw_chk = false;
			this.com_pw_chk = true;
		},
		nameval(){
			const VAR = /^[가-힣]{2,10}$/
			if(!VAR.test(this.name)||!this.name){
				this.err_name = true;
				this.com_name = false;
				return
			}
			this.err_name = false;
			this.com_name = true;
		},
		birthdateval(){
			// 오늘날짜 yyyymmdd 형태로 가져오는법
			const today = new Date();
			const year = today.getFullYear();
			const month = (today.getMonth() + 1).toString().padStart(2, '0');
			const day = today.getDate().toString().padStart(2, '0');
			const formattedDate = year+month+day;
			const VAR = /^(19|20)\d{2}(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])$/
			if(!VAR.test(this.birthdate)||!this.birthdate||this.birthdate>=formattedDate){
				this.err_birthdate = true;
				this.com_birthdate = false;
				return
			}
			this.err_birthdate = false;
			this.com_birthdate = true;
		},
		phoneval(){
			const VAR = /^010([0-9]{4})([0-9]{4})$/
			if(!VAR.test(this.phone)||!this.phone){
				this.err_phone = true;
				this.com_phone = false;
				return
			}
			this.err_phone = false;
			this.com_phone = true;
		},
		email_chk(){
			this.$store.dispatch('actionEmailChk');
		},
		nick_chk(){
			this.$store.dispatch('actionNickChk');
		},
	}
}
</script>