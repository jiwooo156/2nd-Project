<template>
	<div class="qna_frame">
		<div class="qna_container">
			<div class="qna_header">
				<h1>질문게시판</h1>
				<!-- <h1>건의게시판</h1> -->
				<div class="qna_header_bot">
					<div class="qna_header_l">
						<div class="dropdown">
							<!-- ***전체 카테고리 색상 잘 나오는지 확인!! -->
							<!-- 바텀 마진주기 -->
							<a
								class="btn btn-outline-light dropdown-toggle qna_drop py-3"
								href="#"
								role="button"
								id="dropdownMenuLink"
								data-bs-toggle="dropdown"
								aria-expanded="false"
							>
								전체
							</a>
							<ul
								class="dropdown-menu btn-sm"
								aria-labelledby="dropdownMenuLink"
							>
								<li>
									<a class="dropdown-item qna_drop_item" href="#">축제</a>
								</li>
								<li>
									<a class="dropdown-item qna_drop_item" href="#">관광</a>
								</li>
								<li>
									<a class="dropdown-item qna_drop_item" href="#">기타</a>
								</li>
							</ul>
						</div>
						<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
						<div class="qna_btn">
							<button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								최신순
							</button>
							<button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								조회수순
							</button>
							<!-- <button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								답변완료
							</button> -->
							<button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								좋아요순
							</button>
							<!-- <button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								접수대기
							</button> -->
						</div>
					</div>
					<!-- 반응형 숨기기 -->
					<div class="qna_header_r">
						<div>
							총 <span class="qna_pink">50</span>건의 게시글이 있습니다.
						</div>
					</div>
				</div>
				<!-- 세로 3개 가로 3개 해서 항상 9개씩 가져오기 -->
				<!-- 반응형 2개씩/좌우 패딩?마진? -->
				<!-- TheView/AppCard 참고해서 v-for문 돌리기 -->
				<div class="qna_content d-flex justify-content-between row g-3 px-2">
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">축제</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								24년도 지역축제 책자 및 정리된 리스트 요청
								<!-- 유저가 비밀글 설정 시 -->
								<span class="qna_lock font_center"
									><font-awesome-icon :icon="['fas', 'lock']"
								/></span>
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<!-- <div class="qna_def pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div> -->
							<!-- *건의 접수대기 -->
							<div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text qna_wait">접수대기</span>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">기타</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								문화체육관광 사이버안전센터 취약점이행점검 중입니다.
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<!-- <div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div> -->
							<!-- *건의 답변완료 -->
							<div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text qna_answer">답변완료</span>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">기타</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								회원가입 안 되고 이메일 인증 안 됨
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">관광</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								이의이승 웹사이트 개편 해주세요
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">기타</h6>
							<h5 class="card-title mb-3 qna_card_tit">회원탈퇴 처리</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">축제</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								축제 사진좀 많이 넣어주세요.
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">축제</h6>
							<h5 class="card-title mb-3 qna_card_tit">질문드립니다.</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">관광</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								경상도 트램 투어에 대해 문의합니다
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div>
						</div>
					</div>
					<div class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">관광</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								고등학생들 수학여행 루트 추천 부탁드립니다.
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>닉네임</span
								>
								<span class="card-text">2024-01-06</span>
							</div>
							<div class="pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>35</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>4.15k</span
								>
							</div>
						</div>
					</div>
				</div>
				<div class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
					<button type="button">질문하기</button>
					<!-- <button type="button">건의하기</button> -->
				</div>
				<div>
					<nav aria-label="Page navigation">
						<ul class="pagination justify-content-center qna_pagin">
							<li class="page-item">
								<a
									id="qna_font"
									class="page-link"
									href="#"
									aria-label="Previous"
								>
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angle-left']"
									/></span>
								</a>
							</li>
							<li class="page-item">
								<a
									id="qna_font"
									class="page-link"
									href="#"
									aria-label="Previous"
								>
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angles-left']"
									/></span>
								</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">1</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">2</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">3</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">4</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">5</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#" aria-label="Next">
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angle-right']"
									/></span>
								</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#" aria-label="Next">
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angles-right']"
									/></span>
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- top_btn -->
		</div>
	</div>
	<!-- <div class="qna_qt">{{ this.nowns }}</div> -->
</template>

<script></script>

<style lang="scss" scoped></style>
