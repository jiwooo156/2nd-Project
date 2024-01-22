<template>
	<!-- 헤더 -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top p-3">
		<div class="container-fluid">
			<router-link to="/admin" @click="flgchg(0,0)" class="admin_header_left_a">이의이승관리자</router-link>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-control font_air bolds="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle font_air bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							등록&조회
						</a>
						<ul class="dropdown-menu">
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(1,0)">게시글 등록</div></li>
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(3,2)">유저 조회</div></li>
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(1,1)">게시물 조회</div></li>
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(1,2)">댓글 조회</div></li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle font_air bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							통계
						</a>
						<ul class="dropdown-menu">
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(2,0)">유저</div></li>
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(2,1)">조회수</div></li>
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(2,2)">좋아요</div></li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle font_air bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							신고&건의
						</a>
						<ul class="dropdown-menu">
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(3,0)">건의답변</div></li>
							<li><div class="dropdown-item pointer font_air bold" @click="flgchg(3,1)">신고목록</div></li>
						</ul>
					</li>
				</ul>
				<router-link to="/main" class="admin_header_right_a font_air bold">메인으로</router-link>
				<div
					class="pointer font_air bold"
					@click="logout"
				>로그아웃</div>
			</div>
		</div>
	</nav>
	<!-- 메인 -->
	<div class="admin_frame" v-if="mainflg===0">
		<h1 class="center">이의이승관리자 페이지</h1>
		<div class="admin_container">
			<div class="admin_container_box1">
				<div class=" admin_container_box1_content admin_container1">
					<div class="admin_container_box1_1">
						<span class=" font_air bold">오늘의 가입수</span>
						<div class=" font_air bold">{{ this.sign_cnt }} 명</div>
					</div>	
					<div class="admin_container_box1_2 font_air bold">
						<span class=" font_air bold">오늘의 탈퇴수</span>
						<div class=" font_air bold">{{ this.drop_cnt }} 명</div>
					</div>	
					<div class="admin_container_box1_3 font_air bold pointer"  @click="flgchg(3,0)">
						<span class=" font_air bold">미 답변 건의</span>
						<div class=" font_air bold">{{ this.d_cnt }}건</div>
					</div>	
					<div class="admin_container_box1_4 font_air bold pointer"  @click="flgchg(3,1)">
						<span class=" font_air bold">신규 신고</span>
						<div class=" font_air bold">{{ this.r_cnt }}건</div>
					</div>
				</div>	
			</div>
			<div class="admin_container_box2">
				<div class="font_air bold">유저동향</div>
				<Line v-if="chart_flg" :data="main_chart.data" :options="main_chart.options" />
				<Line v-if="!chart_flg" :data="main_chart.data" :options="main_chart.options" />
			</div>
			<div class="admin_container_box3">
				<div class="font_air bold admin_main_chart2_flex">					
					<div class="font_air bold">유저활동내역</div>
					<select class="form-select pointer" id="validationTooltip04" required v-model="main_chart_type" @change="mainchartget">
						<option value="0" class=" font_air bold pointer">1주일</option>
						<option value="1" class=" font_air bold pointer">1개월</option>
						<option value="2" class=" font_air bold pointer">6개월</option>
						<option value="3" class=" font_air bold pointer">1년</option>
					</select>
				</div>
				<Bar v-if="chart_flg1" :data="main_chart1.data" :options="main_chart1.options" />
				<Bar v-if="!chart_flg1" :data="main_chart1_b.data" :options="main_chart1.options" />
			</div>
			<div class="admin_container_box4">
				<div>
					<div class="font_air bold">간편공지등록</div>
					<select class="form-select font_air bold pointer" id="validationTooltip04" required v-model="main_input">
						<option value="0" class=" font_air bold pointer">자유</option>
						<option value="1" class=" font_air bold pointer">정보</option>
						<option value="2" class=" font_air bold pointer">질문</option>
						<option value="3" class=" font_air bold pointer">건의</option>
					</select>
				</div>		
				<div>
					<div class="input-group mb-1">
						<span class="input-group-text font_air bold" id="basic-addon1">제목</span>
						<input type="text" class="form-control font_air bold font_air bold" aria-label="Username" aria-describedby="basic-addon1" v-model="main_title">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text font_air bold">내용</span>
						<textarea class="form-control font_air bold font_air bold" aria-label="With textarea" v-model="main_content"></textarea>
					</div>
				</div>
				<button type="button" class="btn btn-secondary font_air bold" @click="addnotice">등록</button>
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
						<span class="input-group-text">작성자번호</span>
						<div aria-label="First name" class="form-control font_air bold">
							{{ now_data.u_id }}
						</div>
						<span class="input-group-text">Email</span>
						<div aria-label="Last name" class="form-control font_air bold">
							{{ now_data.email }}
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-text" id="inputGroup-sizing-default">번호</span>
						<div class="form-control font_air bold" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
							{{ now_data.id }}
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-text" id="inputGroup-sizing-default">제목</span>
						<div class="form-control font_air bold" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
							{{ now_data.title }}
						</div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">내용</span>
						<textarea class="form-control font_air bold admin_request_textarea" aria-label="With textarea" readonly style="background-color: #fff;">{{ now_data.content }}</textarea>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">작성시간</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ now_data.created_at }}</div>
					</div>
				</div>
				<div class="input-group mb-3"
					v-if="now_data.admin_flg==='0'"
				>
					<span class="input-group-text">답변</span>
					<textarea class="form-control font_air bold" aria-label="With textarea"
						v-model="answer"
						placeholder="최대 200글자까지 작성 가능합니다"
						@input="koreaName"
						@keyup.enter="adminAnswer(now_data.id,now_data.email)"
					></textarea>
				</div>
				<div class="input-group mb-3"
					v-if="now_data.admin_flg==='1'"
				>
					<span class="input-group-text">답변내용</span>
					<textarea class="form-control font_air bold admin_request_textarea" id="admin_request_textarea" aria-label="With textarea"
						readonly
					>{{ now_data.replie }}</textarea>
				</div>
				<div class="center">
					<button type="button" class="btn btn-primary admin_request_btn_box"
						v-if="now_data.admin_flg==='0'"
						@click="adminAnswer(now_data.id,now_data.email)"
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
						<span class="input-group-text admin_report_span_to">작성자번호</span>
						<div aria-label="First name" class="form-control font_air bold">
							{{ modalReport.u_id }}
						</div>
						<span class="input-group-text admin_report_span_to">Email</span>
						<div aria-label="Last name" class="form-control font_air bold">
							{{ modalReport.email }}
						</div>
					</div>
					<div class="input-group mb-3" 
						v-if="this.now_report.flg==='1'"
					>
						<span class="input-group-text admin_report_span_to">내용</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ modalReport.replie }}</div>
					</div>
					<div
						v-if="this.now_report.flg==='0'"
					>
						<div class="input-group">
							<span class="input-group-text admin_report_span_to" id="inputGroup-sizing-default">작성위치</span>
							<div class="form-control font_air bold" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
								{{ modalReport.flg }}
							</div>
						</div>
						<div class="input-group">
							<span class="input-group-text admin_report_span_to" id="inputGroup-sizing-default">제목</span>
							<div class="form-control font_air bold" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
								{{ modalReport.title }}
							</div>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text admin_report_span_to">내용</span>
							<div class="form-control font_air bold" aria-label="With textarea">{{ modalReport.content }}</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text admin_report_span_to">작성시간</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ modalReport.created_at }}</div>
						<span class="input-group-text admin_report_span_to">삭제일자</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ modalReport.deleted_at }}</div>
					</div>
					<div class="input-group mb-3"
						v-if="this.now_report.admin_flg === '3'"
					>
						<span class="input-group-text admin_report_span_to">제재일자</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ modalReport.restraint_at }}</div>
					</div>
				</div>
				<hr>
				<div>
					<div class="admin_modal_title">신고자</div>
					<div class="input-group">
						<span class="input-group-text admin_report_span_from">작성자번호</span>
						<div aria-label="First name" class="form-control font_air bold">
							{{ this.now_report.u_id }}
						</div>
						<span class="input-group-text admin_report_span_from">Email</span>
						<div aria-label="Last name" class="form-control font_air bold">
							{{ this.now_report.email }}
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-text admin_report_span_from">신고사유</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ this.now_report.content }}</div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text admin_report_span_from">신고시간</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ this.now_report.created_at }}</div>
					</div>
					<div class="input-group mb-4"
						v-if="this.now_report.admin_flg === '4'"
					>
						<span class="input-group-text admin_report_span_from">제재일자</span>
						<div class="form-control font_air bold" aria-label="With textarea">{{ this.now_report.restraint_at }}</div>
					</div>
				</div>
				<div class="admin_modal_btn_box">
					<button type="button" class="btn btn-danger" 
						@click="delreplie(modalReport.id,now_report.flg)" 
						v-if="modalReport.deleted_at === 'X'"
					>{{ reportarr1[this.now_report.flg]}} 삭제</button>
					<button type="button" class="btn btn-danger"
						@click="repairreplie(modalReport.id,now_report.flg)" 
						v-if="modalReport.deleted_at !== 'X'&&this.now_report.admin_flg !== '0'"
					>{{ reportarr1[this.now_report.flg]}} 복구</button>
					<button type="button" class="btn btn-primary"
						@click="keepdata(this.now_report.id,'2')"
						v-if="this.now_report.admin_flg === '0'"
					>{{ reportarr1[this.now_report.flg]}} 유지</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning"
						v-if="this.now_report.admin_flg === '3'"
						@click="clearestraint(null,this.now_report.id)"
					>
						작성자 재제해제
					</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
						v-if="this.now_report.admin_flg !== '3'"
					>
						작성자 재제
					</button>	
					<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'0','0')">1일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'1','0')">3일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'2','0')">7일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'3','0')">15일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'4','0')">30일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.modalReport.u_id,'5','0')">영구재제</a></li>
					</ul>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning"
						v-if="this.now_report.admin_flg === '4'"
						@click="clearestraint(null,this.now_report.id)"
					>
						신고자 재제해제
					</button>
					<button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
						v-if="this.now_report.admin_flg !== '4'"
					>
						신고자 재제
					</button>
					<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'0','1')">1일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'1','1')">3일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'2','1')">7일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'3','1')">15일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'4','1')">30일</a></li>
						<li><a class="dropdown-item" href="#" @click="modalRestraintuser(this.now_report.id,this.now_report.u_id,'5','1')">영구재제</a></li>
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
				<div class="col-md-3 position-relative mb-3 admin_insert_select">
					<label for="validationTooltip04" class="form-label font_air bold pointer">등록위치</label>
					<select class="form-select font_air bold pointer" id="validationTooltip04" required v-model="admin_category" @change="resetall">
						<option value="0" class="font_air bold pointer">축제</option>
						<option value="1" class="font_air bold pointer">관광</option>
						<option value="2" class="font_air bold pointer">(자유)공지</option>
						<option value="3" class="font_air bold pointer">(정보)공지</option>
						<option value="4" class="font_air bold pointer">(질문)공지</option>
						<option value="5" class="font_air bold pointer">(건의)공지</option>
					</select>
				</div>
				<div class="input-group mb-1">
					<span class="input-group-text" id="basic-addon1">제목</span>
					<input type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_title">
				</div>
				<div class="input-group mb-1">
					<span class="input-group-text">내용</span>
					<textarea class="form-control font_air bold" aria-label="With textarea" v-model="admin_content"></textarea>
				</div>
				<div class="input-group mb-1" v-if="admin_category==='0'||admin_category==='1'">
					<span class="input-group-text" >주소</span>
					<input type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_place">
				</div>
				<div class="input-group mb-3 align-items-center">
					<input id="admin_file_img1" class="form-control font_air bold" type="file" accept="image/*">
					<input id="admin_file_img2" class="form-control font_air bold" type="file" accept="image/*">
					<input id="admin_file_img3" class="form-control font_air bold" type="file" accept="image/*">
				</div>
				<div class="input-group mb-3" v-if="admin_category==='0'||admin_category==='1'">
					<span class="input-group-text">지역</span>
					<select class="form-select font_air bold pointer" id="validationTooltip04" v-model="admin_ns">
						<option class="font_air bold pointer">경상북도</option>
						<option class="font_air bold pointer">경상남도</option>
					</select>
					<span class="input-group-text">시.군</span>
					<!-- 북도 -->
					<select class="form-select font_air bold pointer" id="validationTooltip04" required v-model="admin_state_n" v-if="admin_ns==='경상북도'">
						<option class="font_air bold pointer">경산시</option>
						<option class="font_air bold pointer">경주시</option>
						<option class="font_air bold pointer">고령군</option>
						<option class="font_air bold pointer">구미시</option>
						<option class="font_air bold pointer">김천시</option>
						<option class="font_air bold pointer">문경시</option>
						<option class="font_air bold pointer">봉화군</option>
						<option class="font_air bold pointer">상주시</option>
						<option class="font_air bold pointer">성주군</option>
						<option class="font_air bold pointer">안동시</option>
						<option class="font_air bold pointer">영덕군</option>
						<option class="font_air bold pointer">영양군</option>
						<option class="font_air bold pointer">영주시</option>
						<option class="font_air bold pointer">영천시</option>
						<option class="font_air bold pointer">울릉군</option>
						<option class="font_air bold pointer">울진군</option>
						<option class="font_air bold pointer">의성군</option>
						<option class="font_air bold pointer">예천군</option>
						<option class="font_air bold pointer">청도군</option>
						<option class="font_air bold pointer">청송군</option>
						<option class="font_air bold pointer">칠곡군</option>
						<option class="font_air bold pointer">포항시</option>
					</select>
					<!-- 남도 -->
					<select class="form-select pointer" id="validationTooltip04" required v-model="admin_state_s" v-if="admin_ns==='경상남도'">			
						<option class="font_air bold pointer">거제시</option>
						<option class="font_air bold pointer">거창군</option>
						<option class="font_air bold pointer">고성군</option>
						<option class="font_air bold pointer">김해시</option>
						<option class="font_air bold pointer">남해군</option>
						<option class="font_air bold pointer">밀양시</option>
						<option class="font_air bold pointer">사천시</option>
						<option class="font_air bold pointer">산청군</option>
						<option class="font_air bold pointer">양산시</option>
						<option class="font_air bold pointer">의령군</option>
						<option class="font_air bold pointer">진주시</option>
						<option class="font_air bold pointer">창녕군</option>
						<option class="font_air bold pointer">창원시</option>
						<option class="font_air bold pointer">통영시</option>
						<option class="font_air bold pointer">하동군</option>
						<option class="font_air bold pointer">함안군</option>
						<option class="font_air bold pointer">함양군</option>
						<option class="font_air bold pointer">합천군</option>
					</select>
				</div>
				<div class="input-group mb-3" v-if="admin_category==='0'">
					<span class="input-group-text">축제기간</span>
					<input type="date" class="form-control font_air bold" placeholder="축제시작 YYYY-MM-DD" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_start_f">
					<input type="date" class="form-control font_air bold" placeholder="축제종료 YYYY-MM-DD" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_end_f">
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
					<input type="text" class="form-control font_air bold" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_fee">
					<span class="input-group-text">이용시간</span>
					<input type="text" class="form-control font_air bold" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_time">
				</div>
				<div class="input-group mb-3" v-if="admin_category==='0'||admin_category==='1'">
					<span class="input-group-text">휴일</span>
					<input type="text" class="form-control font_air bold" placeholder="미작성시 연중무휴" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_holiday">
					<span class="input-group-text">연락처</span>
					<input type="text" class="form-control font_air bold" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="admin_tel">
				</div>
			</div>
			<button type="button" class="btn btn-secondary" @click="insert_board">등록</button>
		</form>
	</div>
	<!-- 게시글 조회 -->
	<div v-if="mainflg===1&&subflg===1" class="admin_frame">
		<div class="admin_board_header">
			<div class="col-md-3 position-relative mb-4 admin_board_header1">
				<label for="validationTooltip04" class="form-label font_air bold pointer">등록위치</label>
				<select class="form-select font_air bold pointer" id="validationTooltip04" required v-model="admin_board_cate" @change="get_board(1)">
					<option value="0" class="font_air bold pointer">전체</option>
					<option value="1" class="font_air bold pointer">축제</option>
					<option value="2" class="font_air bold pointer">관광</option>
					<option value="3" class="font_air bold pointer">자유</option>
					<option value="4" class="font_air bold pointer">정보</option>
					<option value="5" class="font_air bold pointer">질문</option>
					<option value="6" class="font_air bold pointer">건의</option>
				</select>
			</div>
			<div class="admin_board_header2">
				<select class="form-select font_air bold pointer" id="" aria-label="Example select with button addon" v-model="admin_sub_cate">
					<option value="0" class="font_air bold pointer">게시글번호</option>
					<option value="1" class="font_air bold pointer">작성자번호</option>
					<option value="2" class="font_air bold pointer">제목</option>
					<option value="3" class="font_air bold pointer">내용</option>
				</select>
				<input type="text" class="form-control font_air bold" aria-label="Text input with dropdown button" 
					v-model="admin_sub_input"
					@keyup.enter="get_board(1)"
				>
				<button class="btn btn-outline-secondary" type="button" @click="get_board(1)">검색</button>
			</div>
		</div>	
		<table class="table table-hover  table-border mb-3">
			<thead>
				<tr class="admin_tr">
					<th scope="col" class="">게시글번호</th>
					<th scope="col" class="">작성자번호</th>
					<th scope="col" class="">제목</th>
					<th scope="col" class="">내용</th>
					<th scope="col" class="">작성위치</th>
					<th scope="col" class="">작성시간</th>
					<th scope="col" class="">삭제여부</th>
				</tr>			
			</thead>
			<tbody>
				<tr v-for="data in boards" :key="data"
					@click="modalboardget(data.id,data.flg)"
					class="pointer"
					data-bs-toggle="modal" data-bs-target="#boardmodal"
				>
					<th scope="row" class="admin_table_th font_air bold">{{ data.id }}</th>
					<td class="admin_table_th font_air bold">{{ data.u_id }}</td>
					<td class="admin_table_td1 font_air bold">{{ data.title }}</td>
					<td class="admin_table_td font_air bold">{{ data.content }}</td>
					<td class="admin_table_td2 font_air bold">{{ data.flg }}</td>
					<td class="admin_table_td2 font_air bold">{{ data.created_at }}</td>
					<td class="admin_table_td2 font_air bold">{{ data.deleted_at }}</td>
				</tr>
				<div
					v-if="boards.length < 1"
				>조회된 게시물이 없습니다.</div>
				<div class="modal fade" id="boardmodal" tabindex="-1" aria-labelledby="boardmodalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="boardmodalLabel">Modal title</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="input-group mb-1">
									<span class="input-group-text" id="basic-addon1">제목</span>
									<input type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_title" :readonly="modal_board_flg">
								</div>
								<div class="input-group mb-1">
									<span class="input-group-text">내용</span>
									<textarea class="form-control font_air bold" aria-label="With textarea" v-model="modal_board_content" :readonly="modal_board_flg">{{ this.modalboard.content }}</textarea>
								</div>
								<div class="input-group mb-1" v-if="modalboard.main_flg==='축제'||modalboard.main_flg==='관광'">
									<span class="input-group-text" >주소</span>
									<input type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_place" :readonly="modal_board_flg">
								</div>
								<div class="input-group mb-3 align-items-center" v-if="!modal_board_flg">
									<span class="input-group-text" >1번이미지</span>
									<input id="modal_file_img1_text" class="form-control font_air bold" type="text" v-if="!modal_board_flg" readOnly :value="modalboard.img1">
									<button type="button" class="btn btn-secondary" @click="modalboard.img1 = ''">삭제</button>
									<span class="input-group-text" >2번이미지</span>
									<input id="modal_file_img2_text" class="form-control font_air bold" type="text" v-if="!modal_board_flg" readOnly :value="modalboard.img2">
									<button type="button" class="btn btn-secondary" @click="modalboard.img2 = ''">삭제</button>
									<span class="input-group-text" >3번이미지</span>
									<input id="modal_file_img3_text" class="form-control font_air bold" type="text" v-if="!modal_board_flg" readOnly :value="modalboard.img3">
									<button type="button" class="btn btn-secondary" @click="modalboard.img3 = ''">삭제</button>
								</div>
								<div class="input-group mb-3 align-items-center">
									<span class="input-group-text"  v-if="!modal_board_flg">이미지변경</span>
									<div v-if="modalboard.img1">
										<img :src="modalboard.img1" alt="" v-if="modal_board_flg" class="admin_img">
									</div>
									<div v-if="modalboard.img2">
										<img :src="modalboard.img2" alt="" v-if="modal_board_flg" class="admin_img">
									</div>
									<div v-if="modalboard.img3">
										<img :src="modalboard.img3" alt="" v-if="modal_board_flg" class="admin_img">
									</div>
									<div v-if="!modalboard.img1&&!modalboard.img2&&!modalboard.img3&&modal_board_flg">
										이미지없음
									</div>
									<input id="modal_file_img1" class="form-control font_air bold" type="file" accept="image/*" v-if="!modal_board_flg">
									<input id="modal_file_img2" class="form-control font_air bold" type="file" accept="image/*" v-if="!modal_board_flg">
									<input id="modal_file_img3" class="form-control font_air bold" type="file" accept="image/*" v-if="!modal_board_flg">
								</div>
								<div class="input-group mb-3" v-if="modalboard.main_flg==='축제'||modalboard.main_flg==='관광'">
									<span class="input-group-text">지역</span>
									<input class="form-control font_air bold" type="text" :value="modalboard.ns_flg" v-if="modal_board_flg" :readonly="modal_board_flg">
									<select class="form-select font_air bold pointer font_air bold pointer" id="validationTooltip04" v-model="modal_board_ns" v-if="!modal_board_flg" :value="modalboard.ns_flg">
										<option value="경상북도" class="font_air bold pointer">경상북도</option>
										<option value="경상남도" class="font_air bold pointer">경상남도</option>
									</select>
									<span class="input-group-text">시.군</span>
									<input class="form-control font_air bold" type="text" :value="modalboard.states_name" v-if="modal_board_flg" :readonly="modal_board_flg">
									<!-- 북도 -->
									<select class="form-select font_air bold pointer" id="validationTooltip04" required v-model="modal_board_state_n" v-if="modal_board_ns==='경상북도'&&!modal_board_flg">
										<option class="font_air bold pointer">경산시</option>
										<option class="font_air bold pointer">경주시</option>
										<option class="font_air bold pointer">고령군</option>
										<option class="font_air bold pointer">구미시</option>
										<option class="font_air bold pointer">김천시</option>
										<option class="font_air bold pointer">문경시</option>
										<option class="font_air bold pointer">봉화군</option>
										<option class="font_air bold pointer">상주시</option>
										<option class="font_air bold pointer">성주군</option>
										<option class="font_air bold pointer">안동시</option>
										<option class="font_air bold pointer">영덕군</option>
										<option class="font_air bold pointer">영양군</option>
										<option class="font_air bold pointer">영주시</option>
										<option class="font_air bold pointer">영천시</option>
										<option class="font_air bold pointer">울릉군</option>
										<option class="font_air bold pointer">울진군</option>
										<option class="font_air bold pointer">의성군</option>
										<option class="font_air bold pointer">예천군</option>
										<option class="font_air bold pointer">청도군</option>
										<option class="font_air bold pointer">청송군</option>
										<option class="font_air bold pointer">칠곡군</option>
										<option class="font_air bold pointer">포항시</option>
									</select>
									<!-- 남도 -->
									<select class="form-select font_air bold pointer" id="validationTooltip04" required v-model="modal_board_state_s" v-if="modal_board_ns==='경상남도'&&!modal_board_flg">			
										<option class="font_air bold pointer">거제시</option>
										<option class="font_air bold pointer">거창군</option>
										<option class="font_air bold pointer">고성군</option>
										<option class="font_air bold pointer">김해시</option>
										<option class="font_air bold pointer">남해군</option>
										<option class="font_air bold pointer">밀양시</option>
										<option class="font_air bold pointer">사천시</option>
										<option class="font_air bold pointer">산청군</option>
										<option class="font_air bold pointer">양산시</option>
										<option class="font_air bold pointer">의령군</option>
										<option class="font_air bold pointer">진주시</option>
										<option class="font_air bold pointer">창녕군</option>
										<option class="font_air bold pointer">창원시</option>
										<option class="font_air bold pointer">통영시</option>
										<option class="font_air bold pointer">하동군</option>
										<option class="font_air bold pointer">함안군</option>
										<option class="font_air bold pointer">함양군</option>
										<option class="font_air bold pointer">합천군</option>
									</select>
								</div>
								<div class="input-group mb-3" v-if="modalboard.main_flg==='축제'">
									<span class="input-group-text">축제기간</span>
									<input type="text" class="form-control font_air bold" placeholder="축제시작 YYYY-MM-DD" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_start_f" :readonly="modal_board_flg">
									<input type="text" class="form-control font_air bold" placeholder="축제종료 YYYY-MM-DD" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_end_f" :readonly="modal_board_flg">
								</div>
								<div class="input-group mb-3 d-flex justify-content-evenly" v-if="modalboard.main_flg==='축제'||modalboard.main_flg==='관광'">
									<div class="form-check form-switch">
										<input class="form-check-input pointer" type="checkbox" id="admin_parking" v-model="modal_board_chk_flg1" :disabled ="modal_board_flg">
										<label class="form-check-label pointer font_air bold pointer" for="admin_parking">주차가능 여부</label>
									</div>
									<div class="form-check form-switch">
										<input class="form-check-input pointer" type="checkbox" id="admin_couple" v-model="modal_board_chk_flg2" :disabled ="modal_board_flg">
										<label class="form-check-label pointer font_air bold pointer" for="admin_couple">커플 추천</label>
									</div>
									<div class="form-check form-switch">
										<input class="form-check-input pointer" type="checkbox" id="admin_friend" v-model="modal_board_chk_flg3" :disabled ="modal_board_flg">
										<label class="form-check-label pointer font_air bold pointer" for="admin_friend">친구 추천</label>
									</div>
									<div class="form-check form-switch">
										<input class="form-check-input pointer" type="checkbox" id="admin_family" v-model="modal_board_chk_flg4" :disabled ="modal_board_flg">
										<label class="form-check-label pointer font_air bold pointer" for="admin_family">가족 추천</label>
									</div>
								</div>
								<div class="input-group mb-3" v-if="modalboard.main_flg==='축제'||modalboard.main_flg==='관광'">
									<span class="input-group-text">입장료</span>
									<input type="text" class="form-control font_air bold" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_fee" :readonly ="modal_board_flg">
									<span class="input-group-text">이용시간</span>
									<input type="text" class="form-control font_air bold" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_time" :readonly ="modal_board_flg">
								</div>
								<div class="input-group mb-3" v-if="modalboard.main_flg==='축제'||modalboard.main_flg==='관광'">
									<span class="input-group-text">휴일</span>
									<input type="text" class="form-control font_air bold" placeholder="미작성시 연중무휴" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_holiday" :readonly ="modal_board_flg">
									<span class="input-group-text">전화번호</span>
									<input type="text" class="form-control font_air bold" placeholder="미작성시 없음" aria-label="Username" aria-describedby="basic-addon1" v-model="modal_board_tel" :readonly ="modal_board_flg">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-text" >삭제일자</span>
									<input type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1" v-model="this.modalboard.deleted_at" readOnly>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" v-if="this.modalboard.deleted_at==='X'&&modal_board_flg" @click="modalboarddel(modalboard.id,modalboard.main_flg)">삭제</button>
								<button type="button" class="btn btn-danger" v-if="this.modalboard.deleted_at!=='X'&&modal_board_flg" @click="modalboardrepair(modalboard.id,modalboard.main_flg)">복구</button>
								<button type="button" class="btn btn-primary" v-if="modal_board_flg&&this.modalboard.deleted_at==='X'" @click="modal_board_flg=false">수정</button>
								<button type="button" class="btn btn-primary" v-if="!modal_board_flg" @click="modalboardpost">수정완료</button>
								<button type="button" id="modal_board_close_btn" class="btn btn-secondary" data-bs-dismiss="modal" @click="modal_board_flg=true">닫기</button>
							</div>
						</div>
					</div>
				</div>
			</tbody>
		</table>
		<div class='admin_page'>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="get_board(1)">&lt;&lt;</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="get_board(prevnum)">이전</span>
					</li>
					<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
						<span class="page-link" @click="get_board(num)">{{ num }}</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="get_board(nextnum)">다음</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="get_board(lastpage)">>></span>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- 댓글조회 -->
	<div v-if="mainflg===1&&subflg===2" class="admin_frame">
		<div class="admin_board_header">
			<div class="col-md-3 position-relative mb-4 admin_board_header1">
				<label for="validationTooltip1" class="form-label">등록위치</label>
				<select class="form-select font_air bold pointer" id="validationTooltip1" required v-model="admin_board_cate1" @change="get_replie(1)">
					<option value="0" class="font_air bold pointer">전체</option>
					<option value="1" class="font_air bold pointer">축제&관광</option>
					<option value="2" class="font_air bold pointer">커뮤니티</option>
				</select>
			</div>
			<div class="admin_board_header2">
				<select class="form-select font_air bold pointer" id="" aria-label="Example select with button addon" v-model="admin_sub_cate1">
					<option value="0" class="font_air bold pointer">댓글번호</option>
					<option value="1" class="font_air bold pointer">작성자번호</option>
					<option value="2" class="font_air bold pointer">게시글번호</option>
					<option value="3" class="font_air bold pointer">내용</option>
				</select>
				<input type="text" class="form-control font_air bold" aria-label="Text input with dropdown button" placeholder="미입력시 전체정보" 
					v-model="admin_sub_input1"
					@keyup.enter="get_replie(1)"
				>
				<button class="btn btn-outline-secondary" type="button" @click="get_replie(1)">검색</button>
			</div>
		</div>	
		<table class="table table-hover  table-border mb-3">
			<thead>
				<tr class="admin_tr">
					<th scope="col">댓글번호</th>
					<th scope="col">작성자번호</th>
					<th scope="col">게시글번호</th>
					<th scope="col">내용</th>
					<th scope="col">작성위치</th>
					<th scope="col">작성시간</th>
					<th scope="col">삭제여부</th>
				</tr>			
			</thead>
			<tbody>
				<tr v-for="data in replies" :key="data"  data-bs-toggle="modal" data-bs-target="#replieModal" @click="modalreplieget(data.id,data.flg)">
					<th scope="row" class="admin_table_th font_air bold pointer">{{ data.id }}</th>
					<td class="admin_table_th font_air bold pointer">{{ data.u_id }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.b_id }}</td>
					<td class="admin_table_td font_air bold pointer">{{ data.replie }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.flg }}</td>
					<td class="admin_table_td2 font_air bold pointer">{{ data.created_at }}</td>
					<td class="admin_table_td2 font_air bold pointer">{{ data.deleted_at }}</td>
				</tr>
				<div
					v-if="replies.length < 1"
				>조회된 댓글이 없습니다.</div>
				<div class="modal fade" id="replieModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">댓글 상세정보</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="input-group mb-1">
									<span class="input-group-text" id="basic-addon1">댓글번호</span>
									<div type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1">{{ modalreplie.id }}</div>
									<span class="input-group-text" id="basic-addon1">작성자번호</span>
									<div type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1">{{ modalreplie.u_id }}</div>
								</div>
								<div class="input-group mb-1">
									<span class="input-group-text" id="basic-addon1">게시판번호</span>
									<div type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1">{{ modalreplie.b_id }}</div>
									<span class="input-group-text" id="basic-addon1">작성위치</span>
									<div type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1">{{ modalreplie.type }}</div>
								</div>
								<div class="input-group mb-3">
									<span class="input-group-text">댓글</span>
									<div type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1">{{ modalreplie.replie }}</div>
								</div>
								<div class="input-group mb-1">
									<span class="input-group-text">작성일</span>
									<div type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1">{{ modalreplie.created_at }}</div>
									<span class="input-group-text">삭제여부</span>
									<div type="text" class="form-control font_air bold" aria-label="Username" aria-describedby="basic-addon1">{{ modalreplie.deleted_at }}</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" v-if="this.modalreplie.deleted_at==='X'" @click="modalrepliedel(modalreplie.id)">삭제</button>
								<button type="button" class="btn btn-danger" v-if="this.modalreplie.deleted_at!=='X'" @click="modalreplierepair(modalreplie.id)">복구</button>
								<button type="button" id="modal_replie_close_btn" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
							</div>
						</div>
					</div>
				</div>
			</tbody>
		</table>
		<div class='admin_page  mt-3'>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="get_replie(1)">&lt;&lt;</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="get_replie(prevnum)">이전</span>
					</li>
					<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
						<span class="page-link" @click="get_replie(num)">{{ num }}</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="get_replie(nextnum)">다음</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="get_replie(lastpage)">>></span>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- 통계페이지 -->
	<!-- 유저통계 -->
	<div v-if="mainflg===2&&subflg===0" class="admin_frame">
		<div class="admin_chart_flex center">
			<div class="admin_chart_line">
				<div class="font_air bold">현재 회원 연령별 성비(%)</div>
				<Bar :data="u_chart1.data" :options="u_chart1.options" />
			</div>
		</div>
		<div class="admin_chart_flex center">
			<div>
				<div class="font_air bold">한달간 유저 탈퇴 비율</div>
				<Doughnut :data="u_chart2.data" :options="u_chart2.options" />
			</div>
			<div>
				<div class="font_air bold">회원 탈퇴 사유 비율</div>
				<Doughnut :data="u_chart3.data" :options="u_chart3.options" />
			</div>
			<div>
				<div class="font_air bold">유저들 활동 시간별 비율</div>
				<Doughnut :data="u_chart4.data" :options="u_chart4.options" />
			</div>
		</div>
	</div>
	<!-- 조회수통계 -->
	<div v-if="mainflg===2&&subflg===1" class="admin_frame">
		<div class="admin_chart_flex center">
			<div>
				<div class="font_air bold">각 테마별 평균 조회수</div>
				<Doughnut :data="h_chart1.data" :options="h_chart1.options" />
			</div>
			<div>
				<div class="font_air bold">축제&관광 평균 조회수</div>
				<Doughnut :data="h_chart2.data" :options="h_chart2.options" />
			</div>
			<div>
				<div class="font_air bold">경북&경남 평균 조회수</div>
				<Doughnut :data="h_chart3.data" :options="h_chart3.options" />
			</div>
		</div>
		<div class="admin_chart_flex center">
			<div>
				<div class="font_air bold">경북의 top5(시,군) 조회수 평균</div>
				<Doughnut :data="h_chart4.data" :options="h_chart4.options" />
			</div>
			<div>
				<div class="font_air bold">경남의 top5(시,군) 조회수 평균</div>
				<Doughnut :data="h_chart5.data" :options="h_chart5.options" />
			</div>
		</div>
	</div>
	<!-- 좋아요통계 -->
	<div v-if="mainflg===2&&subflg===2" class="admin_frame">
		<div class="admin_comu_label">축제&관광</div>
		<div class="admin_chart_flex center">
			<div>
				<div class="font_air bold">축제&관광의 성비에 따른 좋아요 이용 비율</div>
				<Doughnut :data="chart1.data" :options="chart1.options" />
			</div>
			<div>
				<div class="font_air bold">축제&관광의 좋아요 비율</div>
				<Doughnut :data="chart2.data" :options="chart2.options" />
			</div>
		</div>
		<div class="admin_chart_flex center">
			<div>
				<div class="font_air bold">연령대별 좋아요 이용 통계</div>
				<Doughnut :data="chart3.data" :options="chart3.options" />
			</div>
			<div>
				<div class="font_air bold">유저가 선호하는 테마</div>
				<Doughnut :data="chart4.data" :options="chart4.options" />
			</div>
		</div>
		<hr>
		<div class="admin_comu_label">커뮤니티</div>
		<div class="admin_chart_flex center">
			<div>
				<div class="font_air bold">커뮤니티의 성비에 따른 좋아요 이용 비율</div>
				<Doughnut :data="chart5.data" :options="chart5.options" />
			</div>
			<div>
				<div class="font_air bold">커뮤니티의 각 주제별 좋아요 비율</div>
				<Doughnut :data="chart6.data" :options="chart6.options" />
			</div>
			<div>
				<div  class="font_air bold">커뮤니티의 각 카테고리별 좋아요 비율</div>
				<Doughnut :data="chart7.data" :options="chart7.options" />
			</div>
		</div>
	</div>
	<!-- 답변페이지 -->
	<div v-if="mainflg===3&&subflg===0" class="admin_frame">
		<div class="admin_main_flg">
			건의목록
		</div>
		<div class="admin_category_flex">
			<div
				class="pointer"
				:class="[{ 'admin_header_focus': this.request_flg === '0' }]"
				@click="requestall('0',1)"
				>
				처리전
			</div>
			<div
				class="pointer"
				:class="[{ 'admin_header_focus': this.request_flg === '1' }]"
				@click="requestall('1',1)"
				>
				처리후
			</div>
		</div>
		<div		
			v-if="Object.keys(this.requestdata).length === 0"
				class="admin_no_result font-air bold"
			>
			새로운 건의가 없습니다.
		</div>
		<div class="row row-cols-1 row-cols-md-4 g-4 admin-grid">
			<div class="col" 
				v-for="data in requestdata" :key="data"
			>
				<div class="card">
					<div class="card-body pointer"
						@click="dataget(data)"
					>
						<div class="admin_report_card_header">
							<h5 class="card-title font_air bold">건의내용</h5>
							<span :class="'font_air bold admin_report_card_header_span'+data.admin_flg">{{ this.requestarr[data.admin_flg] }}</span>
						</div>
						<div class="font_air bold card-text">작성자번호 = {{ data.u_id }}</div>
						<div class="font_air bold card-text">제목 = {{ data.title }}</div>
						<div class="font_air bold card-text">내용 = {{ data.content }}</div>
						<div class="font_air bold card-text">건의시간 = {{ data.created_at }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="admin_page mt-3">
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="requestall(request_flg,1)">&lt;&lt;</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="requestall(request_flg,prevnum)">이전</span>
					</li>
					<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
						<span class="page-link" @click="requestall(request_flg,num)">{{ num }}</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="requestall(request_flg,nextnum)">다음</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="requestall(request_flg,lastpage)">>></span>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- 신고페이지 -->
	<div v-if="mainflg===3&&subflg===1" class="admin_frame">
		<div class="admin_main_flg">
			신고목록
		</div>
		<div class="admin_category_flex">
			<div	
				:class="[{ 'admin_header_focus': this.report_flg === '0' }]"
				class="pointer"
				@click="reportall('0',1)"
			>
				처리전
			</div>
			<div
				:class="[{ 'admin_header_focus': this.report_flg === '1' }]"
				class="pointer"
				@click="reportall('1',1)"
			>
				처리후
			</div>
		</div>
		<div		
				v-if="Object.keys(this.reportdata).length === 0"
				class="admin_no_result font-air bold"
			>
				신고된 내용이 없습니다.
		</div>
		<div class="row row-cols-1 row-cols-md-4 g-4 admin-grid">
			<div class="col" 
				v-for="data in reportdata" :key="data"
			>
				<div class="card">
					<div class="card-body pointer"
						@click="reportget(data)"
					>
						<div class="admin_report_card_header">
							<h5 class="card-title font_air bold">신고한 유저</h5>
							<span :class="'font_air bold admin_report_card_header_span'+data.admin_flg">{{ this.reportarr[data.admin_flg] }}</span>
						</div>
						<div class="font_air bold card-text">작성자번호 = {{ data.u_id }}</div>
						<div class="font_air bold card-text">email = {{ data.email }}</div>
						<div class="font_air bold card-text">신고사유 = {{ data.content }}</div>
						<hr>
						<h5 class="font_air bold card-title">신고 당한 {{this.reportarr1[data.flg]}}</h5>
						<div class="font_air bold card-text">{{this.reportarr1[data.flg]}}번호 = {{ data.b_id }}</div>
						<div class="font_air bold card-text">신고시간 = {{ data.created_at }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class='admin_page  mt-3' v-if="Object.keys(this.reportdata).length !== 0">
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="reportall(report_flg,1)">&lt;&lt;</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="reportall(report_flg,prevnum)">이전</span>
					</li>
					<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
						<span class="page-link" @click="reportall(report_flg,num)">{{ num }}</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="reportall(report_flg,nextnum)">다음</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="reportall(report_flg,lastpage)">>></span>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- 유저관리페이지 -->
	<div v-if="mainflg===3&&subflg===2" class="admin_frame">
		<div class="admin_board_header">
			<div class="col-md-3 position-relative mb-4 admin_board_header1">
				<label for="validationTooltip1" class="form-label font_air bold pointer">유저정렬</label>
				<select class="form-select " id="validationTooltip1" required v-model="admin_user_cate" @change="searchuser(1)">
					<option value="0" class="font_air bold pointer">가입일순</option>
					<option value="1" class="font_air bold pointer">탈퇴일순</option>
					<option value="2" class="font_air bold pointer">제제횟수순</option>
					<option value="3" class="font_air bold pointer">제제기간순</option>
				</select>
			</div>
			<div class="admin_board_header2">
				<select class="form-select font_air bold pointer" id="" aria-label="Example select with button addon" v-model="searchtype">
					<option value="0" class="font_air bold pointer">유저번호</option>
					<option value="1" class="font_air bold pointer">email</option>
					<option value="2" class="font_air bold pointer">이름</option>
				</select>
				<input type="text" class="form-control font_air bold" aria-label="Text input with dropdown button" placeholder="미입력시 전체정보" 
					v-model="searchval"
					@keyup.enter="searchuser(1)"
				>
				<button class="btn btn-outline-secondary" type="button" @click="searchuser(1)">검색</button>
			</div>
		</div>	
		<table class="table table-hover  t font_air bold pointerable-border mb-3">
			<thead>
				<tr class="admin_tr">
					<th scope="col">유저번호</th>
					<th scope="col">email</th>
					<th scope="col">이름</th>
					<th scope="col">닉네임</th>
					<th scope="col">휴대폰번호</th>
					<th scope="col">성별</th>
					<th scope="col">생년월일</th>
					<th scope="col">가입일자</th>
					<th scope="col">삭제일자</th>
					<th scope="col">제재횟수</th>
					<th scope="col">제재기간</th>
				</tr>			
			</thead>
			<tbody>
				<tr v-for="data in userdata" :key="data"  data-bs-toggle="modal" data-bs-target="#userModal" @click="modaluserget(data)">
					<th scope="row" class="admin_table_th font_air bold pointer">{{ data.id }}</th>
					<td class="admin_table_th font_air bold pointer">{{ data.email }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.name }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.nick }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.phone }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.gender }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.birthdate }}</td>
					<td class="admin_table_td2 font_air bold pointer">{{ data.created_at }}</td>
					<td class="admin_table_td2 font_air bold pointer">{{ data.deleted_at }}</td>
					<td class="admin_table_th font_air bold pointer">{{ data.cnt }}</td>
					<td class="admin_table_td2 font_air bold pointer">{{ data.restraint_at }}</td>
				</tr>
				<div
					v-if="userdata.length < 1"
				>조회된 유저가 없습니다</div>
				<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">유저상세</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
									<div class="input-group mb-3">
										<span class="input-group-text">작성자번호</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.id }}
										</div>
										<span class="input-group-text">이메일</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.email }}
										</div>
									</div>
									<div class="input-group mb-3">
										<span class="input-group-text">이름</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.name }}
										</div>
									</div>
									<div class="input-group mb-3">
										<span class="input-group-text">닉네임</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.nick }}
										</div>
									</div>
									<div class="input-group mb-3">
										<span class="input-group-text">생년월일</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.birthdate }}
										</div>
										<span class="input-group-text">전화번호</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.phone }}
										</div>
										<span class="input-group-text">성별</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.gender }}
										</div>
									</div>
									<div class="input-group mb-3">
										<span class="input-group-text">가입일자</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.created_at }}
										</div>
										<span class="input-group-text">탈퇴일자</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.deleted_at }}
										</div>
									</div>
									<div class="input-group mb-1">
										<span class="input-group-text">재제당한횟수</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.cnt }}
										</div>
										<span class="input-group-text">재제사유</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.restraint }}
										</div>
									</div>
									<div class="input-group mb-3"> 	
										<span class="input-group-text">재제종료일</span>
										<div type="text" class="form-control font_air bold">
											{{ this.modaluser.restraint_at }}
										</div>
									</div>
									<div class="input-group mb-3">
										<span class="input-group-text">관리자등급</span>
										<div v-if="modaluser.flg === '일반유저'" type="text" class="form-control font_air bold">
											{{ this.modaluser.flg }}
										</div>
										<div v-else type="text" class="form-control font_air bold">
											{{ this.modaluser.flg }}
										</div>
									</div>
									<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">유저재제</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body" >
													<div>
														<span>재제기간</span>
														<select class="form-select" aria-label="Default select example" v-model="restraint_date">
															<option class=" font_air bold" value="0">1일</option>
															<option class=" font_air bold" value="1">3일</option>
															<option class=" font_air bold" value="2">7일</option>
															<option class=" font_air bold" value="3">15일</option>
															<option class=" font_air bold" value="4">30일</option>
															<option class=" font_air bold" value="5">영구재제</option>
														</select>
													</div>
													<div>
														<span>재제사유</span>
														<select class="form-select" aria-label="Default select example" v-model="restraint_msg">
															<option class=" font_air bold">욕설 및 혐오 표현</option>
															<option class=" font_air bold">불법 콘텐츠 게시</option>
															<option class=" font_air bold">스팸 활동</option>
															<option class=" font_air bold">악성 행위 및 고의적인 피해</option>
															<option class=" font_air bold">기타</option>
														</select>
														<input class="form-control font_air bold" type="text" placeholder="직접 입력 20자 내외"
															maxlength="20" aria-label="default input example" v-if="restraintinput" v-model="restraint_msg2">
													</div>
												
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary admin_boot_modal_close font_air bold" data-bs-dismiss="modal">닫기</button>
													<button type="button" class="btn btn-primary qna_color font_air bold"
														@click="restraintuser(this.modaluser.id,this.restraint_date,this.restraint_msg)"
													>적용</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<div v-if="modaluser.deleted_at==='X'" class="admin_frame9_btn_box">
										<div class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
										v-if="(modaluser.restraint_at < todaytime||modaluser.cnt === 0||modaluser.restraint_at === 'X')&&this.modaluser.flg==='일반유저'"
										>유저제재</div>
										<div class="btn btn-danger btn-sm"
										@click="clearestraint(this.modaluser.id,null)"
										v-if="(this.modaluser.restraint_at > this.todaytime&&this.modaluser.restraint_at !== 'X')&&modaluser.flg==='일반유저'"
										>제재해제</div>
										<div class="btn btn-primary btn-sm" @click="adminalret(modaluser.id)" v-if="modaluser.flg==='일반유저'&&authority">관리자로임명</div>
										<div class="btn btn-primary btn-sm" @click="admindel(modaluser.id)" v-if="modaluser.flg!=='일반유저'&&authority">관리자권한해제</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</tbody>
		</table>
		<div class='admin_page  mt-3'>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="searchuser(1)">&lt;&lt;</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
						<span class="page-link" @click="searchuser(prevnum)">이전</span>
					</li>
					<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
						<span class="page-link" @click="searchuser(num)">{{ num }}</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="searchuser(nextnum)">다음</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
						<span class="page-link" @click="searchuser(lastpage)">>></span>
					</li>
				</ul>
			</nav>
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
import { Bar,Line,Doughnut } from 'vue-chartjs'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

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
			modaluser: {},
			userdata: {},
			chart_flg: false,
			chart_flg1: false,
			authority: false,
			today: "",
			main_chart_type: "0",
			main_input: "0",
			main_title: "",
			main_content: "",
			todaytime: "",
			restraint_msg: "",
			restraint_msg2: "",
			restraint_date: "",
			searchval: "",
			searchtype: "0",
			r_cnt: 0,
			d_cnt: 0,
			sign_cnt: 0,
			mainflg: 0,
			searchflg: false,
			modal_board_flg: true,
			subflg: 0,
			drop_cnt: 0,
			data: [],
			r_data: [],	
			reportarr: {0:"처리전",1:"삭제처리",2:"이상없음",3:"작성자재제",4:"신고자재제"},
			requestarr: {0:"답변전",1:"답변완료"},
			reportarr1: {0:"게시글",1:"댓글"},
			now_data: {},
			now_report: {},
			modalReport:{},
			reportdata:{},
			report_flg:"0",
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
			requestdata:{},
			request_flg:"0",
			admin_title:"",
			admin_content:"",
			admin_place:"",
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
			modal_board_title:"",
			modal_board_content:"",
			modal_board_place:"",
			modal_board_ns:"",
			modal_board_state_n:"",
			modal_board_state_s:"",
			modal_board_start_f:"",
			modal_board_end_f:"",
			modal_board_chk_flg1:false,
			modal_board_chk_flg2:false,
			modal_board_chk_flg3:false,
			modal_board_chk_flg4:false,
			modal_board_fee:"",
			modal_board_time:"",
			modal_board_holiday:"",
			modal_board_tel:"",
			admin_board_cate:"0",
			admin_sub_cate:"0",
			admin_sub_input:"",
			admin_board_cate1:"0",
			admin_sub_cate1:"0",
			admin_sub_input1:"",
			admin_user_cate:"0",
			page:1,
			lastpage:1,
			first_num:1,
			last_num:1,
			prevnum:1,
			nextnum:2,
			numbox:[],
			boards: {},
			replies: {},
			modalboard: {},
			modalreplie: {},
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
							backgroundColor: ['#ff6666',"#ffcc66 ","#66c2ff"],
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
				},
			},
			u_chart2:{
				data: {
					labels: ['유지','탈퇴'],
					datasets: [
						{
							backgroundColor: ['#66c2ff',"#ff6666"],
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
			// 메인차트
			main_chart:{
				data: {
					labels: [],
					datasets: [
						{
							label: '가입수',
							backgroundColor: '#193f81',
							data: [0,0,0,0,0,0,0]
						},
						{
							label: '탈퇴수',
							backgroundColor: '#f87979',
							data: [0,0,0,0,0,0,0]
						}
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
				},
			},
			// 메인차트1
			main_chart1:{
				data: {
					labels: ['새벽','오전', '오후', '저녁'],
					datasets: [
						{
							label: '좋아요',
							backgroundColor: ['#ff5454'],
							data: [0, 0, 0,0],
						},
						{
							label: '댓글',
							backgroundColor: ['#4b7bcc'],
							data: [0, 0, 0,0],
						},
						{
							label: '게시글',
							backgroundColor: ['#4fb283'],
							data: [0, 0, 0,0],
						},
					],
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					indexAxis: 'y',
				},
			},
			main_chart1_b:{
				data: {
					labels: ['새벽','오전', '오후', '저녁'],
					datasets: [
						{
							label: '좋아요',
							backgroundColor: ['#f87979'],
							data: [0, 0, 0,0],
						},
						{
							label: '댓글',
							backgroundColor: ['#4997ff'],
							data: [0, 0, 0,0],
						},
						{
							label: '게시글',
							backgroundColor: ['#000'],
							data: [0, 0, 0,0],
						},
					],
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					indexAxis: 'y',
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
		if(localStorage.getItem('flg') === '1'){
			this.authority = true;
		}
		this.getToday();
		this.adminchk();
		this.mainchartget();
		this.statistics();
	},
	updated() {
		this.getToDayTime();
	},
	mounted() {

	},

	methods: {
		// 어드민체크
		adminchk(){
			this.chart_flg = false;
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
					this.d_cnt = res.data.d_cnt; 
					this.r_cnt = res.data.r_cnt;
					this.r_data.forEach(item => {
						item.flg = item.flg === '0' ? '커뮤' : '댓글';
					});
					for(let i = 0; i < res.data.chart.length; i++){
						this.main_chart.data.labels[i] = res.data.chart[i].month;
						this.main_chart.data.datasets[0].data[i] = res.data.chart[i].in_cnt;
						this.main_chart.data.datasets[1].data[i] = res.data.chart[i].out_cnt;
					}
					this.main_chart.data.labels =	this.main_chart.data.labels.reverse();
					this.main_chart.data.datasets[0].data = this.main_chart.data.datasets[0].data.reverse();
					this.main_chart.data.datasets[1].data = this.main_chart.data.datasets[1].data.reverse()
					this.chart_flg = true;
				}
			})
			.catch(err => {
				if(err.response.data.code === "E99"){
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '로그인에 실패하였습니다 다시한번 시도해주세요',
						confirmButtonText: '확인'
					})
					this.logout();
				}

			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 메인차트
		mainchartget(){
			this.chart_flg1 = false;
			this.$store.commit('setLoading',true);
			const URL = '/admin/main?flg='+this.main_chart_type
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){			
					let arr1 = res.data.data.filter(item => item.num === 0)
					let arr2 = res.data.data.filter(item => item.num === 1)
					let arr3 = res.data.data.filter(item => item.num === 2)
					for(let i = 0; i < arr1.length; i++){
						this.main_chart1.data.datasets[0].data[i] = arr1[i].cnt;
						this.main_chart1.data.datasets[1].data[i] = arr2[i].cnt;
						this.main_chart1.data.datasets[2].data[i] = arr3[i].cnt;
					}
					this.chart_flg1 = true;
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
				if(res.data.data.flg ==="0"){
					res.data.data.flg = "자유게시판"
				}else if(res.data.data.flg ==="1"){
					res.data.data.flg ="정보게시판"
				}else{
					res.data.data.flg ="질문게시판"
				}
				this.modalReport = res.data.data;
				this.modalReport.deleted_at = this.modalReport.deleted_at === null ? "X":this.modalReport.deleted_at;
				this.modalReport.restraint_at = this.modalReport.restraint_at === null ? "X":this.modalReport.restraint_at;
				this.modalflg = true;
			})
			.catch(err => {
				Swal({
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
			if(this.mainflg===3&&this.subflg===2){
				document.querySelector('.btn-close').click();
			}
		},
		// 답변달기
		adminAnswer(id,email){
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
				formData.append('email', email);
				formData.append('replie', this.answer);
				axios.post(URL,formData)
				.then(res => {
					if(res.data.code === "0"){
						if(this.mainflg===3&&this.subflg===0){
							this.requestall(this.request_flg,this.page);
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
					this.closeModal();
					if(this.mainflg===3&&this.subflg===1){
						this.reportall(this.report_flg,this.page)
					}else{
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
		// 건의온거 가져오기
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
					this.reportall(this.report_flg,this.page);
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
			if(main===1&&sub===1){
				this.get_board(1)
			}
			if(main===1&&sub===2){
				this.get_replie(1)
			}
			if(main===3&&sub===1){
				this.reportall(this.report_flg,1)
			}
			if(main===3&&sub===2){
				this.searchuser(1)
			}
			if(main===3&&sub===0){
				this.requestall("0",1)
			}
			this.resetall()
		},
		// 유저검색
		searchuser(page){
			this.$store.commit('setLoading',true);
			const URL = '/admin/userinfo?val='+this.searchval+"&flg="+this.searchtype+"&page="+page+"&order="+this.admin_user_cate
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){			
					for(let i = 0; i < res.data.data.data.length; i++){
						res.data.data.data[i].deleted_at = res.data.data.data[i].deleted_at === null ? "X":res.data.data.data[i].deleted_at;
						res.data.data.data[i].restraint_at = res.data.data.data[i].restraint_at === null ? "X":res.data.data.data[i].restraint_at;
					}	
					this.userdata = res.data.data.data
					this.page = res.data.data.current_page
					this.lastpage = res.data.data.last_page
					this.paging();
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
		// 모달용 유저정보 가져오기
		modaluserget(data){
			this.$store.commit('setLoading',true);
			this.modaluser = data;
			const URL = '/admin/modaluser?id='+data.id
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){			
					if(res.data.admin){
						if(res.data.admin.flg === "0"){
							this.modaluser.flg = '일반관리자'
						}else if(res.data.admin.flg === "1"){
							this.modaluser.flg = '메인관리자'
						}
					}else{
						this.modaluser.flg = '일반유저'
					}
					if(res.data.report){
						this.modaluser.restraint = res.data.report.restraint
					}else{
						this.modaluser.restraint = 'X'
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
					text: '재제기간을 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else if(msg ===""||(msg === "기타"&&this.restraint_msg2 === "")){
				Swal.fire({
					icon: 'warning',
					title: '주의',
					text: '재제사유를 입력해 주세요.',
					confirmButtonText: '확인'
				})
			}else{
				this.$store.commit('setLoading',true);
				if(msg === "기타"){
					msg = this.restraint_msg2
				}
				const URL = '/admin/userinfo'
				const formData = new FormData();
				formData.append('u_id', u_id);
				formData.append('date', date);
				formData.append('msg', msg);
				axios.post(URL,formData)
				.then(res => {
					if(res.data.code === "0"){
						document.querySelector('.admin_boot_modal_close').click();
						this.closeModal();
						this.searchuser(this.page);
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
					if(!(this.mainflg === 3&&this.subflg === 1)){				
						this.searchuser(this.page);
						this.closeModal();
					}
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
		// 신고데이터 불러오기
		reportall(flg,page){
			this.report_flg =flg;
			this.$store.commit('setLoading',true);
			const URL = '/admin/reportall?flg='+flg+'&page='+page
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.reportdata = res.data.data.data;
					this.page = res.data.data.current_page
					this.lastpage = res.data.data.last_page
					this.paging();
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
					this.reportall(this.report_flg,this.page)
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
			let to=['작성자 재제','신고자 재제']
			let date=['1일','3일','7일','15일','30일','영구재제']
			Swal.fire({
				title: to[user],
				text: '작성자번호 : '+u_id+'\n'+'재제사유 : '+date[flg],
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
							title: '재제사유',
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
		requestall(flg,page){
			this.$store.commit('setLoading',true);
			this.request_flg =flg;
			const URL = '/admin/requestall?flg='+flg+'&page='+page
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.requestdata = res.data.data.data;
					this.page = res.data.data.current_page
					this.lastpage = res.data.data.last_page
					this.paging();
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
					input.readOnly = true;
					this.updateflg = false;
					this.requestdata.find(item => item.id === id).replie = input.value;
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
		// 전체통계가져오기
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
					// 조회수 축제관광
					this.hit_main = res.data.hit_main;	
					for(let i = 0; i < this.hit_main.length; i++){
						this.h_chart2.data.labels[i] = this.hit_main[i].type;
						this.h_chart2.data.datasets[0].data[i]=this.hit_main[i].cnt;
					};
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
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 초기화용함수
		resetall(){
			this.main_input= "0";
			this.main_chart_type= "0";
			this.restraint_msg= "";
			this.restraint_msg2= "";
			this.restraint_date= "";
			this.searchval= "";
			this.searchtype= "0";
			this.searchflg=false;
			this.modalflg=false;
			this.restraintinput=false;
			this.answer="";
			this.admin_title="";
			this.admin_content="";
			this.admin_place="";
			this.admin_state_n="";
			this.admin_state_s="";
			this.admin_start_f="";
			this.admin_end_f="";
			this.admin_chk_flg1=false;
			this.admin_chk_flg2=false;
			this.admin_chk_flg3=false;
			this.admin_chk_flg4=false;		
			let img1 = document.querySelector('#admin_file_img1');
			let img2 = document.querySelector('#admin_file_img2');
			let img3 = document.querySelector('#admin_file_img3');
			if (img1 !== null && img1.value !== null) {
				img1.value = "";
			}
			if (img2 !== null && img2.value !== null) {
				img2.value = ""; 
			}
			if (img3 !== null && img3.value !== null) {
				img3.value = ""; 
			}
			this.admin_fee="";
			this.admin_time="";
			this.admin_holiday="";
			this.admin_tel="";
			this.admin_board_cate="0";
			this.admin_sub_cate="0";
			this.admin_sub_input="";
			this.admin_board_cate1="0";
			this.admin_sub_cate1="0";
			this.admin_sub_input1="";
			this.report_flg="0";
			this.request_flg="0";
			this.page=1;
			this.lastpage=1;
			this.first_num=1;
			this.last_num=1;
			this.prevnum=1;
			this.nextnum=2;
			this.numbox=[];
			this.boards={};
			this.replies={};
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
		// 모든보드정보 조회
		get_board(page){
			this.$store.commit('setLoading',true);
			let URL = '/admin/board?flg='+this.admin_board_cate+"&page="+page+"&sub_flg="+this.admin_sub_cate+"&val="+this.admin_sub_input
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					// 없으면
					for(let i = 0; i < res.data.data.data.length; i++){
						if(res.data.data.data[i].flg === '0'){
							res.data.data.data[i].flg = '자유게시판'
						}else if(res.data.data.data[i].flg === '1'){
							res.data.data.data[i].flg = '정보게시판'
						}else if(res.data.data.data[i].flg === '2'){
							res.data.data.data[i].flg = '질문게시판'
						}else if(res.data.data.data[i].flg === '3'){
							res.data.data.data[i].flg = '건의게시판'
						}else if(res.data.data.data[i].flg === '축제'){
							res.data.data.data[i].flg = '축제게시판'
							res.data.data.data[i].u_id = '관리자'
						}else if( res.data.data.data[i].flg === '관광'){
							res.data.data.data[i].flg = '관광게시판'
							res.data.data.data[i].u_id = '관리자'
						}
						res.data.data.data[i].deleted_at = res.data.data.data[i].deleted_at === null ? "X":res.data.data.data[i].deleted_at;
					}
					// 
					this.page = res.data.data.current_page
					this.lastpage = res.data.data.last_page
					this.boards = res.data.data.data;
					this.paging();
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
		// 모든댓글정보 조회
		get_replie(page){
			this.$store.commit('setLoading',true);
			let URL = '/admin/replie?flg='+this.admin_board_cate1+"&page="+page+"&sub_flg="+this.admin_sub_cate1+"&val="+this.admin_sub_input1
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					// 없으면
					for(let i = 0; i < res.data.data.data.length; i++){
						if(res.data.data.data[i].flg === '0'){
							res.data.data.data[i].flg = '축제&관광'
						}else if(res.data.data.data[i].flg === '1'){
							res.data.data.data[i].flg = '커뮤니티'
						}
						res.data.data.data[i].deleted_at = res.data.data.data[i].deleted_at === null ? "X":res.data.data.data[i].deleted_at;
					}
					this.page = res.data.data.current_page
					this.lastpage = res.data.data.last_page
					this.replies = res.data.data.data;
					this.paging();
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
		// 보드 모달정보
		modalboardget(id,type){
			this.$store.commit('setLoading',true);
			let URL = '/admin/boardmodal?id='+id+"&type="+type
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					if(res.data.data.parking_flg === "1"){
						res.data.data.parking_flg=true
					}else{
						res.data.data.parking_flg=false
					}
					if(res.data.data.couple_flg === "1"){
						res.data.data.couple_flg=true
					}else{
						res.data.data.couple_flg=false
					}
					if(res.data.data.friend_flg === "1"){
						res.data.data.friend_flg=true
					}else{
						res.data.data.friend_flg=false
					}
					if(res.data.data.family_flg === "1"){
						res.data.data.family_flg=true
					}else{
						res.data.data.family_flg=false
					}
					this.modal_board_title=res.data.data.title
					this.modal_board_content=res.data.data.content
					this.modal_board_place=res.data.data.place
					this.modal_board_ns=res.data.data.ns_flg
					if(res.data.data.ns_flg==="경상북도"){
						this.modal_board_state_n=res.data.data.states_name
					}else{
						this.modal_board_state_s=res.data.data.states_name
					}
					this.modal_board_start_f=res.data.data.start_at
					this.modal_board_end_f=res.data.data.end_at
					this.modal_board_chk_flg1=res.data.data.parking_flg
					this.modal_board_chk_flg2=res.data.data.couple_flg
					this.modal_board_chk_flg3=res.data.data.friend_flg
					this.modal_board_chk_flg4=res.data.data.family_flg
					this.modal_board_fee=res.data.data.fee
					this.modal_board_time=res.data.data.time
					this.modal_board_holiday=res.data.data.holiday
					this.modal_board_tel=res.data.data.tel
					this.modalboard = res.data.data;
					this.modalboard.deleted_at = this.modalboard.deleted_at === null ? "X":this.modalboard.deleted_at;
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
		// 보드 모달수정
		modalboardpost(){
			this.$store.commit('setLoading',true);
			let URL = '/admin/boardmodal'
			let b_img1 = document.querySelector('#modal_file_img1_text');
			let b_img2 = document.querySelector('#modal_file_img2_text');
			let b_img3 = document.querySelector('#modal_file_img3_text');
			let img1 = document.querySelector('#modal_file_img1');
			let img2 = document.querySelector('#modal_file_img2');
			let img3 = document.querySelector('#modal_file_img3');
			const formData = new FormData();
				formData.append('id',this.modalboard.id);
				formData.append('title',this.modal_board_title);
				formData.append('main_flg',this.modalboard.main_flg);
				formData.append('content',this.modal_board_content);
				formData.append('b_img1', b_img1.value);
				formData.append('b_img2', b_img2.value);
				formData.append('b_img3', b_img3.value);
				formData.append('img1', img1.files[0]);
				formData.append('img2', img2.files[0]);
				formData.append('img3', img3.files[0]);
			if(this.modalboard.main_flg==='축제'){
				formData.append('start_at',this.modal_board_start_f);
				formData.append('end_at',this.modal_board_end_f);
			}
			if(this.modalboard.main_flg==='축제'||this.modalboard.main_flg==='관광'){
				if(this.modal_board_chk_flg1){
					formData.append('parking_flg','1');
				}else{
					formData.append('parking_flg','0');
				}
				if(this.modal_board_chk_flg2){
					formData.append('couple_flg','1');
				}else{
					formData.append('couple_flg','0');
				}
				if(this.modal_board_chk_flg3){
					formData.append('friend_flg','1');
				}else{
					formData.append('friend_flg','0');
				}
				if(this.modal_board_chk_flg4){
					formData.append('family_flg','1');
				}else{
					formData.append('family_flg','0');
				}
				formData.append('place',this.modal_board_place);
				formData.append('ns_flg',this.modal_board_ns);
				if(this.modal_board_ns==="경상북도"){
					formData.append('states_name',this.modal_board_state_n);
				}else{
					formData.append('states_name',this.modal_board_state_s);
				}
				formData.append('fee',this.modal_board_fee);
				formData.append('time',this.modal_board_time);
				formData.append('holiday',this.modal_board_holiday);
				formData.append('tel',this.modal_board_tel);
			}
			axios.post(URL,formData)
			.then(res => {
				if(res.data.code === "0"){
					this.get_board(this.page);
					document.getElementById('modal_board_close_btn').click();
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
              	  });
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
		// 보드 모달삭제
		modalboarddel(id,flg){
			this.$store.commit('setLoading',true);
			let URL = '/admin/boardmodal/'+id+'/'+flg
			axios.delete(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.get_board(this.page);
					document.getElementById('modal_board_close_btn').click();
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					});
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
		// 보드 모달복구
		modalboardrepair(id,flg){
			this.$store.commit('setLoading',true);
			let URL = '/admin/boardmodal/'+id+'/'+flg
			axios.put(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.get_board(this.page);
					document.getElementById('modal_board_close_btn').click();
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					});
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
		// 댓글 모달정보
		modalreplieget(id,type){
			this.$store.commit('setLoading',true);
			let URL = '/admin/repliemodal?id='+id+"&type="+type
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.modalreplie = res.data.data
					this.modalreplie.deleted_at = this.modalreplie.deleted_at === null ? "X":this.modalreplie.deleted_at;
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
		// 댓글 모달삭제
		modalrepliedel(id){
			this.$store.commit('setLoading',true);
			let URL = '/admin/repliemodal/'+id
			axios.delete(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.get_replie(this.page);
					document.querySelector('#modal_replie_close_btn').click();
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					});
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
		// 댓글 모달복구
		modalreplierepair(id){
			this.$store.commit('setLoading',true);
			let URL = '/admin/repliemodal/'+id
			axios.put(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.get_replie(this.page);
					document.querySelector('#modal_replie_close_btn').click();
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					});
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
		// 관리자권한해제
		admindel(id){
			this.$store.commit('setLoading',true);
			let URL = '/admin/userinfo/'+id
			axios.delete(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.closeModal();
					this.searchuser(this.page);
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					});
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
		// 관리자등록등급 설정
		adminalret(id){
			Swal.fire({
				title: '관리자권한설정',
				input: 'select',
				inputOptions: {
					'0': '관리자 임명(관리자페이지 기능만 가능)',
					'1': '메인 관리자임명(관리자등록,관리자해제 가능)',
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
					const val = result.value;
					const URL = '/admin/userinfo/'+id+'/'+val
					axios.put(URL)
					.then(res => {
						if(res.data.code === "0"){
							this.searchuser(this.page);
							this.closeModal();
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
				}					
			})
		},
		// 공지등록
		addnotice(){
			const URL = '/admin/notice'
			const formData = new FormData();
			formData.append('flg',this.main_input);
			formData.append('title',this.main_title);
			formData.append('content',this.main_content);
			axios.post(URL,formData)
			.then(res => {
				if(res.data.code === "0"){
					this.main_title = "";
					this.main_content = "";
					this.main_input = '0';
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
		},
		// 페이징처리
		paging(){
			this.numbox = [];
			if(this.lastpage < 5){
				this.first_num = 1
				this.last_num = this.lastpage
			}else{
				if(this.page <= 3){
						this.first_num = 1
						this.last_num = 5
				}else if(this.page >= this.lastpage-2){
					this.first_num = this.lastpage-4
					this.last_num = this.lastpage
				}else{
					this.first_num = this.page-2
					this.last_num = this.page+2
				}
			}
			for(let i = this.first_num; i <= this.last_num; i++){
				this.numbox.push(i);
			}
			if(this.page === 1){
				this.prevnum = 1
				this.nextnum = 2
			}else if(this.page === this.lastpage){
				this.prevnum = this.lastpage-1
				this.nextnum = this.lastpage
			}else{	
				this.prevnum = this.page-1
				this.nextnum = this.page+1
			}
		},
	}
}
</script>