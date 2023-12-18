<template>
	<br>
<div class="user_black-bg" 
	v-if="$store.state.openPwModal"
>
	<div class="user_white-bg">
		<div class="user_pwchange_box">
			<p>비밀번호는 <span class="user_pwchange_guide">영어,숫자,특수문자(!?~@#)최소1개포함 8~20</span>으로 등록하셔야 합니다.</p>
		</div>			
		<div class="user_box_password">
			<h3>비밀번호 수정</h3>
			<br>
			<label for="user_del_reason">변경하실 비밀번호 : </label>
			<input type="password" placeholder="영어,숫자,특수문자(!?~@#)최소1개포함 8~20"  v-model="user_pw" id="user_pw" autocomplete='off' minlength="8" maxlength="20"><br>
			<span v-show="user_err_pw1" class="sign_errmsg">8~20글자 사이로 작성해 주세요.</span>
			<span v-show="user_err_pw2" class="sign_errmsg">영어를 1글자 이상 작성해 주세요.</span>
			<span v-show="user_err_pw3" class="sign_errmsg">숫자를 1글자 이상 작성해 주세요.</span>
			<span v-show="user_err_pw4" class="sign_errmsg">특수문자(?~!@#)를 1글자 이상 작성해 주세요.</span>
			<span v-show="user_err_pw5" class="sign_errmsg">비밀번호 형식이 올바르지 않습니다.</span>
			<span v-show="user_com_pw" class="sign_commsg">사용가능한 비밀번호 입니다.</span>		
			<br>	
			<label for="user_del_reason">비밀번호 확인 : </label>
			<input type="password" placeholder="비밀번호와 동일" v-model="user_pw_chk" id="user_pw_chk" autocomplete='off' minlength="8" maxlength="20"><br>
			<span v-show="user_err_pw_chk" class="sign_errmsg">비밀번호와 일치하지 않습니다.</span>
			<span v-show="user_com_pw_chk" class="sign_commsg">비밀번호와 일치합니다.</span>
		</div>
			<br><br>			
			<div class="user_button_box_password">
				<button class="userChk_button_confirm"
					@click="userpwchange"
				>변경</button>
				<button class="userChk_button" @click="ctlPasswordModal(false)">취소</button>		
			</div>
	</div>	
</div>
<div class="user_black-bg" 
	v-if="$store.state.openNickModal"
>
	<div class="user_white-bg">		
		<div class="user_nickChange_box">
			<h3 class="user_h3_nick">닉네임 수정</h3>
			<div class="user_box_nick">
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
				<br>
				<label for="user_del_reason">변경하실 닉네임</label><br>
					<input type="text" id="user_nick" placeholder="한글,영어,숫자 2~8" v-model="nick">
					<button class="userChk_button"
						v-if="$store.state.nickFlg !== 1" 
						@click="nick_chk"
					>중복확인</button>
			</div>
			<br>		
			<button class="userChk_button"
				v-if="$store.state.nickFlg === 1" 
				@click="del_nick_chk"
			>다시쓰기</button>		
			<br><br>		
			
			<div class="user_button_box_nick">
				<button class="userChk_button_confirm"
					@click="usernickchange"
				>변경</button>
				<button class="userChk_button" @click="ctlNickModal(false)">취소</button>
			</div>
		</div>	
	</div>
</div>
<div class="user_black-bg" 
	v-if="$store.state.openDelModal"
	>
	<div class="user_white-bg">
		<div class="user_withdraw">
		<h3 class="user_h3_userout">회원 탈퇴</h3>
			<span class="user_warningText">탈퇴하시면 복구 안됩니다</span>
				<br><br>
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
					maxlength="50"
				>
			<br>
			<div class="user_button_box_userout">
				<button class="userChk_button_negative"
					@click="userout"
				>탈퇴</button>
				<button class="userChk_button" @click="ctlDelModal(false)">취소</button>
		</div>
		</div>
	</div>
</div>

<div class="user_container">
	<br>
	<div class="user_subcontainer">
		<div class="user_box_top_red_center">
			<h2 class="user_h2">회원 정보</h2>
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

	data() {
		return {
			user_pw: "",
			user_pw_chk: "",
			nick: "",
			user_err_pw1: false,
			user_err_pw2: false,
			user_err_pw3: false,
			user_err_pw4: false,
			user_err_pw5: false,
			user_com_pw: false,
			user_err_pw_chk: false,
			user_com_pw_chk: false,
			delreason: '' ,
			delinput: false,
		}
	},
	watch: {
		delreason(){
			this.del_val()
		},
		user_pw(){
			this.pwval();
			if(!(this.user_pw_chk==="")){
				this.pwchkval();
			}
		},
		user_pw_chk(){
			this.pwchkval()
		},
	},
	created() {
		this.GetUser()
	},
	methods: {
		// 닉네임체크
		nick_chk(){
				const URL = '/signin/nick?nick='+this.nick
				axios.get(URL)
				.then(res => {
					console.log("댄")
					this.$store.commit('setErrMsg','');
					console.log(res.data.errorMsg)
					if(res.data.code === "0"){
						if(res.data.data.length === 0){
							console.log("없을때")
							this.$store.commit('setNickFlg',1);
							document.querySelector('#user_nick').readOnly = true;
							document.querySelector('#user_nick').style.backgroundColor = 'rgb(169 183 200)';		
						}else if(res.data.data.length > 0){
							console.log("있을때")
							this.$store.commit('setNickFlg',2);
						}
					}else{
						alert("닉네임체크에 실패하였습니다")
					}
				})
				.catch(err => {
					this.$store.commit('setNickFlg',0);
					this.$store.commit('setErrMsg',err.response.data.errorMsg);
				})
		},
		// 유저정보불러오기
		GetUser(){
			const URL = '/userinfo'
			axios.get(URL)
			.then(res => {
				this.$store.commit('setUserInfo',res.data.data);
			})
			.catch(err => {
				alert("유저정보를 불러오는대 실패했습니다. \n다시시도해주세요")
			})
		},
		// 비밀번호변경
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
			console.log("정상")
			console.log(this.delinput)
			if(reason.value === "기타"){
				this.delinput = true
			}else{
				this.delinput = false
			}
		},
		pwval(){
			const VAR1 = /[a-zA-Z]/
			const VAR2 = /\d+/
			const VAR3 = /[?~!@#]+/;
			const VAR4 = /^.{8,20}$/;
			const VAR5 = /^(?=.*[a-zA-Z\d])(?=.*\d)(?=.*[~!@#?])[a-zA-Z\d~!@#?]{8,20}$/
			if(this.user_pw===""){
				this.user_err_pw1 = false;
				this.user_err_pw2 = false;
				this.user_err_pw3 = false;
				this.user_err_pw4 = false;
				this.user_err_pw5 = false;
				this.user_com_pw = false;
				return;
			}else if(!VAR4.test(this.user_pw)){
				this.user_err_pw1 = true;
				this.user_err_pw2 = false;
				this.user_err_pw3 = false;
				this.user_err_pw4 = false;
				this.user_err_pw5 = false;
				this.user_com_pw = false;
				return;
			}else if(!VAR1.test(this.user_pw)){
				this.user_err_pw1 = false;
				this.user_err_pw2 = true;
				this.user_err_pw3 = false;
				this.user_err_pw4 = false;
				this.user_err_pw5 = false;
				this.user_com_pw = false;
				return;
			}else if(!VAR2.test(this.user_pw)){
				this.user_err_pw1 = false;
				this.user_err_pw2 = false;
				this.user_err_pw3 = true;
				this.user_err_pw4 = false;
				this.user_err_pw5 = false;
				this.user_com_pw = false;
				return;
			}else if(!VAR3.test(this.user_pw)){
				this.user_err_pw1 = false;
				this.user_err_pw2 = false;
				this.user_err_pw3 = false;
				this.user_err_pw4 = true;
				this.user_err_pw5 = false;
				this.user_com_pw = false;
				return;
			}else if(!VAR5.test(this.user_pw)||!this.user_pw){
				this.user_err_pw1 = false;
				this.user_err_pw2 = false;
				this.user_err_pw3 = false;
				this.user_err_pw4 = false;
				this.user_err_pw5 = true;
				this.user_com_pw = false;
				return;
			}
			this.user_err_pw1 = false;
			this.user_err_pw2 = false;
			this.user_err_pw3 = false;
			this.user_err_pw4 = false;
			this.user_err_pw5 = false;
			this.user_com_pw = true;
		},
		pwchkval(){
			if(this.user_pw_chk===""){
				this.user_err_pw_chk = false;
				this.user_com_pw_chk = false;
				return
			}else if(this.user_pw_chk !== this.user_pw||!this.user_pw_chk){
				this.user_err_pw_chk = true;
				this.user_com_pw_chk = false;
				return
			}
			this.user_err_pw_chk = false;
			this.user_com_pw_chk = true;
		},
		userpwchange(){
			if(this.user_com_pw&&this.user_com_pw_chk){
				this.$store.dispatch('actionChangePw');
			}else{
				if(!(this.user_com_pw)){
					this.user_err_pw1 = true;
					this.user_err_pw2 = false;
					this.user_err_pw3 = false;
					this.user_err_pw4 = false;
					this.user_err_pw5 = false;
					this.user_com_pw = false;
				}
				if(!(this.user_com_pw_chk)){
					this.user_err_pw_chk = true;
					this.user_com_pw_chk = false;
				}
			}
		},
		usernickchange(){
			this.$store.dispatch('actionChangeNick');
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
		this.$store.commit('setUserFlg',false)
		this.$store.commit('setNickFlg',0)
		next();
	},
}
</script>