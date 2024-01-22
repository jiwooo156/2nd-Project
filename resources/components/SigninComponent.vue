<template>
	<div class="sign_bg">
		<div class="sign_frame">
			<div  class="sign_header center" >
				<router-link :to="'/main'" class="sign_header_a  pointer"><img src="/img/logo.png" alt="" class="login_logo"></router-link>
			</div>
			<div>
				<div class="sign_container">
					<div class="sign_relative">
						<span>E-mail</span>
						<input type="text" id="signin_email" autocomplete="off" readonly :value="email" class="sign_email_input">
					</div>
					<div>
						<span>비밀번호</span>
						<span v-show="err_pw1" class="sign_errmsg">8~20글자 사이로 작성해 주세요.</span>
						<span v-show="err_pw2" class="sign_errmsg">영어를 1글자 이상 작성해 주세요.</span>
						<span v-show="err_pw3" class="sign_errmsg">숫자를 1글자 이상 작성해 주세요.</span>
						<span v-show="err_pw4" class="sign_errmsg">특수문자(?~!@#)를 1글자 이상 작성해 주세요.</span>
						<span v-show="err_pw5" class="sign_errmsg">비밀번호 형식이 올바르지 않습니다.</span>
						<span v-show="err_pw6" class="sign_errmsg">비밀번호를 확인해 주세요.</span>
						<span v-show="com_pw" class="sign_commsg">사용 가능한 비밀번호입니다.</span>
						<input type="password" placeholder="영어, 숫자, 특수문자(!?~@#) 최소 1개 포함 8~20"  v-model="pw" id="signin_pw" autocomplete='off' minlength="8" maxlength="20">
					</div>
					<div>
						<span>비밀번호 확인</span>
						<span v-show="err_pw_chk" class="sign_errmsg">비밀번호와 일치하지 않습니다.</span>
						<span v-show="err_pw_chk1" class="sign_errmsg">비밀번호확인을 확인해 주세요.</span>
						<span v-show="com_pw_chk" class="sign_commsg">비밀번호와 일치합니다.</span>
						<input type="password" placeholder="비밀번호와 동일" v-model="pw_chk" id="signin_pw_chk" autocomplete='off' minlength="8" maxlength="20">
					</div>
					<div>
						<span>이름</span>
						<span v-show="err_name1" class="sign_errmsg">2 ~ 10글자 사이로 작성해 주세요.</span>
						<span v-show="err_name2" class="sign_errmsg">한국어만 사용 가능합니다.</span>
						<span v-show="err_name3" class="sign_errmsg">이름 형식이 올바르지 않습니다.</span>
						<span v-show="err_name4" class="sign_errmsg">이름을 확인해주세요.</span>
						<span v-show="com_name" class="sign_commsg">사용 가능한 이름입니다.</span>
						<input type="text" placeholder="한글 2~10" v-model="name" id="signin_name" autocomplete='off' minlength="2" maxlength="10"
							@input="koreaname"
						>
					</div>
					<div>
						<span>닉네임</span>
						<span v-show="err_nick1" v-if="!(this.com_nick)" class="sign_errmsg">닉네임은 2~8자리로 작성해 주세요.</span>
						<span v-show="err_nick2" v-if="!(this.com_nick)" class="sign_errmsg">영어,숫자,한글(자음+모음)만 사용 가능합니다.</span>
						<span v-show="err_nick3" v-if="!(this.com_nick)" class="sign_errmsg">닉네임 형식이 올바르지 않습니다.</span>
						<span v-show="err_nick4" v-if="!(this.com_nick)" class="sign_errmsg">닉네임을 확인해 주세요.</span>
						<span
							v-if="$store.state.nickFlg === 1&&this.com_nick" 
							class="sign_commsg"
						>사용 가능한 닉네임 입니다.</span>
						<span
							v-if="$store.state.nickFlg === 2&&this.com_nick" 
							class="sign_errmsg"
						>이미 사용중인 닉네임 입니다.</span>
						<span
							v-for="item in $store.state.varErr" :key="item"
							v-if="this.com_nick"
							class="sign_errmsg"
						>{{ item[0] }}</span>
						<div class="sign_relative">
							<input type="text" placeholder="한글, 영어, 숫자 2~8" id="signin_nick"  autocomplete='off' minlength="2" maxlength="8"
								v-model="nick"
								@input="koreanick"
							>
						</div>
					</div>
					<div>
						<span>생년월일</span>
						<span v-show="err_birthdate1" class="sign_errmsg">-를 제외한 값을 입력해 주세요.</span>
						<span v-show="err_birthdate2" class="sign_errmsg">생년월일을 8자리로 작성해 주세요.</span>
						<span v-show="err_birthdate3" class="sign_errmsg">생년월일 형식이 올바르지 않습니다.</span>
						<span v-show="err_birthdate4" class="sign_errmsg">생년월일을 확인해 주세요.</span>
						<span v-show="com_birthdate" class="sign_commsg">사용 가능한 생년월일입니다.</span>
						<input type="text" placeholder="YYYYMMDD"  v-model="birthdate" id="signin_birthdate" autocomplete='off' minlength="8" maxlength="8">
					</div>
					<div>
						<span>전화번호</span>
						<span v-show="err_phone1" class="sign_errmsg">-를 제외한 값을 입력해 주세요.</span>
						<span v-show="err_phone2" class="sign_errmsg">휴대폰번호는 11자리로 작성해 주세요.</span>
						<span v-show="err_phone3" class="sign_errmsg">전화번호 형식이 올바르지 않습니다.</span>
						<span v-show="err_phone4" class="sign_errmsg">전화번호를 확인해 주세요.</span>
						<span v-show="com_phone" class="sign_commsg">사용 가능한 전화번호입니다.</span>
						<input type="text" placeholder="휴대폰번호" v-model="phone" id="signin_phone"  autocomplete='off' minlength="11" maxlength="11">
					</div>
					<div>
						<span>성별</span>
						<select id="signin_gender" placeholder="지역">
							<option class="signin_gen">남자</option>
							<option class="signin_gen">여자</option>
						</select>	
					</div>
					<div class="sign_footer_box center">
						<button class="sign_footer_btn pointer"
							@click="signin"
						>회원가입</button>
						<!-- <button class="sign_footer_btn pointer"
							v-if="!nickChkFlg"
							@click="signin"
						>회원가입</button> -->
						<router-link :to="'/main'" class="sign_footer_btn pointer">취소</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import VueCookies from "vue-cookies";
import Swal from 'sweetalert2';

export default {
	name: 'SigninComponent',

	data() {
		return {
			email: "",
			pw: "",
			pw_chk: "",
			name: "",
			nick: "",
			birthdate: "",
			phone: "",
			err_pw1: false,
			err_pw2: false,
			err_pw3: false,
			err_pw4: false,
			err_pw5: false,
			err_pw6: false,
			com_pw: false,
			err_pw_chk: false,
			com_pw_chk: false,
			err_name1: false,
			err_name2: false,
			err_name3: false,
			err_name4: false,
			com_name: false,
			err_nick1: false,
			err_nick2: false,
			err_nick3: false,
			err_nick4: false,
			com_nick: false,
			err_birthdate1: false,
			err_birthdate2: false,
			err_birthdate3: false,
			err_birthdate4: false,
			com_birthdate: false,
			err_phone1: false,
			err_phone2: false,
			err_phone3: false,
			err_phone4: false,
			com_phone: false,
			nickChkFlg: false,
		}
	},
	watch: {
		pw(){
			this.pwval();
			if(!(this.pw_chk==="")){
				this.pwchkval();
			}
		},
		pw_chk(){
			this.pwchkval();
		},
		name(){
			this.nameval();
		},
		nick(){
			this.nickChkFlg = false
			this.nickval();
		},
		birthdate(){
			this.birthdateval();
		},
		phone(){
			this.phoneval();
		},
	},
	created() {
		// 로컬스토리지에 저장된 정보있는지 확인
		this.email= "";
		this.$store.commit('setErrMsg',[]);
		this.$store.commit('setNickFlg',0);	
		this.emailGet();
	},

	methods: {
		// 이메일정보 가져오기
		emailGet(){
		const URL = '/signin/start';
		axios.get(URL)
		.then(res => {
			this.$store.commit('setErrMsg','');
			if(res.data.code === "0"){
				this.email = res.data.data.email;
			}else{
				console.log('else');
			}
		})
		.catch(err => {
			this.$store.commit('setErrMsg',err.response.data.errorMsg);
		})
		},
		pwval(){
			const VAR1 = /[a-zA-Z]/;
			const VAR2 = /\d+/;
			const VAR3 = /[?~!@#]+/;
			const VAR4 = /^.{8,20}$/;
			const VAR5 = /^(?=.*[a-zA-Z\d])(?=.*\d)(?=.*[~!@#?])[a-zA-Z\d~!@#?]{8,20}$/;
			if(this.pw===""){
				this.err_pw1 = false;
				this.err_pw2 = false;
				this.err_pw3 = false;
				this.err_pw4 = false;
				this.err_pw5 = false;
				this.err_pw6 = false;
				this.com_pw = false;
				return;
			}else if(!VAR4.test(this.pw)){
				this.err_pw1 = true;
				this.err_pw2 = false;
				this.err_pw3 = false;
				this.err_pw4 = false;
				this.err_pw5 = false;
				this.err_pw6 = false;
				this.com_pw = false;
				return;
			}else if(!VAR1.test(this.pw)){
				this.err_pw1 = false;
				this.err_pw2 = true;
				this.err_pw3 = false;
				this.err_pw4 = false;
				this.err_pw5 = false;
				this.err_pw6 = false;
				this.com_pw = false;
				return;
			}else if(!VAR2.test(this.pw)){
				this.err_pw1 = false;
				this.err_pw2 = false;
				this.err_pw3 = true;
				this.err_pw4 = false;
				this.err_pw5 = false;
				this.err_pw6 = false;
				this.com_pw = false;
				return;
			}else if(!VAR3.test(this.pw)){
				this.err_pw1 = false;
				this.err_pw2 = false;
				this.err_pw3 = false;
				this.err_pw4 = true;
				this.err_pw5 = false;
				this.err_pw6 = false;
				this.com_pw = false;
				return;
			}else if(!VAR5.test(this.pw)||!this.pw){
				this.err_pw1 = false;
				this.err_pw2 = false;
				this.err_pw3 = false;
				this.err_pw4 = false;
				this.err_pw5 = true;
				this.err_pw6 = false;
				this.com_pw = false;
				return;
			}
			this.err_pw1 = false;
			this.err_pw2 = false;
			this.err_pw3 = false;
			this.err_pw4 = false;
			this.err_pw5 = false;
			this.err_pw6 = false;
			this.com_pw = true;
		},
		pwchkval(){
			if(this.pw_chk===""){
				this.err_pw_chk = false;
				this.err_pw_chk1 = false;
				this.com_pw_chk = false;
				return;
			}else if(this.pw_chk !== this.pw||!this.pw_chk){
				this.err_pw_chk = true;
				this.err_pw_chk1 = false;
				this.com_pw_chk = false;
				return;
			}
			this.err_pw_chk = false;
			this.err_pw_chk1 = false;
			this.com_pw_chk = true;
		},
		nameval(){
			const VAR = /^.{2,10}$/;
			const VAR1 = /^[가-힣]+$/;
			const VAR2 = /^[가-힣]{2,10}$/;
			if(this.name===""){
				this.err_name1 = false;
				this.err_name2 = false;
				this.err_name3 = false;
				this.err_name4 = false;
				this.com_name = false;
				return;
			}else if(!VAR.test(this.name)){
				this.err_name1 = true;
				this.err_name2 = false;
				this.err_name3 = false;
				this.err_name4 = false;
				this.com_name = false;
				return;
			}else if(!VAR1.test(this.name)){
				this.err_name1 = false;
				this.err_name2 = true;
				this.err_name3 = false;
				this.err_name4 = false;
				this.com_name = false;
				return;
			}else if(!VAR2.test(this.name)||!this.name){
				this.err_name1 = false;
				this.err_name2 = false;
				this.err_name3 = true;
				this.err_name4 = false;
				this.com_name = false;
				return;
			}
			this.err_name1 = false;
			this.err_name2 = false;
			this.err_name3 = false;
			this.err_name4 = false;
			this.com_name = true;
		},
		birthdateval(){
			// 오늘날짜 yyyymmdd 형태로 가져오는법
			const today = new Date();
			const year = today.getFullYear();
			const month = (today.getMonth() + 1).toString().padStart(2, '0');
			const day = today.getDate().toString().padStart(2, '0');
			const formattedDate = year+month+day;
			const VAR = /^[^-]+$/;
			const VAR1 = /^.{8}$/;
			const VAR2 = /^(19|20)\d{2}(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])$/;
			if(this.birthdate===""){
				this.err_birthdate1 = false;
				this.err_birthdate2 = false;
				this.err_birthdate3 = false;
				this.err_birthdate4 = false;
				this.com_birthdate = false;
				return;
			}else if(!VAR.test(this.birthdate)){
				this.err_birthdate1 = true;
				this.err_birthdate2 = false;
				this.err_birthdate3 = false;
				this.err_birthdate4 = false;
				this.com_birthdate = false;
				return;
			}else if(!VAR1.test(this.birthdate)){
				this.err_birthdate1 = false;
				this.err_birthdate2 = true;
				this.err_birthdate3 = false;
				this.err_birthdate4 = false;
				this.com_birthdate = false;
				return;
			}else if(!VAR2.test(this.birthdate)||!this.birthdate||this.birthdate>=formattedDate){
				this.err_birthdate1 = false;
				this.err_birthdate2 = false;
				this.err_birthdate3 = true;
				this.err_birthdate4 = false;
				this.com_birthdate = false;
				return;
			}
			this.err_birthdate1 = false;
			this.err_birthdate2 = false;
			this.err_birthdate3 = false;
			this.err_birthdate4 = false;
			this.com_birthdate = true;
		},
		phoneval(){
			const VAR = /^[^-]+$/;
			const VAR1 = /^.{11}$/;
			const VAR2 = /^010([0-9]{4})([0-9]{4})$/;
			if(this.phone===""){
				this.err_phone1 = false;
				this.err_phone2 = false;
				this.err_phone3 = false;
				this.err_phone4 = false;
				this.com_phone = false;
				return;
			}else if(!VAR.test(this.phone)){
				this.err_phone1 = true;
				this.err_phone2 = false;
				this.err_phone3 = false;
				this.err_phone4 = false;
				this.com_phone = false;
				return;
			}else if(!VAR1.test(this.phone)){
				this.err_phone1 = false;
				this.err_phone2 = true;
				this.err_phone3 = false;
				this.err_phone4 = false;
				this.com_phone = false;
				return;
			}else if(!VAR2.test(this.phone)){
				this.err_phone1 = false;
				this.err_phone2 = false;
				this.err_phone3 = true;
				this.err_phone4 = false;
				this.com_phone = false;
				return;
			}
			this.err_phone1 = false;
			this.err_phone2 = false;
			this.err_phone3 = false;
			this.err_phone4 = false;
			this.com_phone = true;
		},
		nickval(){
			const VAR = /^.{2,8}$/;
			const VAR1 = /^[가-힣a-zA-Z0-9]+$/;
			const VAR2 = /^[가-힣a-zA-Z0-9]{2,8}$/;
			if(this.nick===""){
				this.err_nick1 = false;
				this.err_nick2 = false;
				this.err_nick3 = false;
				this.err_nick4 = false;
				this.com_nick = false;
				return;
			}else if(!VAR.test(this.nick)){
				this.err_nick1 = true;
				this.err_nick2 = false;
				this.err_nick3 = false;
				this.err_nick4 = false;
				this.com_nick = false;
				return;
			}else if(!VAR1.test(this.nick)){
				this.err_nick1 = false;
				this.err_nick2 = true;
				this.err_nick3 = false;
				this.err_nick4 = false;
				this.com_nick = false;
				return;
			}else if(!VAR2.test(this.nick)||!this.nick){
				this.err_nick1 = false;
				this.err_nick2 = false;
				this.err_nick3 = true;
				this.err_nick4 = false;
				this.com_nick = false;
				return;
			}
			this.err_nick1 = false;
			this.err_nick2 = false;
			this.err_nick3 = false;
			this.err_nick4 = false;
			this.com_nick = true;
			this.nick_chk();
		},
		signin(){
			if(this.com_pw&&this.com_pw_chk&&this.com_name&&this.com_birthdate&&this.com_phone&&this.$store.state.nickFlg===1&&this.nickChkFlg){
				this.$store.dispatch('actionSignIn');
			}else{
				if(!this.com_pw){
					this.err_pw1 = false;
					this.err_pw2 = false;
					this.err_pw3 = false;
					this.err_pw4 = false;
					this.err_pw5 = false;
					this.err_pw6 = true;
					this.com_pw = false;
				}
				if(!this.com_pw_chk){
					this.err_pw_chk = false;
					this.err_pw_chk1 = true;
					this.com_pw_chk = false;
				}
				if(!this.com_name){
					this.err_name1 = false;
					this.err_name2 = false;
					this.err_name3 = false;
					this.err_name4 = true;
					this.com_name = false;
				}
				if(!this.com_birthdate){
					this.err_birthdate1 = false;
					this.err_birthdate2 = false;
					this.err_birthdate3 = false;
					this.err_birthdate4 = true;
					this.com_birthdate = false;
				}
				if(!this.com_phone){
					this.err_phone1 = false;
					this.err_phone2 = false;
					this.err_phone3 = false;
					this.err_phone4 = true;
					this.com_phone = false;
				}
				if(!this.com_nick){
					this.err_nick1 = false;
					this.err_nick2 = false;
					this.err_nick3 = false;
					this.err_nick4 = true;
					this.com_nick = false;
					this.nick_chk();
				}
			}
		},
		// 닉네임 한글 바로인식
		koreanick(e) {
			this.nick = e.target.value;
		},
		// 이름 한글 바로인식
		koreaname(e) {
			this.name = e.target.value;
		},
		// 닉네임 체크
		nick_chk() {
			clearTimeout(this.debounceTimeoutId);
			this.debounceTimeoutId = setTimeout(() => {
				const URL = '/signin/nick?nick=' + this.nick;
				axios.get(URL)
					.then(res => {
						this.$store.commit('setErrMsg', '');
						if (res.data.code === "0") {
							if (res.data.data.length === 0) {
								this.nickChkFlg = true;
								this.$store.commit('setNickFlg', 1);
							} else if (res.data.data.length > 0) {
								this.$store.commit('setNickFlg', 2);
							}
						} else {
							this.nickChkFlg = false;
							Swal.fire({
							icon: 'error',
							title: 'Error',
							text: '닉네임체크에 실패하였습니다',
							confirmButtonText: '확인'
                })
						}
					})
					.catch(err => {
						this.$store.commit('setNickFlg', 0);
						this.$store.commit('setErrMsg', err.response.data.errorMsg);
					});
			}, 200);
		},
	},
	beforeRouteLeave(to, from, next) {
		this.$store.commit('setErrMsg','');
		this.$store.commit('setNickFlg',0);
		VueCookies.remove('auth_id');
		next();
	},
}
</script>