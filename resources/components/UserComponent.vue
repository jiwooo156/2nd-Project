<template>
	<br>
<div class="user_black-bg" 
	v-if="$store.state.openPwModal"
>
	<div class="user_white-bg">
		<br>
		<label for="user_del_reason">변경하실 비밀번호 : </label>
		<span v-show="user_err_pw" class="sign_errmsg">비밀번호 형식이 올바르지 않습니다.</span>
		<span v-show="user_com_pw" class="sign_commsg">사용가능한 비밀번호 입니다.</span>
		<input type="password" placeholder="영어,숫자,특수문자(!?~@#)최소1개포함 8~20"  v-model="user_pw" id="user_pw" autocomplete='off' minlength="8" maxlength="20">
		<br>	
		<label for="user_del_reason">비밀번호 확인 : </label>
		<span v-show="user_err_pw_chk" class="sign_errmsg">비밀번호와 일치하지 않습니다.</span>
		<span v-show="user_com_pw_chk" class="sign_commsg">비밀번호와 일치합니다.</span>
		<input type="password" placeholder="비밀번호와 동일" v-model="user_pw_chk" id="user_pw_chk" autocomplete='off' minlength="8" maxlength="20">
		<br>
		<input type="text"
			v-if="delinput"
		>
		<br>
		<button class="userChk_button"
			@click="userpwchange"
		>변경하기</button>
		<button class="userChk_button" @click="ctlPasswordModal(false)">취소</button>
	</div>
</div>
<div class="user_black-bg" 
	v-if="$store.state.openNickModal"
>
	<div class="user_white-bg">
		<span
			v-if="$store.state.nickFlg === 1" 
			class="sign_commsg"
		>사용 가능한 닉네임 입니다.</span>
		<span
			v-if="$store.state.nickFlg === 2" 
			class="sign_errmsg"
		>이미 사용중인 닉네임 입니다.</span>
		<span
			v-for="item in $store.state.varErr" :key="item"
			v-if="$store.state.nickFlg === 0" 
			class="sign_errmsg"
		>{{ item[0] }}</span>
		<label for="user_del_reason">변경하실 닉네임 : </label>
			<input type="text" id="user_nick"  placeholder="한글,영어,숫자 2~8" >
			<br>
			<button class="userChk_button"
				v-if="$store.state.nickFlg !== 1" 
				@click="nick_chk"
			>중복확인</button>
			<button class="userChk_button"
				v-if="$store.state.nickFlg === 1" 
				@click="del_nick_chk"
			>다시쓰기</button>
		<br>
		<br>
		<button class="userChk_button"
			@click="usernickchange"
		>변경</button>
		<button class="userChk_button" @click="ctlNickModal(false)">취소</button>
	</div>
</div>
<div class="user_black-bg" 
	v-if="$store.state.openDelModal"
	>
	<div class="user_white-bg">
		<span>탈퇴하면 복구못함</span>
		<br>
		<label for="user_del_reason">탈퇴사유 : </label>
		<select name="reason" id="user_del_reason" v-model="delreason">
			<option>서비스 불만족</option>
			<option>원하는 정보가 없음</option>
			<option>불건전한 내용</option>
			<option>기타</option>
		</select>
		<br>
		<input type="text"
			id="user_del_reason_input"
			v-if="delinput"
			placeholder="직접입력 50자 내외"
		>
		<br>
		<button class="userChk_button"
			@click="userout"
		>탈퇴</button>
		<button class="userChk_button" @click="ctlDelModal(false)">취소</button>
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
					<td class="user_rowcontent">{{ $store.state.userInfo.id }}</td>
				</tr>
				
				<tr>					
					<td class="user_rowname">이메일</td>
					<td class="user_rowcontent">{{ $store.state.userInfo.email }}</td>					
				</tr>
				<tr>
					<td class="user_rowname">비밀번호</td>
					<td class="user_rowcontent">*********<button type="submit" class="user_button" @click="ctlPasswordModal(true)">변경</button></td>
				</tr>
				<tr>
					<td class="user_rowname">닉네임</td>
					<td class="user_rowcontent"
					>{{ $store.state.NowUser }}<button type="submit" class="user_button"  @click="ctlNickModal(true)">변경</button></td>
				</tr>
				<tr>
					<td class="user_rowname">탈퇴신청</td>
					<td class="user_rowcontent"><button type="submit" class="user_button_exit"  @click="ctlDelModal(true)">탈퇴</button></td>
				</tr>	
			</tbody>
		</table>
	</div>
</div>
</template>
<script>

export default {
	name: 'UserComponent',

	watch: {
		delreason(){
			this.del_val()
		},
		user_pw(){
			this.pwval()
		},
		user_pw_chk(){
			this.pwchkval()
		},
	},

	data() {
		return {
			user_pw: "",
			user_pw_chk: "",
			nick: "",
			user_err_pw: false,
			user_com_pw: false,
			user_err_pw_chk: false,
			user_com_pw_chk: false,
			delreason: '' ,
			delinput: false,
		}
	},

	created() {
		this.$store.dispatch('actionGetUser')
	},
	methods: {
		ctlPasswordModal(flg){
			this.$store.commit('setPasswordModalFlg',flg);
		},
		ctlNickModal(flg){
			this.$store.commit('setNickModalFlg',flg);
		},
		ctlDelModal(flg){
			this.$store.commit('setDelModalFlg',flg);
		},
		pw(){
			this.pwval()
		},
		pw_chk(){
			this.pwchkval()
		},
		del_val(){
			let reason = document.querySelector('#user_del_reason')
			console.log(reason.value)
			console.log("정상	")
			console.log(this.delinput)
			if(reason.value === "기타"){
				this.delinput = true
			}else{
				this.delinput = false
			}
		},
		pwval(){
			const VAR = /^(?=.*[a-zA-Z\d])(?=.*\d)(?=.*[~!@#?])[a-zA-Z\d~!@#?]{8,20}$/
			if(!VAR.test(this.user_pw)||!this.user_pw){
				this.user_err_pw = true;
				this.user_com_pw = false;
				return;
			}
			this.user_err_pw = false;
			this.user_com_pw = true;
		},
		pwchkval(){
			if(this.user_pw_chk !== this.user_pw||!this.user_pw){
				this.user_err_pw_chk = true;
				this.user_com_pw_chk = false;
				return
			}
			this.user_err_pw_chk = false;
			this.user_com_pw_chk = true;
		},
		userpwchange(){
			this.$store.dispatch('actionChangePw');
		},
		usernickchange(){
			this.$store.dispatch('actionChangeNick');
		},
		nick_chk(){
			this.$store.dispatch('actionNickChk2');
		},
		del_nick_chk(){
			this.$store.commit('setNickFlg',0);
			document.querySelector('#user_nick').readOnly = false;
			document.querySelector('#user_nick').removeAttribute('style')
		},
		userout(){
			this.$store.dispatch('actiondeluser');
		},
	},
	beforeRouteLeave(to, from, next) {
	this.$store.commit('setPasswordModalFlg',false)
	this.$store.commit('setNickModalFlg',false)
	this.$store.commit('setDelModalFlg',false)
	},
}
</script>