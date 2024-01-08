<template>
	<!-- 헤더 -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top p-3">
		<div class="container-fluid">
			<router-link to="/admin" @click="flgchg(0,0)">이의이승관리자</router-link>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							등록
						</a>
						<ul class="dropdown-menu">
							<li><div class="dropdown-item pointer" @click="flgchg(1,0)">축제 등록</div></li>
							<li><div class="dropdown-item pointer" @click="flgchg(1,1)">관광 등록</div></li>
							<li><div class="dropdown-item pointer" @click="flgchg(1,2)">공지 등록</div></li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							통계
						</a>
						<ul class="dropdown-menu">
							<li><div class="dropdown-item pointer" @click="flgchg(2,0)">가입&탈퇴</div></li>
							<li><div class="dropdown-item pointer" @click="flgchg(2,1)">조회수</div></li>
							<li><div class="dropdown-item pointer" @click="flgchg(2,2)">좋아요</div></li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							유저관리
						</a>
						<ul class="dropdown-menu">
							<li><div class="dropdown-item pointer" @click="flgchg(3,0)">건의답변</div></li>
							<li><div class="dropdown-item pointer" @click="flgchg(3,1)">신고목록</div></li>
							<li><div class="dropdown-item pointer" @click="flgchg(3,2)">유저관리</div></li>
						</ul>
					</li>
				</ul>
				<router-link to="/main">메인으로</router-link>
				<div
					class="pointer"
					@click="logout"
				>로그아웃</div>
			</div>
		</div>
	</nav>
	<!-- 메인 -->
	<div class="admin_frame" v-if="mainflg===0">
		<div class="admin_container">
			<div>
				<div class="admin_header">
					<div>오늘 가입 탈퇴</div>
					<div class="pointer">자세히보기</div>
				</div>
				<div class="admin_content">			
					<div class="admin_box">
						<div>가입</div>
						<br>
						<div>{{ this.sign_cnt }} 명</div>
					</div>	
					<div class="admin_box">
						<div>탈퇴</div>
						<br>
						<div>{{ this.drop_cnt }} 명</div>
					</div>
				</div>
			</div>
			<div>
				<div class="admin_header">
					<div class="position-relative admin_header_num">
						미 답변 질문
					<span class="position-absolute top-75 start-100 translate-middle badge rounded-pill bg-danger">
						99+
						<span class="visually-hidden">unread messages</span>
					</span>
					</div>
				<div class="pointer">자세히보기</div>
				</div>
				<div class="admin_content">
					<div class="admin_box pointer"
						:id='"admin_data"+data.id'
						v-for="data in data" :key="data"
						@click="dataget(data)"
					>
						<div>유저번호 : {{ data.u_id }}</div>
						<div>Email : {{ data.email }}</div>
						<div>제목 : {{ data.title }}</div>
						<div>내용 : {{ data.content }}</div>
						<div>질문시간 : {{ data.created_at }}</div>
					</div>
					<div 
						v-if="data.length === 0"
						class="admin_nolist"
					>
						리스트가 없습니다.
					</div>
				</div>
			</div>
			<div>
				<div class="admin_header">
					<div>신고목록</div>
				<div class="pointer">자세히보기</div>
				</div>
				<div class="admin_content">
					<div class="admin_box pointer"
						:id='"admin_report"+data.id'
					v-for="data in r_data" :key="data"
						@click="reportget(data)"
					>
						<div>위치 : {{ data.flg }}</div>
						<div>신고한 유저번호 : {{ data.u_id }}</div>
						<div>Email : {{ data.email }}</div>
						<div>신고당한id : {{ data.b_id }}</div>
						<div>신고사유 : {{ data.content }}</div>
						<div>신고시간 : {{ data.created_at }}</div>
					</div>
					<div 
						v-if="r_data.length === 0"
						class="admin_nolist"
					>
						리스트가 없습니다.
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 모달 -->
	<div class="admin_modal_bg"
		v-if="modalflg"
	>
		<div class="admin_modal">
			<div 
				v-if="Object.keys(this.now_data).length > 0"
			>
				<div class="admin_modal_title">질문정보</div>
				<div class="admin_modal_container">
					<div>유저번호 : {{ now_data.u_id }}</div>
					<div>이메일 : {{ now_data.email }}</div>
					<div>제목 : {{ now_data.title }}</div>
					<div>질문내용 : {{ now_data.content }}</div>
					<div>질문일자 : {{ now_data.created_at }}</div>
				</div>
				<input type="text" class="admin_modal_input" 
					v-model="answer"
					@input="koreaName"
					@keyup.enter="repliewrite"
				>
				<div class="admin_modal_btn_box">
					<div class="admin_modal_btn pointer"
						@click="adminAnswer(now_data.id)"
					>답변</div>
					<div class="admin_modal_btn pointer"
						@click="closeModal"
					>취소</div>
				</div>
			</div>
			<div 
				v-if="Object.keys(this.modalReport_r).length > 0"
			>
				<div class="admin_modal_title">신고된댓글</div>
				<div class="admin_modal_container">
					<div><span class="pointer">작성유저번호 : {{ modalReport_r.u_id }}</span></div>
					<div><span class="pointer">작성유저Email : {{ modalReport_r.email }}</span></div>
					<div>댓글내용 : {{ modalReport_r.replie }}</div>
					<div>작성시간 : {{ modalReport_r.created_at }}</div>
					<div>삭제일자 : {{ modalReport_r.deleted_at }}</div>
				</div>
				<hr>
				<div>
					<div><span class="pointer">신고유저번호 : {{ this.now_report.u_id }}</span></div>
					<div><span class="pointer">신고유저Email : {{ this.now_report.email }}</span></div>
					<div>신고사유 : {{ this.now_report.content }}</div>
					<div>신고시간 : {{ this.now_report.created_at }}</div>
				</div>
				<div class="admin_modal_btn_box">
					<div class="admin_modal_btn pointer"
						@click="delreplie(modalReport_r.id,now_report.flg)"
						v-if="modalReport_r.deleted_at==='X'"
					>댓글 삭제</div>
					<div class="admin_modal_btn pointer"
						@click="keepdata(this.now_report.id)"
						v-if="modalReport_r.deleted_at==='X'"
					>댓글 유지</div>
					<div class="admin_modal_btn pointer"
						@click="keepdata(this.now_report.id)"
						v-if="modalReport_r.deleted_at!=='X'"
					>확인</div>
					<div class="admin_modal_btn pointer"
						@click="closeModal"
					>취소</div>
				</div>
			</div>
			<div 
				v-if="Object.keys(this.modalReport_b).length > 0"
			>
				<div class="admin_modal_title">신고된커뮤</div>
				<div class="admin_modal_container">
					<div class="pointer">작성유저번호 : {{ modalReport_b.u_id }}</div>
					<div class="pointer">작성유저Email : {{ modalReport_b.email }}</div>
					<div>작성위치 : {{ modalReport_b.flg }}</div>
					<div>제목 : {{ modalReport_b.title }}</div>
					<div>내용 : {{ modalReport_b.content }}</div>
					<div>작성시간 : {{ modalReport_b.created_at }}</div>
					<div>삭제일자 : {{ modalReport_b.deleted_at }}</div>
				</div>
				<hr>
				<div>
					<div class="pointer">신고유저번호 : {{ this.now_report.u_id }}</div>
					<div class="pointer">신고유저Email : {{ this.now_report.email }}</div>
					<div>신고사유 : {{ this.now_report.content }}</div>
					<div>신고시간 : {{ this.now_report.created_at }}</div>
				</div>
				<div class="admin_modal_btn_box">
					<div class="admin_modal_btn pointer"
						@click="delreplie(modalReport_b.id,now_report.flg)"
						v-if="modalReport_b.deleted_at==='X'"
					>게시글 삭제</div>
					<div class="admin_modal_btn pointer"
						@click="keepdata(this.now_report.id)"
						v-if="modalReport_b.deleted_at==='X'"
					>게시글 유지</div>
					<div class="admin_modal_btn pointer"
						@click="keepdata(this.now_report.id)"
						v-if="modalReport_b.deleted_at!=='X'"
					>확인</div>
					<div class="admin_modal_btn pointer"
						@click="closeModal(this.now_report.id)"
					>취소</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 등록페이지 -->
	<!-- 축제등록 -->
	<div v-if="mainflg===1&&subflg===0" class="admin_frame">
		<div>축제등록</div>
		<div>
			<div>주소</div>
			<input type="text">
		</div>
		<div>
			<div>제목</div>
			<input type="text">
		</div>
		<div>
			<div>내용</div>
			<input type="text">
		</div>
		<div>
			<div>사진1</div>
			<input id="shop_file" type="file" accept="image/*">
			<div>사진2</div>
			<input id="shop_file" type="file" accept="image/*">
			<div>사진3</div>
			<input id="shop_file" type="file" accept="image/*">
		</div>
		<div>
			<div>내용</div>
			<input type="text">
		</div>
		<div>
			<div>지역</div>
			<select>
				<option class=" font_air bold">경상북도</option>
				<option class=" font_air bold">경상남도</option>
			</select>
		</div>
		<div>
			<select>
				<option class=" font_air bold">옵션들</option>
			</select>
		</div>
		<div>
			<div>축제,관광</div>
			<select>
				<option class=" font_air bold">축제</option>
				<option class=" font_air bold">관광</option>
			</select>
		</div>
		<div>
			<div>축제시작</div>
			<input type="date">
		</div>
		<div>
			<div>축제종료</div>
			<input type="date">
		</div>
		<div>
			<div>주차</div>
			<input type="checkbox">
		</div>
		<div>
			<div>친구끼리가기좋은</div>
			<input type="checkbox">
		</div>
		<div>
			<div>가족끼리가기좋은</div>
			<input type="checkbox">
		</div>
		<div>
			<div>연인끼리가기좋은</div>
			<input type="checkbox">
		</div>
		<div>
			<div>입장료</div>
			<input type="text">
		</div>
		<div>
			<div>이용시간</div>
			<input type="text">
		</div>
		<div>
			<div>휴일</div>
			<input type="text">
		</div>
		<div>
			<div>연락처</div>
			<input type="text">
		</div>
	</div>
	<!-- 관광등록 -->
	<div v-if="mainflg===1&&subflg===1" class="admin_frame">
		<div>
			<div>관광등록</div>
			<div>
				<div>주소</div>
				<input type="text">
			</div>
			<div>
				<div>제목</div>
				<input type="text">
			</div>
			<div>
				<div>내용</div>
				<input type="text">
			</div>
			<div>
				<div>사진1</div>
				<input id="shop_file" type="file" accept="image/*">
				<div>사진2</div>
				<input id="shop_file" type="file" accept="image/*">
				<div>사진3</div>
				<input id="shop_file" type="file" accept="image/*">
			</div>
			<div>
				<div>내용</div>
				<input type="text">
			</div>
			<div>
				<div>지역</div>
				<select>
					<option class=" font_air bold">경상북도</option>
					<option class=" font_air bold">경상남도</option>
				</select>
			</div>
			<div>
				<select>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
					<option class=" font_air bold">옵션들</option>
				</select>
			</div>
			<div>
				<div>주차</div>
				<input type="checkbox">
			</div>
			<div>
				<div>친구끼리가기좋은</div>
				<input type="checkbox">
			</div>
			<div>
				<div>가족끼리가기좋은</div>
				<input type="checkbox">
			</div>
			<div>
				<div>연인끼리가기좋은</div>
				<input type="checkbox">
			</div>
			<div>
				<div>입장료</div>
				<input type="text">
			</div>
			<div>
				<div>이용시간</div>
				<input type="text">
			</div>
			<div>
				<div>휴일</div>
				<input type="text">
			</div>
			<div>
				<div>연락처</div>
				<input type="text">
			</div>
		</div>
	</div>
	<!-- 공지등록 -->
	<div v-if="mainflg===1&&subflg===2" class="admin_frame">
		테스트2
	</div>
	<!-- 등록페이지 -->
	<div v-if="mainflg===2&&subflg===0" class="admin_frame">
		테스트3
	</div>
	<div v-if="mainflg===2&&subflg===1" class="admin_frame">
		테스트4
	</div>
	<div v-if="mainflg===2&&subflg===2" class="admin_frame">
		테스트5
	</div>
	<!-- 등록페이지 -->
	<div v-if="mainflg===3&&subflg===0" class="admin_frame">
		테스트6
	</div>
	<div v-if="mainflg===3&&subflg===1" class="admin_frame">
		테스트7
	</div>
	<div v-if="mainflg===3&&subflg===2" class="admin_frame">
		유저검색
		<select v-model="searchtype">
			<option class=" font_air bold" value="0">유저번호</option>
			<option class=" font_air bold" value="1">email</option>
		</select>
		<input type="text" v-model="searchval" @keyup.enter="searchuser">
		<button
			@click="searchuser"
		>검색</button>
		<div>
			검색결과
			<div>유저번호 : {{ this.selectUserData.id }}</div>
			<div>이메일 : {{ this.selectUserData.id }}</div>
			<div>이름 : {{ this.selectUserData.id }}</div>
			<div>닉네임 : {{ this.selectUserData.id }}</div>
			<div>전화번호 : {{ this.selectUserData.id }}</div>
			<div>생년월일 : {{ this.selectUserData.id }}</div>
			<div>성별 : {{ this.selectUserData.id }}</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'AdminComponent',
	props: {

	},
	
	components: {

	},

	data() {
		return {
			today: "",
			searchval: "",
			searchtype: "",
			sign_cnt: 0,
			mainflg: 0,
			subflg: 0,
			drop_cnt: 0,
			data: [],
			r_data: [],
			now_data: {},
			now_report: {},
			modalReport_b:{},
			modalReport_r:{},
			modalflg:false,
			answer: "",
			selectUserData: {},
		}
	},

	created() {
		this.getToday();
		this.adminchk();
	},

	mounted() {

	},

	methods: {
		adminchk(){
			this.$store.commit('setLoading',true);
			let id = localStorage.getItem('admin')
			let nick = localStorage.getItem('nick')
			let email = localStorage.getItem('email')
			const URL = '/admin/user?id='+id+'&nick='+nick+'&email='+email+'&today='+this.today
			axios.get(URL)
			.then(res => {
			if(res.data.code === "0"){
					this.sign_cnt = res.data.sign_cnt; 
					this.drop_cnt = res.data.drop_cnt; 
					this.data = res.data.data; 
					this.r_data = res.data.r_data;
					this.r_data.forEach(item => {
						item.flg = item.flg === '0' ? '커뮤' : '댓글';
					});
				}
			})
			.catch(err => {
				alert(err.response.data.errorMsg);
				if(err.response.data.code === "E99"){
					alert(err.response.data.errorMsg);
					this.logout();
				}
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 로그아웃호출
        logout(){
            this.$store.dispatch('actionLogout');
        },
		// 오늘날짜
		getToday() {
			const now = new Date();
			const year = now.getFullYear();
			const month = String(now.getMonth() + 1).padStart(2, '0');
			const day = String(now.getDate()).padStart(2, '0');
			this.today = `${year}-${month}-${day}`;
		},
		// 신고된거 가져오기
		reportget(data){
			this.$store.commit('setLoading',true);
			this.now_data = {};
			this.now_report = data
			const URL = '/admin/report?b_id='+data.b_id+'&flg='+data.flg
			axios.get(URL)
			.then(res => {
				console.log("댄진입")
				if(data.flg === "댓글"){
					this.modalReport_b = {};
					res.data.data.deleted_at = res.data.data.deleted_at === null ? "X":res.data.data.deleted_at;
					this.modalReport_r = res.data.data;
				}else{
					this.modalReport_r = {};
					console.log("플래그"+res.data.data.flg);
					if(res.data.data.flg ==="0"){
						res.data.data.flg = "자유게시판"
					}else if(res.data.data.flg ==="1"){
						res.data.data.flg ="정보게시판"
					}else{
						res.data.data.flg ="질문게시판"
					}
					res.data.data.deleted_at = res.data.data.deleted_at === null ? "X":res.data.data.deleted_at;
					this.modalReport_b = res.data.data;
				}
				this.modalflg = true;
			})
			.catch(err => {
				alert("데이터 에러 발생");
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 모달클로즈
		closeModal(){
			this.$store.commit('setLoading',true);
			this.modalReport_b = {};
			this.modalReport_r = {};
			this.now_data = {};
			this.modalflg = false;
			this.$store.commit('setLoading', false);
		},
		// 답변달기
		adminAnswer(id){
			if(this.amswer === ""||this.amswer === null){
				alert("답변을 입력해 주세요");
			}else{
				this.$store.commit('setLoading',true);
				const URL = '/admin/data'
				const formData = new FormData();
				formData.append('id', id);
				formData.append('replie', this.answer);
				axios.post(URL,formData)
				.then(res => {
					if(res.data.code === "0"){
						alert('정상처리되었습니다');
						this.closeModal();
						this.amswer="";
						this.adminchk();
					}else if(res.data.code === "1"){
						alert('이미 삭제된 질문 입니다');
						this.closeModal();
						this.amswer="";
						this.adminchk();
					}else{
						alert(res.data.errorMsg);
					}
				})
				.catch(err => {
					alert("데이터 에러 발생");
				})
				.finally(() => {
					this.$store.commit('setLoading', false);
				});
			}
		},
		// 게시물 삭제
		delreplie(id,flg){
			this.$store.commit('setLoading', true);
			const URL = '/admin/report?id='+id+'&flg='+flg
			axios.delete(URL)
			.then(res => {
				if(res.data.code === "0"){
						alert('정상처리되었습니다');
						this.closeModal();
						this.adminchk();
					}else{
						alert(res.data.errorMsg);
					}
			})
			.catch(err => {
				alert("데이터 에러 발생");
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 이름 한글 바로인식
		koreaName(e) {
			this.answer = e.target.value;
		},
		// 답변질문 클릭
		dataget(data){
			this.$store.commit('setLoading',true);
			this.modalReport_b = {};
			this.modalReport_r = {};
			this.now_data = data;
			this.modalflg = true;
			this.$store.commit('setLoading', false);
		},
		// 삭제안하고 플래그변경
		keepdata(id){
			this.$store.commit('setLoading',true);
			const formData = new FormData();
			formData.append('id', id);
			const URL = '/admin/report'
			axios.post(URL,formData)
			.then(res => {
				if(res.data.code === "0"){
						alert('정상처리되었습니다');
						this.closeModal();
						this.adminchk();
					}else{
						alert(res.data.errorMsg);
					}
			})
			.catch(err => {
				alert("데이터 에러 발생");
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 플래그변경
		flgchg(main,sub){
			this.mainflg = main;
			this.subflg = sub;
		},
		// 유저검색
		searchuser(){
			this.$store.commit('setLoading',true);
			const URL = '/admin/userinfo?val='+this.searchval+"&flg="+this.searchtype
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.selectUserData=res.data.data
				}else if(res.data.code === "1"){
					alert(res.data.errorMsg);
				}
			})
			.catch(err => {
				alert("데이터 에러 발생");
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
	}
}
</script>