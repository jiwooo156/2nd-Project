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
							<li><div class="dropdown-item pointer" @click="flgchg(2,0)">유저</div></li>
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
					<div class="input-group  mb-3">
						<span class="input-group-text">유저번호</span>
						<div aria-label="First name" class="form-control">
							{{ now_data.u_id }}
						</div>
						<span class="input-group-text">Email</span>
						<div aria-label="Last name" class="form-control">
							{{ now_data.email }}
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-text" id="inputGroup-sizing-default">번호</span>
						<div class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
							{{ now_data.id }}
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-text" id="inputGroup-sizing-default">제목</span>
						<div class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
							{{ now_data.title }}
						</div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">내용</span>
						<textarea class="form-control admin_request_textarea" aria-label="With textarea" readonly style="background-color: #fff;">{{ now_data.content }}</textarea>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">작성시간</span>
						<div class="form-control" aria-label="With textarea">{{ now_data.created_at }}</div>
					</div>
				</div>
				<div class="input-group mb-3"
					v-if="now_data.admin_flg==='0'"
				>
					<span class="input-group-text">답변</span>
					<textarea class="form-control" aria-label="With textarea"
						v-model="answer"
						placeholder="최대 200글자까지 작성 가능합니다"
						@input="koreaName"
						@keyup.enter="adminAnswer(now_data.id)"
					></textarea>
				</div>
				<div class="input-group mb-3"
					v-if="now_data.admin_flg==='1'"
				>
					<span class="input-group-text">답변내용</span>
					<textarea class="form-control admin_request_textarea" id="admin_request_textarea" aria-label="With textarea"
						readonly
					>{{ now_data.replie }}</textarea>
				</div>
				<div class="center">
					<button type="button" class="btn btn-primary admin_request_btn_box"
						v-if="now_data.admin_flg==='0'"
						@click="adminAnswer(now_data.id)"
					>답변</button>
					<button type="button" class="btn btn-primary admin_request_btn_box"
						v-if="now_data.admin_flg==='1'&&!updateflg"
						@click="updateready"
					>수정</button>
					<button type="button" class="btn btn-primary admin_request_btn_box"
						v-if="updateflg"
						@click="updateAnswer(now_data.id)"
					>답변</button>
					<button type="button" class="btn btn-secondary admin_request_btn_box"
						@click="closeModal"
					>취소</button>
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
					<div class="input-group mb-3"
						v-if="this.now_report.admin_flg === '3'"
					>
						<span class="input-group-text admin_report_span_to">제제일자</span>
						<div class="form-control" aria-label="With textarea">{{ modalReport.restraint_at }}</div>
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
					<div class="input-group mb-3">
						<span class="input-group-text admin_report_span_from">신고시간</span>
						<div class="form-control" aria-label="With textarea">{{ this.now_report.created_at }}</div>
					</div>
					<div class="input-group mb-4"
						v-if="this.now_report.admin_flg === '4'"
					>
						<span class="input-group-text admin_report_span_from">제재일자</span>
						<div class="form-control" aria-label="With textarea">{{ this.now_report.restraint_at }}</div>
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
						@click="keepdata(this.now_report.id,'2')"
						v-if="this.now_report.admin_flg === '0'"
					>게시글 유지</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning"
						v-if="this.now_report.admin_flg === '3'"
						@click="clearestraint(null,this.now_report.id)"
					>
						작성자 제재해제
					</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
						v-if="this.now_report.admin_flg !== '3'"
					>
						작성자 제재
					</button>	
					<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'0','0')">1일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'1','0')">3일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'2','0')">7일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'3','0')">15일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'4','0')">30일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'5','0')">영구제재</a></li>
					</ul>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning"
						v-if="this.now_report.admin_flg === '4'"
						@click="clearestraint(null,this.now_report.id)"
					>
						신고자 제재해제
					</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
						v-if="this.now_report.admin_flg !== '4'"
					>
						신고자 제재
					</button>
					<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'0','1')">1일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'1','1')">3일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'2','1')">7일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'3','1')">15일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'4','1')">30일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'5','1')">영구제재</a></li>
					</ul>
					<button type="button" class="btn btn-secondary" @click="closeModal">취소</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 등록 및 수정 -->
	<!-- 축제등록 -->
	<div v-if="mainflg===1&&subflg===0" class="admin_frame">
		<form class="row g-3 needs-validation admin_form" validate>
			<div>
				<div class="col-md-3 position-relative mb-3">
					<label for="validationTooltip04" class="form-label">등록위치</label>
					<select class="form-select" id="validationTooltip04" required v-model="admin_category" @change="resetall">
						<option value="0">축제</option>
						<option value="1">관광</option>
						<option value="2">(자유)공지</option>
						<option value="3">(정보)공지</option>
						<option value="4">(질문)공지</option>
						<option value="5">(건의)공지</option>
					</select>
				</div>
				<div class="input-group mb-1">
					<span class="input-group-text" id="basic-addon1">제목</span>
					<input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_title">
				</div>
				<div class="input-group mb-1">
					<span class="input-group-text">내용</span>
					<textarea class="form-control" aria-label="With textarea" v-model="admin_content"></textarea>
				</div>
				<div class="input-group mb-1" v-if="admin_category==='0'||admin_category==='1'">
					<span class="input-group-text" >주소</span>
					<input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_place">
				</div>
				<div class="input-group mb-3 align-items-center">
					<input id="admin_file_img1" class="form-control" type="file" accept="image/*">
					<input id="admin_file_img2" class="form-control" type="file" accept="image/*">
					<input id="admin_file_img3" class="form-control" type="file" accept="image/*">
				</div>
				<div class="input-group mb-3" v-if="admin_category==='0'||admin_category==='1'">
					<span class="input-group-text">지역</span>
					<select class="form-select" id="validationTooltip04" v-model="admin_ns">
						<option>경상북도</option>
						<option>경상남도</option>
					</select>
					<span class="input-group-text">시.군</span>
					<!-- 북도 -->
					<select class="form-select pointer" id="validationTooltip04" required v-model="admin_state_n" v-if="admin_ns==='경상북도'">
						<option>경산시</option>
						<option>경주시</option>
						<option>고령군</option>
						<option>구미시</option>
						<option>김천시</option>
						<option>문경시</option>
						<option>봉화군</option>
						<option>상주시</option>
						<option>성주군</option>
						<option>안동시</option>
						<option>영덕군</option>
						<option>영양군</option>
						<option>영주시</option>
						<option>영천시</option>
						<option>울릉군</option>
						<option>울진군</option>
						<option>의성군</option>
						<option>예천군</option>
						<option>청도군</option>
						<option>청송군</option>
						<option>칠곡군</option>
						<option>포항시</option>
					</select>
					<!-- 남도 -->
					<select class="form-select pointer" id="validationTooltip04" required v-model="admin_state_s" v-if="admin_ns==='경상남도'">			
						<option>거제시</option>
						<option>거창군</option>
						<option>고성군</option>
						<option>김해시</option>
						<option>남해군</option>
						<option>밀양시</option>
						<option>사천시</option>
						<option>산청군</option>
						<option>양산시</option>
						<option>의령군</option>
						<option>진주시</option>
						<option>창녕군</option>
						<option>창원시</option>
						<option>통영시</option>
						<option>하동군</option>
						<option>함안군</option>
						<option>함양군</option>
						<option>합천군</option>
					</select>
				</div>
				<div class="input-group mb-3" v-if="admin_category==='0'">
					<span class="input-group-text">축제기간</span>
					<input type="date" class="form-control" placeholder="축제시작 YYYY-MM-DD" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_start_f">
					<input type="date" class="form-control" placeholder="축제종료 YYYY-MM-DD" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_end_f">
				</div>
				<div class="input-group mb-3 d-flex justify-content-evenly" v-if="admin_category==='0'||admin_category==='1'">
					<div class="form-check form-switch">
						<input class="form-check-input pointer" type="checkbox" id="admin_parking" v-model="admin_chk_flg1">
						<label class="form-check-label pointer" for="admin_parking">주차가능 여부</label>
					</div>
					<div class="form-check form-switch">
						<input class="form-check-input pointer" type="checkbox" id="admin_couple" v-model="admin_chk_flg2">
						<label class="form-check-label pointer" for="admin_couple">커플 추천</label>
					</div>
					<div class="form-check form-switch">
						<input class="form-check-input pointer" type="checkbox" id="admin_friend" v-model="admin_chk_flg3">
						<label class="form-check-label pointer" for="admin_friend">친구 추천</label>
					</div>
					<div class="form-check form-switch">
						<input class="form-check-input pointer" type="checkbox" id="admin_family" v-model="admin_chk_flg4">
						<label class="form-check-label pointer" for="admin_family">가족 추천</label>
					</div>
				</div>
				<div class="input-group mb-3" v-if="admin_category==='0'||admin_category==='1'">
					<span class="input-group-text">입장료</span>
					<input type="text" class="form-control" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_fee">
					<span class="input-group-text">이용시간</span>
					<input type="text" class="form-control" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_time">
				</div>
				<div class="input-group mb-3" v-if="admin_category==='0'||admin_category==='1'">
					<span class="input-group-text">휴일</span>
					<input type="text" class="form-control" placeholder="미작성시 연중무휴" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_holiday">
					<span class="input-group-text">연락처</span>
					<input type="text" class="form-control" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_tel">
				</div>
			</div>
			<button type="button" class="btn btn-secondary" @click="insert_board">등록</button>
		</form>
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
	<!-- 통계페이지 -->
	<!-- 유저통계 -->
	<div v-if="mainflg===2&&subflg===0" class="admin_frame">
		<div>조회수 통계</div>
		<div>축제관광</div>
		<div class="admin_chart_flex center">
			<div class="admin_chart_line">
				<div>유저통계(%)</div>
				<Bar :data="u_chart1.data" :options="u_chart1.options" />
			</div>
		</div>
		<div class="admin_chart_flex center">
			<div>
				<div>한달간 유저 탈퇴 수</div>
				<Doughnut :data="u_chart2.data" :options="u_chart2.options" />
			</div>
			<div>
				<div>회원 탈퇴 사유 비율</div>
				<Doughnut :data="u_chart3.data" :options="u_chart3.options" />
			</div>
			<div>
				<div>유저들 주 활동 시간대</div>
				<Doughnut :data="u_chart4.data" :options="u_chart4.options" />
			</div>
		</div>
	</div>
	<!-- 조회수통계 -->
	<div v-if="mainflg===2&&subflg===1" class="admin_frame">
		<div>조회수 통계</div>
		<div>축제관광</div>
		<div class="admin_chart_flex center">
			<div>
				<div>테마별 평균 조회수</div>
				<Doughnut :data="h_chart1.data" :options="h_chart1.options" />
			</div>
			<div>
				<div>축제 관광 평균 조회수</div>
				<Doughnut :data="h_chart2.data" :options="h_chart2.options" />
			</div>
			<div>
				<div>북도 남도 평균 조회수</div>
				<Doughnut :data="h_chart3.data" :options="h_chart3.options" />
			</div>
		</div>
		<div class="admin_chart_flex center">
			<div>
				<div>북도에서 많이 조회된 5개의 (시,군)조회수 평균</div>
				<Doughnut :data="h_chart4.data" :options="h_chart4.options" />
			</div>
			<div>
				<div>남도에서 많이 조회된 5개의 (시,군)조회수 평균</div>
				<Doughnut :data="h_chart5.data" :options="h_chart5.options" />
			</div>
		</div>
	</div>
	<!-- 좋아요통계 -->
	<div v-if="mainflg===2&&subflg===2" class="admin_frame">
		<div>좋아요 통계</div>
		<div>축제관광</div>
		<div class="admin_chart_flex center">
			<div>
				<div>성비</div>
				<Doughnut :data="chart1.data" :options="chart1.options" />
			</div>
			<div>
				<div>축제 관광 비율</div>
				<Doughnut :data="chart2.data" :options="chart2.options" />
			</div>
		</div>
		<div class="admin_chart_flex center">
			<div>
				<div>나이 떄</div>
				<Doughnut :data="chart3.data" :options="chart3.options" />
			</div>
			<div>
				<div>좋아요가 많이눌린 플래그</div>
				<Doughnut :data="chart4.data" :options="chart4.options" />
			</div>
		</div>
		<hr>
		<div>커뮤니티</div>
		<div class="admin_chart_flex center">
			<div>
				<div>성비</div>
				<Doughnut :data="chart5.data" :options="chart5.options" />
			</div>
			<div>
				<div>커뮤 주제</div>
				<Doughnut :data="chart6.data" :options="chart6.options" />
			</div>
			<div>
				<div>커뮤 카테고리</div>
				<Doughnut :data="chart7.data" :options="chart7.options" />
			</div>
		</div>
	</div>
	<!-- 답변페이지 -->
	<div v-if="mainflg===3&&subflg===0" class="admin_frame">
		건의목록
		<div>
			처리전
		</div>
		<div class="row row-cols-1 row-cols-md-4 g-4">
			<div		
				v-if="Object.keys(this.requestdata_before).length === 0"
			>
				새로운 건의가 없습니다.
			</div>
			<div class="col" 
				v-for="data in requestdata_before" :key="data"
			>
				<div class="card">
					<div class="card-body pointer"
						@click="dataget(data)"
					>
						<div class="admin_report_card_header">
							<h5 class="card-title">건의내용</h5>
							<span :class="'admin_report_card_header_span0'">답변전</span>
						</div>
						<div class="card-text">유저번호 = {{ data.u_id }}</div>
						<div class="card-text">제목 = {{ data.title }}</div>
						<div class="card-text">내용 = {{ data.content }}</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div>
			처리완료
		</div>
		<div class="row row-cols-1 row-cols-md-4 g-4">
			<div		
				v-if="Object.keys(this.requestdata_after).length === 0"
			>
				답변한 건의가 없습니다.
			</div>
			<div class="col" 
				v-for="data in requestdata_after" :key="data"
			>
				<div class="card">
					<div class="card-body pointer"
						@click="dataget(data)"
					>
						<div class="admin_report_card_header">
							<h5 class="card-title">건의내용</h5>
							<span :class="'admin_report_card_header_span1'">답변후</span>
						</div>
						<div class="card-text">유저번호 = {{ data.u_id }}</div>
						<div class="card-text">제목 = {{ data.title }}</div>
						<div class="card-text">내용 = {{ data.content }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 신고페이지 -->
	<div v-if="mainflg===3&&subflg===1" class="admin_frame">
		신고목록
		<div>
			처리전
		</div>
		<div class="row row-cols-1 row-cols-md-4 g-4">
			<div		
				v-if="Object.keys(this.reportdata_before).length === 0"
			>
				신고된 내용이 없습니다.
			</div>
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
			<div
				v-if="Object.keys(this.reportdata_after).length === 0"
			>
				처리된 내용이 없습니다.
			</div>
			<div class="col" 
				v-for="data in reportdata_after" :key="data"
			>
				<div class="card">
					<div class="card-body pointer"
						@click="reportget(data)"
					>
						<div class="admin_report_card_header">
							<h5 class="card-title">신고한 유저{{data.id}}</h5>
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
	<!-- 유저관리페이지 -->
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
								@click="restraintuser(this.selectUserData.id,this.restraint_date,this.restraint_msg)"
							>적용</button>
						</div>
					</div>
				</div>
			</div>
			<div class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
				v-if="this.selectUserData.res_at < this.todaytime||this.selectUserData.cnt === 0"
			>유저제재</div>
			<div class="btn btn-danger btn-sm"
				@click="clearestraint(this.selectUserData.id,null)"
				v-if="this.selectUserData.res_at >= this.todaytime"
			>제제해제</div>
			<div class="btn btn-primary btn-sm" @click="resetall">확인</div>
		</div>
	</div>
</template>
<script>
import Swal from 'sweetalert2';

import {
	Chart as ChartJS,
	ArcElement,
	CategoryScale,
	BarElement,
	LinearScale,
	PointElement,
	LineElement,
	Title,
	Tooltip,
	Legend
} from 'chart.js'
import { Doughnut,Line,Bar  } from 'vue-chartjs'

ChartJS.register(
	ArcElement,
	CategoryScale,
	LinearScale,
	PointElement,
	BarElement,
	LineElement,
	Title,
	Tooltip,
	Legend
)

export default {
	name: 'AdminComponent',
	props: {

	},
	
	components: {
		Doughnut,Line,Bar,
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
			reportdata_before:{},
			reportdata_after:{},
			modalflg:false,
			updateflg:false,
			restraintinput:false,
			answer: "",
			selectUserData: {},
			likegender: {},
			likeage: {},
			liketag: {},
			likemain: {},
			likegender_c: {},
			likemain_c: {},
			likeflg: {},
			hit_flg: {},
			hit_main: {},
			hit_ns: {},
			hit_n: {},
			hit_s: {},
			u_gender1: {},
			u_gender2: {},
			inout: {},
			del_flg: {},
			u_time: {},
			requestdata_before:{},
			requestdata_after:{},
			admin_title:"",
			admin_content:"",
			admin_place:"",
			admin_img1:null,
			admin_img2:null,
			admin_img3:null,
			admin_ns:"경상북도",
			admin_state_n:"",
			admin_state_s:"",
			admin_start_f:"",
			admin_end_f:"",
			admin_chk_flg1:false,
			admin_chk_flg2:false,
			admin_chk_flg3:false,
			admin_chk_flg4:false,
			admin_category:"0",
			admin_fee:"",
			admin_time:"",
			admin_holiday:"",
			admin_tel:"",
			// 차트1 좋아요성비
			chart1:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666 ',"#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 차트2 좋아요축제관광
			chart2:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#66c2ff ',"#ff6666 "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 차트3 좋아요나이
			chart3:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#e75454',"#df995d","#ecdf55","#afec55","#5582ec","#2c20b0","#a824d0"],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 차트4 좋아요플래그
			chart4:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666',"#ffcc66 ","#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 차트5 커뮤니티좋아요성비
			chart5:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666 ',"#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 350, // 원하는 가로 크기
					height: 350, // 원하는 세로 크기
				},
			},
			// 차트6 커뮤니티 축제관광별 비율
			chart6:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666',"#ffcc66 ","#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 350, // 원하는 가로 크기
					height: 350, // 원하는 세로 크기
				},
			},
			// 차트7 커뮤니티 게시판별 비율
			chart7:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666',"#ffcc66 ","#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 350, // 원하는 가로 크기
					height: 350, // 원하는 세로 크기
				},
			},
			// 조회수 차트1 플래그
			h_chart1:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666',"#ffcc66 ","#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 조회수 차트2 축제관광
			h_chart2:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666',"#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 조회수 차트3 북도남도
			h_chart3:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#ff6666',"#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 조회수 차트4 북도인기5
			h_chart4:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#e75454',"#ecdf55","#afec55","#5582ec","#2c20b0"],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 조회수 차트5 남도 인기5
			h_chart5:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#e75454',"#ecdf55","#afec55","#5582ec","#2c20b0"],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			// 유저 성비 차트
			u_chart1:{
				data: {
					labels: [],
					datasets: [
					{
						label: '여성',
						borderColor: '#f87979',
						backgroundColor: 'rgba(248, 121, 121, 0.3)',
						data: [],
						fill: false,
					},
					{
						label: '남자',
						borderColor: '#65b2ff',
						backgroundColor: 'rgba(101, 178, 255, 0.3)',
						data: [],
						fill: false,
					}
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					// width: 1000, // 원하는 가로 크기
					// height: 400, // 원하는 세로 크기
				},
			},
			u_chart2:{
				data: {
					labels: ['회원유지','탈퇴'],
					datasets: [
						{
							backgroundColor: ['#ff6666',"#66c2ff "],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			u_chart3:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#e75454',"#ecdf55","#afec55","#5582ec","#2c20b0"],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
			u_chart4:{
				data: {
					labels: [],
					datasets: [
						{
							backgroundColor: ['#e75454',"#ecdf55","#afec55","#5582ec"],
							data: []
						}
					]
				},
				options: {
					responsive: false,
					maintainAspectRatio: false,
					width: 300, // 원하는 가로 크기
					height: 300, // 원하는 세로 크기
				},
			},
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
		this.statistics()
	},
	updated() {
		this.getToDayTime();
	},
	mounted() {
	
	},

	methods: {
		// 어드민체크
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
		// 로그아웃
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
			this.now_report.restraint_at = this.now_report.restraint_at === null ? "X":this.now_report.restraint_at;
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
				res.data.data.restraint_at = res.data.data.restraint_at === null ? "X":res.data.data.restraint_at;
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
			this.modalflg = false;
			this.updateflg = false;
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
						console.log('댄진입')
						if(this.mainflg===3&&this.subflg===0){
							console.log('질문게시판일떄')
							this.requestall();
						}else{
							this.adminchk();
						}
						this.answer="";
						this.closeModal();
						Swal.fire({
							icon: 'success',
							title: '완료',
							text: '정상처리되었습니다.',
							confirmButtonText: '확인'
						})
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
					console.log("정상진입")
					this.closeModal();
					if(this.mainflg===3&&this.subflg===1){
						if((this.reportdata_before.find(item => item.id === this.now_report.id && item.admin_flg === '3'))||(this.reportdata_after.find(item => item.id === this.now_report.id && item.admin_flg === '3'))){
							if(this.reportdata_before.find(item => item.id === this.now_report.id)){
								this.reportdata_before.find(item => item.id === this.now_report.id).admin_flg = '3';
							}else{
								this.reportdata_after.find(item => item.id === this.now_report.id).admin_flg = '3';
							}
						}else{
							if(this.reportdata_before.find(item => item.id === this.now_report.id)){
								this.reportdata_before.find(item => item.id === this.now_report.id).admin_flg = '1';
							}else{
								this.reportdata_after.find(item => item.id === this.now_report.id).admin_flg = '1';
							}
						}
					}else{
						console.log("엘스로")
						this.adminchk();
					}
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
		// 게시글유지
		keepdata(id,flg){
			this.$store.commit('setLoading',true);
			const formData = new FormData();
			formData.append('id', id);
			formData.append('flg', flg);
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
			if(main===3,sub===0){
				this.requestall()
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
		restraintuser(u_id,date,msg){
			if(date ===""){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '제재기간을 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else if(msg ===""||(msg === "기타"&&this.restraint_msg2 === "")){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '제재사유를 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else{
				this.$store.commit('setLoading',true);
				if(msg === "기타"){
					msg = this.restraint_msg2
				}
				const URL = '/admin/userinfo'
				const formData = new FormData();
				formData.append('id', id);
				formData.append('u_id', u_id);
				formData.append('date', date);
				formData.append('msg', msg);
				axios.post(URL,formData)
				.then(res => {
					if(res.data.code === "0"){
						document.querySelector('.admin_boot_modal_close').click();
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
		clearestraint(u_id,id){
			this.$store.commit('setLoading',true);
			const URL = '/admin/restraint'
			const formData = new FormData();
			if(u_id === null){
				formData.append('id', id);
			}else{
				formData.append('u_id', u_id);
			}
			axios.post(URL,formData)
			.then(res => {
				if(res.data.code === "0"){
					this.resetall()
					if(u_id===null){
						this.keepdata(id,'2')
					}else{
						Swal.fire({
							icon: 'success',
							title: '완료',
							text: '정상처리되었습니다.',
							confirmButtonText: '확인'
						})
					}
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
		// 신고데이터 10개불러오기
		reportall(){
			this.$store.commit('setLoading',true);
			const URL = '/admin/reportall'
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.reportdata_before = res.data.data_before;
					this.reportdata_before_cnt = res.data.b_cnt;
					this.reportdata_after = res.data.data_after;
					this.reportdata_after = res.data.a_cnt;
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
				if(this.mainflg===3&&this.subflg===1){
					if((this.reportdata_before.find(item => item.id === this.now_report.id && item.admin_flg === '3'))||(this.reportdata_after.find(item => item.id === this.now_report.id && item.admin_flg === '3'))){
						if(this.reportdata_before.find(item => item.id === this.now_report.id)){
							this.reportdata_before.find(item => item.id === this.now_report.id).admin_flg = '3';
						}else{
							this.reportdata_after.find(item => item.id === this.now_report.id).admin_flg = '3';
						}
					}else{
						if(this.reportdata_before.find(item => item.id === this.now_report.id)){
							this.reportdata_before.find(item => item.id === this.now_report.id).admin_flg = '2';
						}else{
							this.reportdata_after.find(item => item.id === this.now_report.id).admin_flg = '2';
						}
					}
				}
				this.closeModal();
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
		// 모달유저제재
		modalRestraintuser(id,u_id,flg,user){
			let to=['작성자 재제','신고자 제제']
			let date=['1일','3일','7일','15일','30일','영구제제']
			Swal.fire({
				title: to[user],
				text: '유저번호 : '+u_id+'\n'+'재제사유 : '+date[flg],
				input: 'select',
				inputOptions: {
					'욕설 및 혐오 표현': '욕설 및 혐오 표현',
					'불법 콘텐츠 게시': '불법 콘텐츠 게시',
					'스팸 활동': '스팸 활동',
					'악성 행위 및 고의적인 피해': '악성 행위 및 고의적인 피해',
					'기타': '기타',
				},
				inputPlaceholder: '선택해주세요',
				showCancelButton: true,
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				preConfirm: (input) => {
					// 공백입력시 예외사항
					return new Promise((resolve) => {
						if (input.trim() === '') {
							Swal.showValidationMessage('답변을 입력해 주세요.');
						}
						resolve(input);
					});
				}
			})
			.then((result) => {
				if (result.isConfirmed) {
					// 사용자가 확인을 눌렀을 때의 동작
					const val = result.value;	
					if(val==="기타"){
						Swal.fire({
							title: '제재사유',
							input: 'text',
							inputPlaceholder: '20자 이내로 작성해 주세요',
							showCancelButton: true,
							confirmButtonText: '확인',
							cancelButtonText: '취소',
							preConfirm: (input) => {
								// 공백입력시 예외사항
								return new Promise((resolve) => {
									if (input.trim() === '') {
										Swal.showValidationMessage('답변을 입력해 주세요.');
									}
									resolve(input);
								});
							}
						})
						.then((result) => {
							if (result.isConfirmed) {
								const val = result.value;
								const URL = '/admin/userinfo'
								const formData = new FormData();
								formData.append('id', id);
								formData.append('u_id', u_id);
								formData.append('date', flg);
								formData.append('msg', val);
								axios.post(URL,formData)
								.then(res => {
									if(res.data.code === "0"){
										if(user==="0"){
											this.keepdata(this.now_report.id,'3')
										}else{
											this.keepdata(this.now_report.id,'4')
										}
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
							}					
						})
					}else{
						const val = result.value;
						const URL = '/admin/userinfo'
						const formData = new FormData();
						formData.append('id', id);
						formData.append('u_id', u_id);
						formData.append('date', flg);
						formData.append('msg', val);
						axios.post(URL,formData)
						.then(res => {
							if(res.data.code === "0"){
								if(user==="0"){
									this.keepdata(this.now_report.id,'3')
								}else{
									this.keepdata(this.now_report.id,'4')
								}
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
					}
				}
			});
		},
		// 전체건의 불러오기
		requestall(){
			this.$store.commit('setLoading',true);
			const URL = '/admin/requestall'
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.requestdata_before = res.data.data_before;
					this.requestdata_after = res.data.data_after;
					// this.requestdata_before = res.data.data.filter(item => item.admin_flg === "0");
					// this.requestdata_after = res.data.data.filter(item => item.admin_flg !== "0");
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
		// 답변수정준비
		updateready(){
			let input = document.querySelector('#admin_request_textarea')
				input.removeAttribute('readonly');
			this.updateflg = true;
		},
		// 답변수정
		updateAnswer(id){
			this.$store.commit('setLoading',true);
			let input = document.querySelector('#admin_request_textarea')
			const URL = '/admin/data'
			// 풋일때 형태
			const formData = {
				id: id,
				replie: input.value
			};
			axios.put(URL,formData)
			.then(res => {
				if(res.data.code === "0"){
					// 이렇게 하면 안됨;;;;;;;
					// input.setAttribute('readonly');
					input.readOnly = true;
					this.updateflg = false;
					this.requestdata_after.find(item => item.id === id).replie = input.value;
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					})
				}
			})
			.catch(err => {
				console.log("캐치")
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
		// 좋아요통계가져오기
		statistics(){
			this.$store.commit('setLoading',true);
			const URL = '/admin/statistics'
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					// 성별
					this.likegender = res.data.gender;	
					for(let i = 0; i < this.likegender.length; i++){
						this.chart1.data.labels[i] = this.likegender[i].gender==='M'?'남성':'여성';
						this.chart1.data.datasets[0].data[i]=this.likegender[i].cnt;
					}
					// 축제관광
					this.likemain = res.data.main;	
					for(let i = 0; i < this.likemain.length; i++){
						this.chart2.data.labels[i] = this.likemain[i].main_flg==='축제'?'축제':'관광';
						this.chart2.data.datasets[0].data[i]=this.likemain[i].cnt;
					}
					// 좋아요나이
					this.likeage = res.data.age;	
					for(let i = 0; i < this.likeage.length; i++){
						this.chart3.data.labels[i] = this.likeage[i].age;
						this.chart3.data.datasets[0].data[i]=this.likeage[i].cnt;
					}
					// 추천플래그
					this.liketag = res.data.tag;	
					for(let i = 0; i < this.liketag.length; i++){
						if (this.liketag[i].type === "couple_flg") {
							this.liketag[i].type = "커플추천";
						} else if (this.liketag[i].type === "friend_flg") {
							this.liketag[i].type = "친구추천";
						} else if (this.liketag[i].type === "family_flg") {
							this.liketag[i].type = "가족추천";
						}
						this.chart4.data.labels[i] = this.liketag[i].type;
						this.chart4.data.datasets[0].data[i]=this.liketag[i].cnt;
					}
					// 커뮤 성별
					this.likegender_c = res.data.gender1;	
					for(let i = 0; i < this.likegender_c.length; i++){
						this.chart5.data.labels[i] = this.likegender_c[i].gender==='M'?'남성':'여성';
						this.chart5.data.datasets[0].data[i]=this.likegender_c[i].cnt;
					}
					// 커뮤 테마
					this.likemain_c = res.data.main1;	
					for(let i = 0; i < this.likemain_c.length; i++){
						if (this.likemain_c[i].type === "0") {
							this.likemain_c[i].type = "축제";
						} else if (this.likemain_c[i].type === "1") {
							this.likemain_c[i].type = "관광";
						} else if (this.likemain_c[i].type === "2") {
							this.likemain_c[i].type = "기타";
						}
						this.chart6.data.labels[i] = this.likemain_c[i].type;
						this.chart6.data.datasets[0].data[i]=this.likemain_c[i].cnt;
					}
					// 커뮤 게시판
					this.likeflg = res.data.flg;	
					for(let i = 0; i < this.likeflg.length; i++){
						if (this.likeflg[i].type === "0") {
							this.likeflg[i].type = "자유게시판";
						} else if (this.likeflg[i].type === "1") {
							this.likeflg[i].type = "정보게시판";
						} else if (this.likeflg[i].type === "2") {
							this.likeflg[i].type = "질문게시판";
						}
						this.chart7.data.labels[i] = this.likeflg[i].type;
						this.chart7.data.datasets[0].data[i]=this.likeflg[i].cnt;
					}
					// 여기서부터 조회수
					// 조회수 플래그
					this.hit_flg = res.data.hit_flg;	
					for(let i = 0; i < this.hit_flg.length; i++){
						if (this.hit_flg[i].type === "couple_flg") {
							this.hit_flg[i].type = "커플추천";
						} else if (this.hit_flg[i].type === "friend_flg") {
							this.hit_flg[i].type = "친구추천";
						} else if (this.hit_flg[i].type === "family_flg") {
							this.hit_flg[i].type = "가족추천";
						}
						this.h_chart1.data.labels[i] = this.hit_flg[i].type;
						this.h_chart1.data.datasets[0].data[i]=this.hit_flg[i].cnt;
					}
					console.log("통과1")
					// 조회수 축제관광
					this.hit_main = res.data.hit_main;	
					for(let i = 0; i < this.hit_main.length; i++){
						this.h_chart2.data.labels[i] = this.hit_main[i].type;
						this.h_chart2.data.datasets[0].data[i]=this.hit_main[i].cnt;
					};
					console.log("통과2")
					// 조회수 ns
					this.hit_ns = res.data.hit_ns;	
					for(let i = 0; i < this.hit_ns.length; i++){
						this.h_chart3.data.labels[i] = this.hit_ns[i].type;
						this.h_chart3.data.datasets[0].data[i]=this.hit_ns[i].cnt;
					}
					// 조회수 n top5
					this.hit_n = res.data.hit_n;	
					for(let i = 0; i < this.hit_n.length; i++){
						this.h_chart4.data.labels[i] = this.hit_n[i].type;
						this.h_chart4.data.datasets[0].data[i]=this.hit_n[i].cnt;
					}
					// 조회수 s top5
					this.hit_s = res.data.hit_s;	
					for(let i = 0; i < this.hit_s.length; i++){
						this.h_chart5.data.labels[i] = this.hit_s[i].type;
						this.h_chart5.data.datasets[0].data[i]=this.hit_s[i].cnt;
					}

					// 여기서부터 유저
					// 유저 가입통계
					this.u_gender1 = res.data.u_gender.filter(item => item.type === "F");
					this.u_gender2 = res.data.u_gender.filter(item => item.type === "M");
					for (let i = 0; i < this.u_gender1.length; i++) {
					this.u_chart1.data.labels[i] = this.u_gender1[i].age;
					this.u_chart1.data.datasets[0].data[i] = this.u_gender1[i].per;
					}
					for (let i = 0; i < this.u_gender2.length; i++) {
					this.u_chart1.data.datasets[1].data[i] = this.u_gender2[i].per;
					}
					// 유저 한달갈 탈퇴율
					this.inout = res.data.inout;	
					for(let i = 0; i < this.inout.length; i++){
						this.u_chart2.data.datasets[0].data[i]=this.inout[i].cnt;
					}
					// 유저 탈퇴사유 빈도
					this.del_flg = res.data.del_flg;	
					for(let i = 0; i < this.del_flg.length; i++){
						this.u_chart3.data.labels[i] = this.del_flg[i].type;
						this.u_chart3.data.datasets[0].data[i]=this.del_flg[i].per;
					}
					// 유저 활동시간
					this.u_time = res.data.u_time;	
					for(let i = 0; i < this.u_time.length; i++){
						this.u_chart4.data.labels[i] = this.u_time[i].time;
						this.u_chart4.data.datasets[0].data[i]=this.u_time[i].per;
					}
				}
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '에러 발생.',
                    confirmButtonText: '확인'
                });
				console.log(err);
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 이미지등록시 데이터 바인딩
		// imgchk(img) {
		// 	let nowimg = img.target.files[0];
		// 	if (img.target === this.$refs.fileInput1) {
		// 	this.admin_img1 = nowimg;
		// 	} else if (img.target === this.$refs.fileInput2) {
		// 	this.admin_img2 = nowimg;
		// 	} else if (img.target === this.$refs.fileInput3) {
		// 	this.admin_img3 = nowimg;
		// 	}
		// },
		// 초기화용함수
		resetall(){
			console.log("초기화함수")
			this.restraint_msg= "";
			this.restraint_msg2= "";
			this.restraint_date= "";
			this.searchval= "";
			this.searchtype= "유저번호";
			this.searchflg=false;
			this.modalflg=false;
			this.restraintinput=false;
			this.answer="";
			this.admin_title="";
			this.admin_content="";
			this.admin_place="";
			this.admin_img1= new FileReader();
			this.admin_img2=null;
			this.admin_img3=null;
			this.admin_state_n="";
			this.admin_state_s="";
			this.admin_start_f="";
			this.admin_end_f="";
			this.admin_chk_flg1=false;
			this.admin_chk_flg2=false;
			this.admin_chk_flg3=false;
			this.admin_chk_flg4=false;
			let img1 = document.querySelector('#admin_file_img1');
			img1.value = ""; 
			let img2 = document.querySelector('#admin_file_img2');
			img2.value = ""; 
			let img3 = document.querySelector('#admin_file_img3');
			img3.value = ""; 
			this.admin_fee="";
			this.admin_time="";
			this.admin_holiday="";
			this.admin_tel="";
		},
		// 게시글 추가
		insert_board(){
			// 빈값 방어
			if(this.admin_category==="0"){
				if(this.admin_title===""||this.admin_content===""||this.admin_place===""||this.admin_start_f===""||this.admin_end_f===""||(this.admin_start_f > this.admin_end_f)||(this.admin_ns==="경상남도"&&this.admin_state_s==="")||(this.admin_ns==="경상북도"&&this.admin_state_n==="")){
					if(this.admin_place===""){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '주소를 입력해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}else if((this.admin_ns==="경상남도"&&this.admin_state_s==="")||(this.admin_ns==="경상북도"&&this.admin_state_n==="")){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '시.군을 선택해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}else if(this.admin_start_f===""||this.admin_end_f===""){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '축제기간을 입력해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}else if(this.admin_start_f > this.admin_end_f){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '축제시작일이 축제종료일 보다 미래 입니다.',
							confirmButtonText: '확인'
						})
						return;
					}else if(this.admin_title === ""){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '제목을 입력해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}else if(this.admin_content === ""){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '내용을 입력해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}
				}
			}else if(this.admin_category==="1"){
				if(this.admin_title===""||this.admin_content===""||this.admin_place===""||this.admin_ns==="경상남도"&&this.admin_state_s===""||this.admin_ns==="경상북도"&&this.admin_state_n===""){
					if(this.admin_place===""){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '주소를 입력해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}else if((this.admin_ns==="경상남도"&&this.admin_state_s==="")||(this.admin_ns==="경상북도"&&this.admin_state_n==="")){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '시.군을 선택해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}else if(this.admin_title === ""){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '제목을 입력해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}else if(this.admin_content === ""){
						Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '내용을 입력해 주세요.',
							confirmButtonText: '확인'
						})
						return;
					}
				}
			}else{
				if(this.admin_title === ""){
					Swal.fire({
						icon: 'warning',
						title: '주의',
						text: '제목을 입력해 주세요.',
						confirmButtonText: '확인'
					})
					return;
				}else if((this.admin_content === "")){
					Swal.fire({
							icon: 'warning',
							title: '주의',
							text: '내용을 입력해 주세요.',
							confirmButtonText: '확인'
						})
					return;
				}
			};
			let img1 = document.querySelector('#admin_file_img1');
			let img2 = document.querySelector('#admin_file_img2');
			let img3 = document.querySelector('#admin_file_img3');
			this.$store.commit('setLoading', true);
			const URL = '/admin/board'
			const formData = new FormData();
				formData.append('main_flg',this.admin_category);
				formData.append('title',this.admin_title);
				formData.append('content',this.admin_content);
				console.log( img1.files[0])
				console.log( img2.files[0])
				console.log( img3.files[0])
				formData.append('img1', img1.files[0]);
				formData.append('img2', img2.files[0]);
				formData.append('img3', img3.files[0]);
			if(this.admin_category==="0"){
				formData.append('start_at',this.admin_start_f);
				formData.append('end_at',this.admin_end_f);
			}
			if(this.admin_category==="0"||this.admin_category==="1"){
				if(this.admin_chk_flg1){
					formData.append('parking_flg','1');
				}
				if(this.admin_chk_flg2){
					formData.append('couple_flg','1');
				}
				if(this.admin_chk_flg3){
					formData.append('friend_flg','1');
				}
				if(this.admin_chk_flg4){
					formData.append('family_flg','1');
				}
				formData.append('place',this.admin_place);
				formData.append('ns_flg',this.admin_ns);
				if(this.admin_ns==="경상북도"){
					formData.append('states_name',this.admin_state_n);
					console.log(this.admin_state_n);
				}else{
					formData.append('states_name',this.admin_state_s);
				}
				formData.append('fee',this.admin_fee);
				formData.append('time',this.admin_time);
				formData.append('holiday',this.admin_holiday);
				formData.append('tell',this.admin_tel);
			}
			axios.post(URL,formData)
			.then(res => {
				if(res.data.code==="0"){
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
			})
		},
	}
}
</script>