<template>
	<div class="qna_frame">
		<div class="qna_container">
			<div class="qna_header">
				<h1>{{ this.nowns }}게시판</h1>
				<div class="qna_header_bot">
					<div class="qna_header_l">
						<select class="form-select qna_drop my-3" aria-label=".form-select-sm">
							<option selected class="qna_drop_item">전체</option>
							<option value="1" class="qna_drop_item">축제</option>
							<option value="2" class="qna_drop_item">관광</option>
							<option value="3" class="qna_drop_item">기타</option>
						</select>
						<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
						<div class="qna_btn">
							<div class="btn-group" role="group">
								<button type="button" class="btn">
									<span class="font_center" ><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
								</button>
								<button type="button" class="btn">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
								</button>
								<button type="button" class="btn">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
								</button>
							</div>
							<!-- <button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								답변완료
							</button> -->
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
			</div>
				<!-- 반응형 2개씩/좌우 패딩?마진?조정하고 닉네임 들어가는 줄 hidden하기-->
				<div class="qna_content d-flex justify-content-between row g-3 px-2">
					<!-- 질문 게시판 리스트 -->
					<div v-for="qna in this.qnacomList" :key="qna" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ qna.flg }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ qna.title }}
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ qna.u_id }}</span
								>
								<span class="card-text">{{ qna.created_at }}</span>
							</div>
							<div class="qna_def pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>좋아요</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>{{ qna.hits }}</span
								>
							</div>
						</div>
					</div>
					<!-- 건의 게시판 리스트 -->
					<!-- <div v-for="tendinous in this.tendinouscomList" :key="tendinous" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ tendinous.flg }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ tendinous.title }}
								<span class="qna_lock font_center"
									><font-awesome-icon :icon="['fas', 'lock']"
								/></span>
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ tendinous.u_id }}</span
								>
								<span class="card-text">{{ tendinous.created_at }}</span>
							</div> -->
							<!-- *건의 접수대기 -->
							<!-- <div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text qna_wait">접수대기</span>
							</div> -->
							<!-- *건의 답변완료 -->
							<!-- <div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text qna_answer">답변완료</span>
							</div> -->
						<!-- </div>
					</div> -->
				</div>
				<div class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
					<button type="button">질문하기</button>
				</div>
				<div>
					<nav aria-label="Page navigation">
						<ul class="pagination justify-content-center qna_pagin">
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#" aria-label="Previous">
									<span aria-hidden="true"><font-awesome-icon :icon="['fas', 'angle-left']"/></span>
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
			<div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
		</div>
	</div>
	<!-- <div class="qna_qt">{{ this.nowns }}</div> -->
</template>

<script>
export default {
	name: 'QnaComponent',
	data() {
		return {
			// 질문게시판 데이터 불러오기
			qnacomList: [],
			// 건의게시판 데이터 불러오기
			tendinouscomList: [],
			nowns: "",
		}
	},
	created() {
		// 로컬스토리지에 저장된 정보있는지 확인
		let boo = localStorage.getItem('nick') ?  true : false;
		this.$store.commit('setLocalFlg', boo);
		this.getQna();
		// 파라미터의 qt확인해서 store의 qtFlg셋팅
		// url의 파라미터 중 qt 세팅함
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowns = objUrlParam.get('ns')
		if(this.nowns==="질문"){
			this.$store.commit('setQtFlg','1');
		}else if(this.nowns==="건의"){
			this.$store.commit('setQtFlg','2');
		}
	},
	methods: {
		getQna(){
			// url 가져오기	
			const URL = '/qna/community?today='+this.today;
			axios.get(URL)
			.then(res => {
				this.qnacomList = res.data.qnaList;
				this.tendinouscomList = res.data.tendinousList;
			})
			.catch(err => {
				console.log("캐치");
				alert("데이터 에러 발생");
			})
		},
	},
}
</script>

<style lang="scss" scoped></style>
