<template>
	<!-- 헤더 -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top p-3">
		<div class="container-fluid">
			<router-link to="/admin">이의이승관리자</router-link>
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
							<li><a class="dropdown-item" href="#">축제 등록</a></li>
							<li><a class="dropdown-item" href="#">관광 등록</a></li>
							<li><a class="dropdown-item" href="#">공지 등록</a></li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							통계
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">가입&탈퇴</a></li>
							<li><a class="dropdown-item" href="#">조회수</a></li>
							<li><a class="dropdown-item" href="#">좋아요</a></li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							유저관리
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">건의답변</a></li>
							<li><a class="dropdown-item" href="#">신고목록</a></li>
							<li><a class="dropdown-item" href="#">유저관리</a></li>
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
	<div class="admin_frame">
		<div class="admin_container">
			<div>
				<div class="admin_header">
					<div>오늘 가입 탈퇴</div>
					<div>자세히보기</div>
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
					<div>미 답변 질문</div>
				<div>자세히보기</div>
				</div>
				<div class="admin_content pointer">
					<div class="admin_box"
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
				</div>
			</div>
			<div>
				<div class="admin_header">
					<div>신고목록</div>
				<div>자세히보기</div>
				</div>
				<div class="admin_content pointer">
					<div class="admin_box"
						:id='"admin_report"+data.id'
					v-for="data in r_data" :key="data"
						@click="reportget(data)"
					>
						<div>위치 : {{ data.flg }}</div>
						<div>신고한 유저번호 : {{ data.u_id }}</div>
						<div>Email : {{ data.email }}</div>
						<div>신고당한id : {{ data.b_id }}</div>
						<div>신고사유 : {{ data.content }}</div>
						<div>신고시간 : {{ data.report_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="admin_modal_bg"
		v-if="modalflg"
	>
		<div class="admin_modal">
			<div 
				v-if="Object.keys(this.now_data).length > 0"
			>
				<div class="admin_modal_title">질문정보</div>
				<div class="admin_modal_container">
					<div>제목 : {{ now_data.title }}</div>
					<div>이메일 : {{ now_data.email }}</div>
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
					<div>작성유저번호 : {{ modalReport_r.u_id }}</div>
					<div>작성유저Email : {{ modalReport_r.email }}</div>
					<div>댓글내용 : {{ modalReport_r.replie }}</div>
					<div>작성시간 : {{ modalReport_r.created_at }}</div>
				</div>
				<hr>
				<div>
					<div>신고유저번호 : {{ this.now_report.u_id }}</div>
					<div>신고유저Email : {{ this.now_report.email }}</div>
					<div>신고사유 : {{ this.now_report.content }}</div>
					<div>신고시간 : {{ this.now_report.report_at }}</div>
				</div>
				<div class="admin_modal_btn_box">
					<div class="admin_modal_btn pointer"
						@click="delreplie"
					>댓글 삭제</div>
					<div class="admin_modal_btn pointer">신고자 삭제</div>
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
					<div>작성유저번호 : {{ modalReport_b.u_id }}</div>
					<div>작성유저Email : {{ modalReport_b.email }}</div>
					<div>작성위치 : {{ modalReport_b.flg }}</div>
					<div>제목 : {{ modalReport_b.title }}</div>
					<div>내용 : {{ modalReport_b.content }}</div>
					<div>작성시간 : {{ modalReport_b.created_at }}</div>
				</div>
				<hr>
				<div>
					<div>신고유저번호 : {{ this.now_report.u_id }}</div>
					<div>신고유저Email : {{ this.now_report.email }}</div>
					<div>신고사유 : {{ this.now_report.content }}</div>
					<div>신고시간 : {{ this.now_report.report_at }}</div>
				</div>
				<div class="admin_modal_btn_box">
					<div class="admin_modal_btn pointer">게시글 삭제</div>
					<div class="admin_modal_btn pointer">신고자 삭제</div>
					<div class="admin_modal_btn pointer"
						@click="closeModal(this.now_report.id)"
					>취소</div>
				</div>
			</div>
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
			sign_cnt: 0,
			drop_cnt: 0,
			data: [],
			r_data: [],
			now_data: {},
			now_report: {},
			modalReport_b:{},
			modalReport_r:{},
			modalflg:false,
			answer: "",
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
						// document.querySelector('#admin_data'+id).remove();
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
		// 댓글삭제
		delreplie(id){
			const URL = '/admin/report?b_id='+data.b_id+'&flg='+data.flg
			axios.get(URL)
			.then(res => {
				console.log("댄진입")
				if(data.flg === "댓글"){
					this.modalReport_b = {};
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
	}
}
</script>