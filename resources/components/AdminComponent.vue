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
						{{ this.d_cnt }}
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
					<div class="position-relative">신고목록
						<span class="position-absolute top-75 start-100 translate-middle badge rounded-pill bg-danger">
							{{ this.r_cnt }}
						</span>
					</div>
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
					@keyup.enter="adminAnswer(now_data.id)"
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
				v-if="Object.keys(this.modalReport).length > 0"
			>
				<div class="admin_modal_title">신고된 {{ reportarr1[this.now_report.flg] }}</div>
				<div class="admin_modal_container">
					<div class="input-group  mb-3">
						<span class="input-group-text admin_report_span_to">유저번호</span>
						<div aria-label="First name" class="form-control">
							{{ modalReport.u_id }}
						</div>
						<span class="input-group-text admin_report_span_to">Email</span>
						<div aria-label="Last name" class="form-control">
							{{ modalReport.email }}
						</div>
					</div>
					<div class="input-group mb-3" 
						v-if="this.now_report.flg==='1'"
					>
						<span class="input-group-text admin_report_span_to">내용</span>
						<div class="form-control" aria-label="With textarea">{{ modalReport.replie }}</div>
					</div>
					<div
						v-if="this.now_report.flg==='0'"
					>
						<div class="input-group">
							<span class="input-group-text admin_report_span_to" id="inputGroup-sizing-default">작성위치</span>
							<div class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
								{{ modalReport.flg }}
							</div>
						</div>
						<div class="input-group">
							<span class="input-group-text admin_report_span_to" id="inputGroup-sizing-default">제목</span>
							<div class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
								{{ modalReport.title }}
							</div>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text admin_report_span_to">내용</span>
							<div class="form-control" aria-label="With textarea">{{ modalReport.content }}</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text admin_report_span_to">작성시간</span>
						<div class="form-control" aria-label="With textarea">{{ modalReport.created_at }}</div>
						<span class="input-group-text admin_report_span_to">삭제일자</span>
						<div class="form-control" aria-label="With textarea">{{ modalReport.deleted_at }}</div>
					</div>
				</div>
				<hr>
				<div>
					<div class="admin_modal_title">신고자</div>
					<div class="input-group">
						<span class="input-group-text admin_report_span_from">유저번호</span>
						<div aria-label="First name" class="form-control">
							{{ this.now_report.u_id }}
						</div>
						<span class="input-group-text admin_report_span_from">Email</span>
						<div aria-label="Last name" class="form-control">
							{{ this.now_report.email }}
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-text admin_report_span_from">신고사유</span>
						<div class="form-control" aria-label="With textarea">{{ this.now_report.content }}</div>
					</div>
					<div class="input-group mb-4">
						<span class="input-group-text admin_report_span_from">신고시간</span>
						<div class="form-control" aria-label="With textarea">{{ this.now_report.created_at }}</div>
					</div>
				</div>
				<div class="admin_modal_btn_box">
					<button type="button" class="btn btn-danger" 
						@click="delreplie(modalReport.id,now_report.flg)" 
						v-if="modalReport.deleted_at === 'X'"
					>게시글 삭제</button>
					<button type="button" class="btn btn-danger"
						@click="repairreplie(modalReport.id,now_report.flg)" 
						v-if="modalReport.deleted_at !== 'X'&&this.now_report.admin_flg !== '0'"
					>게시글 복구</button>
					<button type="button" class="btn btn-primary"
						@click="keepdata(this.now_report.id)"
						v-if="this.now_report.admin_flg === '0'"
					>게시글 유지</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning"
						v-if="this.now_report.admin_flg === '3'"
					>
						작성자 제재해제
					</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
						v-if="this.now_report.admin_flg !== '3'"
					>
						작성자 제재
					</button>	
					<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.modalReport.u_id,'0')">1일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.modalReport.u_id,'1')">3일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.modalReport.u_id,'2')">7일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.modalReport.u_id,'3')">15일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.modalReport.u_id,'4')">30일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.modalReport.u_id,'5')">영구제재</a></li>
					</ul>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning"
						v-if="this.now_report.admin_flg === '4'"
					>
						신고자 제재해제
					</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
						v-if="this.now_report.admin_flg !== '4'"
					>
						신고자 제재
					</button>
					<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.u_id,'0')">1일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.u_id,'1')">3일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.u_id,'2')">7일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.u_id,'3')">15일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.u_id,'4')">30일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.u_id,'5')">영구제재</a></li>
					</ul>
					<button type="button" class="btn btn-secondary" @click="closeModal">취소</button>
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
		신고목록
		<div>
			처리전
		</div>
		<div class="row row-cols-1 row-cols-md-4 g-4">
			<div class="col" 
				v-for="data in reportdata_before" :key="data"
			>
				<div class="card">
					<div class="card-body pointer"
						@click="reportget(data)"
					>
						<div class="admin_report_card_header">
							<h5 class="card-title">신고한 유저</h5>
							<span :class="'admin_report_card_header_span'+data.admin_flg">{{ this.reportarr[data.admin_flg] }}</span>
						</div>
						<div class="card-text">유저번호 = {{ data.u_id }}</div>
						<div class="card-text">email = {{ data.email }}</div>
						<div class="card-text">신고사유 = {{ data.content }}</div>
						<hr>
						<h5 class="card-title">신고 당한 {{this.reportarr1[data.flg]}}</h5>
						<div class="card-text">{{this.reportarr1[data.flg]}}번호 = {{ data.b_id }}</div>
						<div class="card-text">신고시간 = {{ data.created_at }}</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div>
			처리완료
		</div>
		<div class="row row-cols-1 row-cols-md-4 g-4">
			<div class="col" 
				v-for="data in reportdata_after" :key="data"
			>
				<div class="card">
					<div class="card-body pointer"
						@click="reportget(data)"
					>
						<div class="admin_report_card_header">
							<h5 class="card-title">신고한 유저</h5>
							<span :class="'admin_report_card_header_span'+data.admin_flg">{{ this.reportarr[data.admin_flg] }}</span>
						</div>
						<div class="card-text">유저번호 = {{ data.u_id }}</div>
						<div class="card-text">email = {{ data.email }}</div>
						<div class="card-text">신고사유 = {{ data.content }}</div>
						<hr>
						<h5 class="card-title">신고 당한 {{this.reportarr1[data.flg]}}</h5>
						<div class="card-text">{{this.reportarr1[data.flg]}}번호 = {{ data.b_id }}</div>
						<div class="card-text">신고시간 = {{ data.created_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div v-if="mainflg===3&&subflg===2" class="admin_frame">
		유저관리
		<select v-model="searchtype">
			<option class=" font_air bold" value="0">유저번호</option>
			<option class=" font_air bold" value="1">email</option>
		</select>
		<input type="text" v-model="searchval" @keyup.enter="searchuser">
		<button
			@click="searchuser"
		>검색</button>
		<div v-if="searchflg">
			<div>
				검색결과
				<div>유저번호 : {{ this.selectUserData.id }}</div>
				<div>이메일 : {{ this.selectUserData.email }}</div>
				<div>이름 : {{ this.selectUserData.name }}</div>
				<div>닉네임 : {{ this.selectUserData.nick }}</div>
				<div>전화번호 : {{ this.selectUserData.phone }}</div>
				<div>생년월일 : {{ this.selectUserData.birthdate }}</div>
				<div>성별 : {{ this.selectUserData.gender }}</div>
				<div>제재당한횟수 : {{ this.selectUserData.cnt }}</div>
				<div
					v-if=" this.selectUserData.cnt > 0 "
				>제재종료일 : {{ this.selectUserData.res_at }}</div>
			</div>
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">유저제재</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body" >
							<div>
								<span>제재기간</span>
								<select class="form-select" aria-label="Default select example" v-model="restraint_date">
									<option class=" font_air bold" value="0">1일</option>
									<option class=" font_air bold" value="1">3일</option>
									<option class=" font_air bold" value="2">7일</option>
									<option class=" font_air bold" value="3">15일</option>
									<option class=" font_air bold" value="4">30일</option>
									<option class=" font_air bold" value="5">영구제재</option>
								</select>
							</div>
							<div>
								<span>제재사유</span>
								<select class="form-select" aria-label="Default select example" v-model="restraint_msg">
									<option class=" font_air bold">욕설 및 혐오 표현</option>
									<option class=" font_air bold">불법 콘텐츠 게시</option>
									<option class=" font_air bold">스팸 활동</option>
									<option class=" font_air bold">악성 행위 및 고의적인 피해</option>
									<option class=" font_air bold">기타</option>
								</select>
								<input class="form-control" type="text" placeholder="직접 입력 20자 내외"
									maxlength="20" aria-label="default input example" v-if="restraintinput" v-model="restraint_msg2">
							</div>
						
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary admin_boot_modal_close" data-bs-dismiss="modal">닫기</button>
							<button type="button" class="btn btn-primary"
								@click="restraintuser()"
							>적용</button>
						</div>
					</div>
				</div>
			</div>
			<div class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
				v-if="this.selectUserData.res_at < this.todaytime||this.selectUserData.cnt === 0"
			>유저제재</div>
			<div class="btn btn-danger btn-sm"
				@click="clearestraint"
				v-if="this.selectUserData.res_at >= this.todaytime"
			>제제해제</div>
			<div class="btn btn-primary btn-sm" @click="resetall">확인</div>
		</div>
	</div>
</template>
<script>
import Swal from 'sweetalert2';

export default {
	name: 'AdminComponent',
	props: {

	},
	
	components: {

	},

	data() {
		return {
			today: "",
			todaytime: "",
			restraint_msg: "",
			restraint_msg2: "",
			restraint_date: "",
			searchval: "",
			searchtype: "유저번호",
			r_cnt: 0,
			d_cnt: 0,
			sign_cnt: 0,
			mainflg: 0,
			searchflg: false,
			subflg: 0,
			drop_cnt: 0,
			data: [],
			r_data: [],
			reportarr: {0:"처리전",1:"삭제처리",2:"이상없음",3:"작성자제재",4:"신고자제재"},
			reportarr1: {0:"게시글",1:"댓글"},
			now_data: {},
			now_report: {},
			modalReport:{},
			modalReport:{},
			reportdata_before:{},
			reportdata_after:{},
			modalflg:false,
			restraintinput:false,
			answer: "",
			selectUserData: {},
		}
	},
	watch: {
		restraint_msg(){
			this.restraint_msg_chk();
		},
	},
	created() {
		this.getToday();
		this.adminchk();
	},
	updated() {
		this.getToDayTime();
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
					this.d_cnt = res.data.d_cnt; 
					this.r_data = res.data.r_data;
					this.r_cnt = res.data.r_cnt;
					this.r_data.forEach(item => {
						item.flg = item.flg === '0' ? '커뮤' : '댓글';
					});
				}
			})
			.catch(err => {
				if(err.response.data.code === "E99"){
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '에러발생.',
						confirmButtonText: '확인'
					})
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
		// 시분초 가져오기
		getToDayTime() {
			const now = new Date();
			const year = now.getFullYear();
			const month = String(now.getMonth() + 1).padStart(2, '0');
			const day = String(now.getDate()).padStart(2, '0');
			const hours = String(now.getHours()).padStart(2, '0');
			const minutes = String(now.getMinutes()).padStart(2, '0');
			const seconds = String(now.getSeconds()).padStart(2, '0');
			this.todaytime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
		},
		// 신고된거 가져오기
		reportget(data){
			this.$store.commit('setLoading',true);
			this.now_data = {};
			this.now_report = data;
			const URL = '/admin/report?b_id='+data.b_id+'&flg='+data.flg
			axios.get(URL)
			.then(res => {
				console.log("댄진입")
				if(res.data.data.flg ==="0"){
					res.data.data.flg = "자유게시판"
				}else if(res.data.data.flg ==="1"){
					res.data.data.flg ="정보게시판"
				}else{
					res.data.data.flg ="질문게시판"
				}
				res.data.data.deleted_at = res.data.data.deleted_at === null ? "X":res.data.data.deleted_at;
				this.modalReport = res.data.data;
				console.log(this.modalReport.deleted_at)
				this.modalflg = true;
			})
			.catch(err => {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '에러발생.',
					confirmButtonText: '확인'
				})
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 모달클로즈
		closeModal(){
			this.$store.commit('setLoading',true);
			this.modalReport = {};
			this.now_data = {};
			this.modalflg = false;
			this.$store.commit('setLoading', false);
		},
		// 답변달기
		adminAnswer(id){
			if(this.answer === ""||this.answer === null){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '답변을 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else{
				this.$store.commit('setLoading',true);
				const URL = '/admin/data'
				const formData = new FormData();
				formData.append('id', id);
				formData.append('replie', this.answer);
				axios.post(URL,formData)
				.then(res => {
					if(res.data.code === "0"){
						Swal.fire({
							icon: 'success',
							title: '완료',
							text: '정상처리되었습니다.',
							confirmButtonText: '확인'
						})
						this.closeModal();
						this.answer="";
						this.adminchk();
					}else if(res.data.code === "1"){
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: '이미 삭제된 질문입니다.',
							confirmButtonText: '확인'
						})
						this.closeModal();
						this.answer="";
						this.adminchk();
					}else{
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: res.data.errorMsg,
							confirmButtonText: '확인'
						})
					}
				})
				.catch(err => {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '에러 발생.',
						confirmButtonText: '확인'
					})
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
					this.closeModal();
					this.resetall();
					this.reportall();
					this.adminchk();
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					})
				}else{
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '에러발생.',
						confirmButtonText: '확인'
					})
				}
			})
			.catch(err => {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '에러발생.',
					confirmButtonText: '확인'
				})
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
			this.modalReport = {};
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
					this.closeModal();
					this.resetall();
					this.reportall();
					this.adminchk();
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					})
				}else{
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: res.data.errorMsg,
						confirmButtonText: '확인'
					})
				}
			})
			.catch(err => {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '에러 발생.',
					confirmButtonText: '확인'
				})
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 플래그변경
		flgchg(main,sub){
			this.mainflg = main;
			this.subflg = sub;
			if(main===3,sub===1){
				this.reportall()
			}
			this.resetall()
		},
		// 유저검색
		searchuser(){
			if(this.searchval ===""){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '값을 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else if(this.searchtype ===""){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '값을 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else{
				this.$store.commit('setLoading',true);
				const URL = '/admin/userinfo?val='+this.searchval+"&flg="+this.searchtype
				axios.get(URL)
				.then(res => {
					if(res.data.code === "0"){
						this.selectUserData=res.data.data
						this.searchflg=true;
					}else if(res.data.code === "1"){
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: res.data.errorMsg,
							confirmButtonText: '확인'
						})
					}
				})
				.catch(err => {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '에러 발생.',
						confirmButtonText: '확인'
					})
				})
				.finally(() => {
					this.$store.commit('setLoading', false);
				});
			}
		},
		// 기타일시 작성인풋 소환
		restraint_msg_chk(){
			if(this.restraint_msg === "기타"){
				this.restraintinput = true;
			}else{
				this.restraintinput = false;
			}
		},
		// 유저제재하기
		restraintuser(){
			if(this.restraint_date ===""){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '제재기간을 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else if(this.restraint_msg ===""||(this.restraint_msg === "기타"&&this.restraint_msg2 === "")){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '제재사유를 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else{
				this.$store.commit('setLoading',true);
				if(this.restraint_msg === "기타"){
					this.restraint_msg = this.restraint_msg2
				}
				const URL = '/admin/userinfo'
				const formData = new FormData();
				formData.append('u_id', this.selectUserData.id);
				formData.append('date', this.restraint_date);
				formData.append('msg', this.restraint_msg);
				axios.post(URL,formData)
				.then(res => {
					if(res.data.code === "0"){
						document.querySelector('.admin_boot_modal_close').click();
						this.resetall()
						Swal.fire({
							icon: 'success',
							title: '완료',
							text: '정상처리되었습니다.',
							confirmButtonText: '확인'
						})
					}
				})
				.catch(err => {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '에러 발생.',
						confirmButtonText: '확인'
					})
				})
				.finally(() => {
					this.$store.commit('setLoading', false);
				});
			}
		},
		// 유저제재풀기
		clearestraint(){
			this.$store.commit('setLoading',true);
			const URL = '/admin/restraint'
			const formData = new FormData();
			formData.append('u_id', this.selectUserData.id);
			axios.post(URL,formData)
			.then(res => {
				if(res.data.code === "0"){
					this.resetall()
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					})
				}
			})
			.catch(err => {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '에러 발생.',
					confirmButtonText: '확인'
				})
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 신고데이터 전체불러오기
		reportall(){
			this.$store.commit('setLoading',true);
			const URL = '/admin/reportall'
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.reportdata_before = res.data.data.filter(item => item.admin_flg === "0");
					this.reportdata_after = res.data.data.filter(item => item.admin_flg !== "0");
				}
			})
			.catch(err => {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '에러 발생.',
					confirmButtonText: '확인'
				})
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 삭제된거 복구
		repairreplie(id,flg){
			const URL = '/admin/report/repair'
			const formData = new FormData();
			formData.append('id',id);
			formData.append('flg',flg);
			axios.post(URL,formData)
			.then(res => {
				this.resetall();
				this.reportall();
				Swal.fire({
					icon: 'success',
					title: '완료',
					text: '정상처리되었습니다.',
					confirmButtonText: '확인'
				})
			})
			.catch(err => {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '에러 발생.',
					confirmButtonText: '확인'
				})
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 유저제재
		modalRestraintuser(id,flg){
			let date=['1일','3일','7일','15일','30일','영구제제']
			Swal.fire({
				title: '유저번호 : ' + id,
				text: '재제사유 : ' + date[flg],
				input: 'select',  // 'select'로 지정
				inputOptions: {
					'option1': '욕설 및 혐오 표현',
					'option2': '불법 콘텐츠 게시',
					'option3': '스팸 활동',
					'option3': '악성 행위 및 고의적인 피해',
					'option3': '기타',
					// 추가적인 옵션들을 필요에 따라 정의
				},
				inputPlaceholder: '선택해주세요',  // 선택 전에 표시되는 플레이스홀더
				showCancelButton: true,
				confirmButtonText: '확인',
				cancelButtonText: '취소',
			})
			.then((result) => {
				if (result.isConfirmed) {
					// 사용자가 확인을 눌렀을 때의 동작
					const selectedOption = result.value;
					console.log('선택한 옵션:', selectedOption);				
					// const URL = '/admin/report/repair'
					// const formData = new FormData();
					// formData.append('id',id);
					// formData.append('flg',flg);
					// axios.post(URL,formData)
					// .then(res => {
					// 	// this.resetall();
					// 	// this.reportall();
					// 	Swal.fire({
					// 		icon: 'success',
					// 		title: '완료',
					// 		text: '정상처리되었습니다.',
					// 		confirmButtonText: '확인'
					// 	})
					// })
					// .catch(err => {
					// 	Swal.fire({
					// 		icon: 'error',
					// 		title: 'Error',
					// 		text: '에러 발생.',
					// 		confirmButtonText: '확인'
					// 	})
					// })
					// .finally(() => {
					// 	this.$store.commit('setLoading', false);
					// });
				}
			});
		},
		// 초기화용함수
		resetall(){
			this.restraint_msg= "";
			this.restraint_msg2= "";
			this.restraint_date= "";
			this.searchval= "";
			this.searchtype= "유저번호";
			this.sign_cnt= 0;
			this.searchflg=false;
			this.drop_cnt= 0;
			this.now_data= {};
			this.now_report= {};
			this.modalflg=false;
			this.restraintinput=false;
			this.answer= "";
			this.selectUserData= {};
		}
	}
}
</script>