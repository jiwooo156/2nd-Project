<template>
	<div class="qna_frame">
		<div class="qna_container">
			<div class="qna_header">
				<h1 v-if="this.nowflg==='2'">질문게시판</h1>
				<h1 v-else="this.nowflg==='3'">건의게시판</h1>
				<div class="qna_header_bot">
					<div class="qna_header_l">
						<select v-model="selectedCategory" class="form-select qna_drop my-3" aria-label=".form-select-sm">
							<option :value="null" selected class="qna_drop_item">전체</option>
							<option :value="0" class="qna_drop_item">축제</option>
							<option :value="1" class="qna_drop_item">관광</option>
							<option :value="2" class="qna_drop_item">기타</option>
						</select>
						<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
						<!-- 질문게시판 -->
						<div v-if="this.nowflg==='2'" class="qna_btn">
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
						</div>
						<!-- 건의게시판 -->
						<div v-else="this.nowflg==='3'" class="qna_btn">
							<div class="btn-group" role="group">
								<button type="button" class="btn">
									<span class="font_center" ><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
								</button>
								<button type="button" class="btn">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>답변완료
								</button>
								<button type="button" class="btn">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>접수대기
								</button>
							</div>
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
				<!-- 질문 게시판 리스트 -->
				<div>
					<div v-for="item in filteredData" :key="item.id">{{ item.name }} - {{ item.category_flg }}</div>
				</div>
				<div v-if="this.nowflg==='2'" class="qna_content d-flex justify-content-between row g-3 px-2">
					<div v-for="infodata in infolist" :key="infodata" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(infodata.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ infodata.title }}
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ infodata.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(infodata.created_at) }}</span>
							</div>
							<div class="qna_def pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'thumbs-up']" /></span
									>{{ infodata.lik ?? 0 }}</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>{{ infodata.hits }}</span
								>
							</div>
						</div>
					</div>
				</div>
				<!-- 건의 게시판 리스트 -->
				<div v-else="this.nowflg==='3'" class="qna_content d-flex justify-content-between row g-3 px-2">
					<div v-for="infodata in infolist" :key="infodata" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(infodata.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ infodata.title }}
								<span class="qna_lock font_center"
									><font-awesome-icon :icon="['fas', 'lock']"
								/></span>
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ infodata.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(infodata.created_at) }}</span>
							</div>
							<div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text" :class="{ 'qna_wait': infodata.admin_flg === '0', 'qna_answer': infodata.admin_flg === '1' }">
									{{ infodata.admin_flg === '0' ? '접수대기' : '답변완료' }}
								</span>
							</div>
						</div>
					</div>
				</div>
				<div v-if="this.nowflg==='2'" class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
					<button type="button">질문하기</button>
				</div>
				<div v-else="this.nowflg==='3'" class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
					<button type="button">건의하기</button>
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
			<!-- 테스트용 입니다. -->
			<div>

			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'QnaComponent',
	data() {
		return {
			infolist: [],
			nowflg: "",
			// 예시
			festivals: [
				{ id: 1, name: '축제1', category_flg: 0 },
				{ id: 2, name: '관광1', category_flg: 1 },
				{ id: 3, name: '축제2', category_flg: 0 },
				{ id: 4, name: '기타1', category_flg: 2 },
				// ... (축제 데이터 계속 추가)
				],
			selectedCategory: null,
		}
	},
	created() {
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg');
		console.log(this.nowflg)
		this.getInfo(this.nowflg);
	},
	beforeRouteUpdate() {
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg')==="2"? "3":"2";
		this.getInfo(this.nowflg);
	},
	computed: {
		filteredData() {
			if (this.selectedCategory === null) {
				return this.festivals;
			} else {
				return this.festivals.filter(data => data.category_flg === this.selectedCategory);
			}
		},
	},
	methods: {
		// 질문&건의 게시글 데이터 출력
		getInfo(flg) {
			this.$store.commit('setLoading',true);
			// 해당url의 데이터 가져오기
			const URL = '/qna/info?flg='+ flg;
			console.log("getinfo 함수진입")
			// axios는 http status code가 200번대면 then으로, 그외에는 catch로
			axios.get(URL)
			.then(res => {
				console.log("then 시작");
				console.log("레스데이터"+res.data);
				if(res.data.code === '0') {
					this.infolist = res.data.information;
				}
				console.log('nowflg='+this.nowflg )
			})
			.catch(err => {
				this.$router.push('/error');
			})
			.finally(() => {
                this.$store.commit('setLoading', false);
            });
		},
		// category_flg 데이터 출력 변환
		getEventType(data) {
			if(data === '0') {
				return '축제';
			}else if (data === '1') {
				return '관광';
			}else if (data === '2') {
				return '기타';
			}else {
				return '기타';
			}
		},
		// created_at 데이터 출력 변환
		formatEventDate(dateString) {
		const dateObject = new Date(dateString);
		const year = dateObject.getFullYear();
		const month = String(dateObject.getMonth() + 1).padStart(2, "0");
		const day = String(dateObject.getDate()).padStart(2, "0");

		return `${year}-${month}-${day}`;
		},
		// 버튼 클릭시 카테고리별 데이터 출력
		filterData(category) {
			this.selectedCategory = category;
		},
	},
}
</script>

<style lang="scss" scoped></style>
