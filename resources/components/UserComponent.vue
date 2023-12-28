<template>
	<br>
<div class="user_black-bg" 
	v-if="$store.state.openPwModal"
>
	<div class="user_white-bg">
		<h3 class="font_air bold center user_pwchange_box_header">비밀번호 수정</h3>
	
		<div class="user_pwchange_box">
			<p class="font_air bold">비밀번호는 <span class="user_pwchange_guide font_air bold">영어,숫자,특수문자(!?~@#)최소1개포함 8~20</span>으로 등록하셔야 합니다.</p>
		</div>			
		<div class="user_box_password">
			<br>
			<div>
				<label for="user_del_reason" class=" font_air bold">비밀번호</label>
				<span v-show="user_err_pw1" class="user_errmsg font_air bold">8~20글자 사이로 작성해 주세요.</span>
				<span v-show="user_err_pw2" class="user_errmsg font_air bold">영어를 1글자 이상 작성해 주세요.</span>
				<span v-show="user_err_pw3" class="user_errmsg font_air bold">숫자를 1글자 이상 작성해 주세요.</span>
				<span v-show="user_err_pw4" class="user_errmsg font_air bold">특수문자(?~!@#)를 사용해 주세요.</span>
				<span v-show="user_err_pw5" class="user_errmsg font_air bold">비밀번호 형식이 올바르지 않습니다.</span>
				<span v-show="user_com_pw" class="user_commsg font_air bold">사용가능한 비밀번호입니다.</span>		
			</div>
			<input type="password" placeholder="영어, 숫자, 특수문자(!?~@#) 최소 1개 포함 8~20"  v-model="user_pw" id="user_pw" autocomplete='off' minlength="8" maxlength="20" class="font_air bold user_pwchange_input"><br>
			<br>	
			<div>
				<label for="user_del_reason" class="font_air bold">비밀번호 확인</label>		
				<span v-show="user_err_pw_chk" class="user_errmsg font_air bold">비밀번호와 일치하지 않습니다.</span>
				<span v-show="user_com_pw_chk" class="user_commsg font_air bold">비밀번호와 일치합니다.</span>
			</div>
			<input type="password" placeholder="비밀번호와 동일" v-model="user_pw_chk" id="user_pw_chk" autocomplete='off' minlength="8" maxlength="20" class="font_air bold font_air bold user_pwchange_input"><br>
		</div>
			<br><br>			
			<div class="user_button_box_password">
				<button class="userChk_button_confirm font_air bold"
					@click="userpwchange"
				>변경</button>
				<button class="userChk_button font_air bold" @click="ctlPasswordModal(false)">취소</button>		
			</div>
	</div>	
</div>
<div class="user_black-bg" 
	v-if="$store.state.openNickModal"
>
	<div class="user_white-bg">		
		<div class="user_nickChange_box">
			<div class="user_h3_nick">
				<h3 class="font_air bold">닉네임 수정</h3>
			</div>
			<div class="user_pwchange_box">
				<p class="font_air bold">닉네임은 <span class="user_pwchange_guide font_air bold">영어, 숫자, 한글로 이루어진 2~8</span>으로 등록하셔야 합니다.</p>
			</div>			
			<div class="user_box_nick">
				<br>
				<div>
					<label for="user_del_reason" class=" font_air bold">변경하실 닉네임</label>
					<span v-show="err_nick1" v-if="!(this.com_nick)" class="user_errmsg font_air bold">2~8글자 사이로 작성해 주세요.</span>
					<span v-show="err_nick2" v-if="!(this.com_nick)" class="user_errmsg font_air bold">영어, 숫자, 한글만 사용 가능합니다.</span>
					<span v-show="err_nick3" v-if="!(this.com_nick)" class="user_errmsg font_air bold">닉네임 형식이 올바르지 않습니다.</span>
					<span
						v-if="$store.state.nickFlg === 1&&this.com_nick" 
						class="user_commsg font_air bold"
					>사용 가능한 닉네임입니다.</span>
					<span
						v-if="$store.state.nickFlg === 2&&this.com_nick" 
						class="user_errmsg font_air bold"
					>이미 사용중인 닉네임입니다.</span>
					<span
						v-for="item in $store.state.varErr" :key="item"
						v-if="this.com_nick"
						class="user_errmsg font_air bold"
					>{{ item[0] }}</span>
				</div>
				<input type="text" id="user_nick" placeholder="한글, 영어, 숫자 2~8"
					class="font_air bold" 
					v-model="nick"
					@input="koreanick"
				>
			</div>
			<br><br>		
			
			<div class="user_button_box_nick font_air bold">
				<button class="userChk_button_confirm font_air bold"
				v-if="nickChkFlg"
				@click="usernickchange"
				>변경</button>
				<button class="userChk_button_confirm font_air bold"
				v-if="!nickChkFlg"
				>변경</button>
				<button class="userChk_button font_air bold" @click="ctlNickModal(false)">취소</button>
			</div>
		</div>	
	</div>
</div>
<div class="user_black-bg" 
	v-if="$store.state.openDelModal"
	>
	<div class="user_white-bg font_air bold">
		<div class="user_withdraw font_air bold">
			<font-awesome-icon :icon="['fas', 'triangle-exclamation']" class="user_warning font_air bold"/>
		<h3 class="user_h3_userout font_air bold">니 내 없어도 개안캤나?</h3>
			<span class="user_warningText font_air bold">탈퇴하시면 복구 안됩니다.</span>
				<br><br>
				<label for="user_del_reason" class="font_air bold">탈퇴사유 : </label>
				<select name="reason" id="user_del_reason" v-model="delreason" class="font_air bold">
					<option class="font_air bold">서비스 불만족</option>
					<option class="font_air bold">원하는 정보가 없음</option>
					<option class="font_air bold">불건전한 내용</option>
					<option class="font_air bold">기타</option>
				</select>
				<br>
				<input type="text"
					id="user_del_reason_input"
					v-if="delinput"
					placeholder="직접 입력 50자 내외"
					maxlength="50"
					class="font_air bold"
				>
			<br>
			<div class="user_button_box_userout">
				<button class="userChk_button_negative font_air bold"
					@click="userout"
				>탈퇴</button>
				<button class="userChk_button font_air bold" @click="ctlDelModal(false)">취소</button>
		</div>
		</div>
	</div>
</div>

<div class="user_container">
	<br>
	<div class="user_subcontainer">
		<div class="user_box_top_red_center">
			<h2 class="user_h2 font_air bold">회원정보</h2>
		</div>
		<div class="user_vacant_box"></div>
	</div>
	<br>
	<div class="user_infocontainer">
		<div class="user_userInfo_text3">
			<h3 class=" font_air bold">회원정보 설정</h3>
		</div>
		<table class="user_table">
			<tbody>
				<tr>
					<td class="user_rowname font_air bold">회원번호</td>
					<td class="user_rowcontent">{{ $store.state.userInfo.id }}</td>
				</tr>
				
				<tr>					
					<td class="user_rowname font_air bold">이메일</td>
					<td class="user_rowcontent font_air bold">{{ $store.state.userInfo.email }}</td>					
				</tr>
				<tr>
					<td class="user_rowname font_air bold">비밀번호</td>
					<td class="user_rowcontent font_air bold">*********<button type="submit" class="user_button font_air bold" @click="ctlPasswordModal(true)">변경</button></td>
				</tr>
				<tr>
					<td class="user_rowname font_air bold">닉네임</td>
					<td class="user_rowcontent font_air bold"
					>{{ $store.state.NowUser }}<button type="submit" class="user_button font_air bold"  @click="ctlNickModal(true)">변경</button></td>
				</tr>
				<tr>
					<td class="user_rowname font_air bold">탈퇴신청</td>
					<td class="user_rowcontent font_air bold"><button type="submit" class="user_button_exit font_air bold"  @click="ctlDelModal(true)">탈퇴</button></td>
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
			err_nick1: false,
			err_nick2: false,
			err_nick3: false,
			com_nick: false,
			nickChkFlg: false,
		}
	},
	watch: {
		delreason(){
			this.del_val();
		},
		user_pw(){
			this.pwval();
			if(!(this.user_pw_chk==="")){
				this.pwchkval();
			}
		},
		user_pw_chk(){
			this.pwchkval();
		},
		nick(){
			this.nickChkFlg = false
			this.nickval();
		},
	},
	created() {
		this.GetUser();
	},
	methods: {
		// 닉네임체크
		// nick_chk(){
		// 	const URL = '/signin/nick?nick='+this.nick;
		// 	axios.get(URL)
		// 	.then(res => {
		// 		console.log("댄");
		// 		this.$store.commit('setErrMsg','');
		// 		console.log(res.data.errorMsg);
		// 		if(res.data.code === "0"){
		// 			if(res.data.data.length === 0){
		// 				console.log("없을때");
		// 				this.$store.commit('setNickFlg',1);	
		// 			}else if(res.data.data.length > 0){
		// 				console.log("있을때");
		// 				this.$store.commit('setNickFlg',2);
		// 			}
		// 		}else{
		// 			alert("닉네임체크에 실패하였습니다");
		// 		}
		// 	})
		// 	.catch(err => {
		// 		this.$store.commit('setNickFlg',0);
		// 		this.$store.commit('setErrMsg',err.response.data.errorMsg);
		// 	})
		// },
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
							alert("닉네임체크에 실패하였습니다");
						}
					})
					.catch(err => {
						this.$store.commit('setNickFlg', 0);
						this.$store.commit('setErrMsg', err.response.data.errorMsg);
					});
			}, 200);
		},
		// 유저정보불러오기
		GetUser(){
			const URL = '/userinfo';
			axios.get(URL)
			.then(res => {
				this.$store.commit('setUserInfo',res.data.data);
			})
			.catch(err => {
				alert("유저정보를 불러오는대 실패했습니다. \n다시시도해주세요");
			})
		},
		// 비밀번호변경
		ctlPasswordModal(flg){	
			if(flg === false){
				this.user_pw_chk= "";
				this.user_pw= "";
			}
			this.$store.commit('setPasswordModalFlg',flg);
		},
		ctlNickModal(flg){
			if(flg === false){
				this.nick= "";
			}
		
			this.$store.commit('setNickModalFlg',flg);
		},
		ctlDelModal(flg){
			this.$store.commit('setDelModalFlg',flg);
			
		},
		pw(){
			this.pwval();
		},
		pw_chk(){
			this.pwchkval();
		},
		del_val(){
			let reason = document.querySelector('#user_del_reason');
			console.log(reason.value);
			console.log("정상");
			console.log(this.delinput);
			if(reason.value === "기타"){
				this.delinput = true;
			}else{
				this.delinput = false;
			}
		},
		pwval(){
			const VAR1 = /[a-zA-Z]/;
			const VAR2 = /\d+/;
			const VAR3 = /[?~!@#]+/;
			const VAR4 = /^.{8,20}$/;
			const VAR5 = /^(?=.*[a-zA-Z\d])(?=.*\d)(?=.*[~!@#?])[a-zA-Z\d~!@#?]{8,20}$/;
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
				return;
			}else if(this.user_pw_chk !== this.user_pw||!this.user_pw_chk){
				this.user_err_pw_chk = true;
				this.user_com_pw_chk = false;
				return;
			}
			this.user_err_pw_chk = false;
			this.user_com_pw_chk = true;
		},
		nickval(){
			const VAR = /^.{2,8}$/;
			const VAR1 = /^[가-힣a-zA-Z0-9]+$/;
			const VAR2 = /^[가-힣a-zA-Z0-9]{2,8}$/;
			if(this.nick===""){
				this.err_nick1 = false;
				this.err_nick2 = false;
				this.err_nick3 = false;
				this.com_nick = false;
				return;
			}else if(!VAR.test(this.nick)){
				this.err_nick1 = true;
				this.err_nick2 = false;
				this.err_nick3 = false;
				this.com_nick = false;
				return;
			}else if(!VAR1.test(this.nick)){
				this.err_nick1 = false;
				this.err_nick2 = true;
				this.err_nick3 = false;
				this.com_nick = false;
				return;
			}else if(!VAR2.test(this.nick)||!this.nick){
				this.err_nick1 = false;
				this.err_nick2 = false;
				this.err_nick3 = true;
				this.com_nick = false;
				return;
			}
			this.err_nick1 = false;
			this.err_nick2 = false;
			this.err_nick3 = false;
			this.com_nick = true;
			this.nick_chk();
		},
		userpwchange(){
			if(this.user_com_pw&&this.user_com_pw_chk){
				this.$store.dispatch('actionChangePw');
			}else{
				alert("입력값을 확인해 주세요");
			}
		},
		usernickchange(){
			this.nick_chk();
			if(this.$store.state.nickFlg === 1){
				let nick = document.querySelector('#user_nick');
				const URL = '/user/nchk';
				const HEADER = {
					headers: {
						'Content-Type': 'multipart/form-data',
					}
				};
				const formData = new FormData();
				formData.append('nick', nick.value);

				axios.post(URL,formData,HEADER)
				.then(res => {
					if(res.data.code === "0"){	
						this.nick = "";
						this.$store.commit('setNickModalFlg',false);
						this.$store.commit('setNickFlg',0);
						localStorage.setItem('nick', nick.value);
						this.$store.commit('setNowUser',nick.value);
						alert('정상처리되었습니다');
					}else if(res.data.code === "0"){
						alert(res.data.errorMsg);
					}else{
						alert(res.data.errorMsg);
					}
				})
				.catch(err => {
					alert(err.response.data.errorMsg);
				})
			}else{
				this.nickval();
			}
		},
		userout(){
			this.$store.dispatch('actiondeluser');
		},
		// 닉네임 한글 바로인식
		koreanick(e) {
			this.nick = e.target.value;
		},
	},
	beforeRouteLeave(to, from, next) {
		this.$store.commit('setPasswordModalFlg',false);
		this.$store.commit('setNickModalFlg',false);
		this.$store.commit('setDelModalFlg',false);
		this.$store.commit('setUserFlg',false);
		this.$store.commit('setNickFlg',0);
		next();
	},
}
</script>