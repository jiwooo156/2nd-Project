<!-- php artisan route:clear -->
<template>
	<div class="qna_frame">
		<div class="qna_container">
			<!-- 질문게시판 -->
			<div v-if="this.nowflg==='2'" class="qna_q">
				<div class="qna_header">
					<h1>질문게시판</h1>
					<div class="qna_header_bot">
						<div class="qna_header_l">
							<select v-model="selectedCategory" @change="filterData" class="form-select qna_drop" aria-label=".form-select-sm">
								<option value="all" class="qna_drop_item" selected>전체</option>
								<option value="festival" class="qna_drop_item">축제</option>
								<option value="tourism" class="qna_drop_item">관광</option>
								<option value="etc" class="qna_drop_item">기타</option>
							</select>
							<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
							<div class="qna_btn">
								<div class="btn-group" role="group">
									<button v-if="selectedCategory === 'all'" type="button" class="btn" @click="latest">
										<span class="font_center" ><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
									</button>
									<button v-else-if="selectedCategory === 'festival'" type="button" class="btn" @click="latest">
										<span class="font_center" ><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
									</button>
									<button v-else-if="selectedCategory === 'tourism'" type="button" class="btn" @click="latest">
										<span class="font_center" ><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
									</button>
									<button v-else-if="selectedCategory === 'etc'" type="button" class="btn" @click="latest">
										<span class="font_center" ><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
									</button>
									<button v-if="selectedCategory === 'all'" type="button" class="btn" @click="views">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
									</button>
									<button v-else-if="selectedCategory === 'festival'" type="button" class="btn" @click="views">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
									</button>
									<button v-else-if="selectedCategory === 'tourism'" type="button" class="btn" @click="views">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
									</button>
									<button v-else-if="selectedCategory === 'etc'" type="button" class="btn" @click="views">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
									</button>
									<button v-if="selectedCategory === 'all'" type="button" class="btn" @click="likes">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
									</button>
									<button v-else-if="selectedCategory === 'festival'" type="button" class="btn" @click="likes">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
									</button>
									<button v-else-if="selectedCategory === 'tourism'" type="button" class="btn" @click="likes">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
									</button>
									<button v-else-if="selectedCategory === 'etc'" type="button" class="btn" @click="likes">
										<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
									</button>
								</div>	
							</div>
						</div>
						<!-- 반응형 숨기기 -->
						<div class="qna_header_r">
							<div v-if="selectedCategory === 'all'">
								총 <span class="qna_pink">{{ infolist.length }}</span>건의 게시글이 있습니다.
							</div>
							<div v-else-if="selectedCategory === 'festival'">
								총 <span class="qna_pink">{{ infolist.filter(info => info.category_flg === '0').length }}</span>건의 게시글이 있습니다.
							</div>
							<div v-else-if="selectedCategory === 'tourism'">
								총 <span class="qna_pink">{{ infolist.filter(info => info.category_flg === '1').length }}</span>건의 게시글이 있습니다.
							</div>
							<div v-else-if="selectedCategory === 'etc'">
								총 <span class="qna_pink">{{ infolist.filter(info => info.category_flg === '2').length }}</span>건의 게시글이 있습니다.
							</div>
						</div>
					</div>
				</div>	
				<!-- 반응형 2개씩/좌우 패딩?마진?조정하고 닉네임 들어가는 줄 hidden하기-->
				<!-- 전체 필터 -->
				<div v-if="selectedCategory === 'all'" class="qna_content d-flex justify-content-between row g-3 px-2">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'heart']" /></span
									>{{ info.cnt ?? 0 }}</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>{{ info.hits }}</span
								>
							</div>
						</div>
					</routerLink>
				</div>
				<!-- 축제 필터 -->
				<div v-else-if="selectedCategory === 'festival'" class="qna_content d-flex justify-content-between row g-3 px-2">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist.filter(info => info.category_flg === '0')" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'heart']" /></span
									>{{ info.lik ?? 0 }}</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>{{ info.hits }}</span
								>
							</div>
						</div>
					</routerLink>
				</div>
				<!-- 관광 필터 -->
				<div v-else-if="selectedCategory === 'tourism'" class="qna_content d-flex justify-content-between row g-3 px-2">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist.filter(info => info.category_flg === '1')" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'heart']" /></span
									>{{ info.lik ?? 0 }}</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>{{ info.hits }}</span
								>
							</div>
						</div>
					</routerLink>
				</div>
				<!-- 기타 필터 -->
				<div v-else-if="selectedCategory === 'etc'" class="qna_content d-flex flex-row justify-content-between row g-3 px-2">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist.filter(info => info.category_flg === '2')" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3">
								<span class="card-text qna_card_etc qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'heart']" /></span
									>{{ info.lik ?? 0 }}</span
								>
								<span class="card-text qna_gray"
									><span class="qna_card_span"
										><font-awesome-icon :icon="['fas', 'eye']" /></span
									>{{ info.hits }}</span
								>
							</div>
						</div>
					</routerLink>
				</div>
				<div class="qna_btn_bot d-flex flex-row-reverse mt-4 mb-4">
					<router-link to="/write?flg=2" type="button" @click="checklocal2">질문하기</router-link>
				</div>
			</div>
			<!-- 건의게시판 -->
			<div v-else="this.nowflg==='3'" class="qna_t">
				<div class="qna_header">
					<h1>건의게시판</h1>
					<div class="qna_header_bot">
						<div class="qna_header_l">
							<select v-model="selectedCategory" @change="filterData" class="form-select qna_drop" aria-label=".form-select-sm">
								<option value="all" class="qna_drop_item" selected>전체</option>
								<option value="festival" class="qna_drop_item">축제</option>
								<option value="tourism" class="qna_drop_item">관광</option>
								<option value="etc" class="qna_drop_item">기타</option>
							</select>
						</div>
						<!-- 반응형 숨기기 -->
						<div class="qna_header_r">
							<div v-if="selectedCategory === 'all'">
								총 <span class="qna_pink">{{ infolist.length }}</span>건의 게시글이 있습니다.
							</div>
							<div v-else-if="selectedCategory === 'festival'">
								총 <span class="qna_pink">{{ infolist.filter(info => info.category_flg === '0').length }}</span>건의 게시글이 있습니다.
							</div>
							<div v-else-if="selectedCategory === 'tourism'">
								총 <span class="qna_pink">{{ infolist.filter(info => info.category_flg === '1').length }}</span>건의 게시글이 있습니다.
							</div>
							<div v-else-if="selectedCategory === 'etc'">
								총 <span class="qna_pink">{{ infolist.filter(info => info.category_flg === '2').length }}</span>건의 게시글이 있습니다.
							</div>
						</div>
					</div>
				</div>	
				<!-- 반응형 2개씩/좌우 패딩?마진?조정하고 닉네임 들어가는 줄 hidden하기-->
				<!-- 전체 필터 -->
				<div v-if="selectedCategory === 'all'" class="qna_content d-flex justify-content-between row g-3 px-2" @click="checklocal_t">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
								<span class="qna_lock font_center"><font-awesome-icon :icon="['fas', 'lock']"/></span>
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text" :class="{ 'qna_wait': info.admin_flg === '0', 'qna_answer': info.admin_flg === '1' }">
									{{ info.admin_flg === '0' ? '접수대기' : '답변완료' }}
								</span>
							</div>
						</div>
					</routerLink>
				</div>
				<!-- 축제 필터 -->
				<div v-else-if="selectedCategory === 'festival'" class="qna_content d-flex justify-content-between row g-3 px-2" @click="checklocal_t">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist.filter(info => info.category_flg === '0')" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
								<span class="qna_lock font_center"><font-awesome-icon :icon="['fas', 'lock']"/></span>
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text" :class="{ 'qna_wait': info.admin_flg === '0', 'qna_answer': info.admin_flg === '1' }">
									{{ info.admin_flg === '0' ? '접수대기' : '답변완료' }}
								</span>
							</div>
						</div>
					</routerLink>
				</div>
				<!-- 관광 필터 -->
				<div v-else-if="selectedCategory === 'tourism'" class="qna_content d-flex justify-content-between row g-3 px-2" @click="checklocal_t">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist.filter(info => info.category_flg === '1')" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
								<span class="qna_lock font_center"><font-awesome-icon :icon="['fas', 'lock']"/></span>
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text" :class="{ 'qna_wait': info.admin_flg === '0', 'qna_answer': info.admin_flg === '1' }">
									{{ info.admin_flg === '0' ? '접수대기' : '답변완료' }}
								</span>
							</div>
						</div>
					</routerLink>
				</div>
				<!-- 기타 필터 -->
				<div v-else-if="selectedCategory === 'etc'" class="qna_content d-flex justify-content-between row g-3 px-2" @click="checklocal_t">
					<routerLink :to="'/post?id='+info.id" v-for="info in infolist.filter(info => info.category_flg === '2')" :key="info" class="card" style="width: 19rem">
						<div class="card-body d-flex flex-column justify-content-around">
							<h6 class="card-subtitle mb-2 qna_pink">{{ getEventType(info.category_flg) }}</h6>
							<h5 class="card-title mb-3 qna_card_tit">
								{{ info.title }}
								<span class="qna_lock font_center"><font-awesome-icon :icon="['fas', 'lock']"/></span>
							</h5>
							<div class="pb-3 d-flex justify-content-between qna_card">
								<span class="card-text"
									><span class="qna_card_span font_center"
										><font-awesome-icon :icon="['fas', 'user']" /></span
									>{{ info.nick }}</span
								>
								<span class="card-text">{{ formatEventDate(info.created_at) }}</span>
							</div>
							<div class="qna_def pt-3 d-flex flex-row-reverse">
								<span class="card-text" :class="{ 'qna_wait': info.admin_flg === '0', 'qna_answer': info.admin_flg === '1' }">
									{{ info.admin_flg === '0' ? '접수대기' : '답변완료' }}
								</span>
							</div>
						</div>
					</routerLink>
				</div>
				<div class="qna_btn_bot d-flex flex-row-reverse mt-4 mb-4">
					<router-link to="/write?flg=3" type="button" @click="checklocal3">건의하기</router-link>
				</div>
			</div>
			<!-- 아래 공통영역 -->
			<div class="page">
				<nav aria-label="Page navigation">
					<ul class="pagination justify-content-center qna_pagin">
						<li class="page-item">
							<a id="qna_font" class="page-link" aria-label="Previous">
								<span aria-hidden="true"><font-awesome-icon :icon="['fas', 'angle-left']"/></span>
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
					</ul>
				</nav>
			</div>
			<div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
		</div>
	</div>
</template>

<script>
import axios from 'axios';

export default {
	name: 'QnaComponent',
	data() {
		return {
			// 전체 데이터
			infolist: [],
			// url로 페이지 이동 설정
			nowflg: "",
			// 선택된 카테고리를 저장하는 초기값
			selectedCategory: 'all',
			selectedList: 'latest',
		}
	},
	created() {
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg');
		// console.log(this.nowflg)
		this.getInfo(this.nowflg);
	},
	beforeRouteUpdate() {
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg')==="2"? "3":"2";
		this.getInfo(this.nowflg);
		// 필터 'all' 항상 초기화
		this.selectedCategory = 'all';
	},
	methods: {
		// 질문&건의 게시글 데이터 출력
		getInfo(flg) {
			// 스피너 로딩바
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
		latest() {
			this.infolist.sort(function(a, b) {
				return new Date(b.created_at) - new Date(a.created_at);
			});
		},
		views() {
			this.infolist.sort(function(a, b) {
				return b.hits - a.hits;
			});
		},
		likes() {
			this.infolist.sort(function(a, b) {
				return b.cnt - a.cnt;
			});
		},
		wait() {
			return this.infolist.filter(item => item.admin_flg === '0');
		},
		answer() {
			return this.infolist.filter(item => item.admin_flg === '1');
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
		// 글작성 버튼 클릭 시 로그인 확인
		// 질문 로그인 확인
		checklocal2() {
			if (!localStorage.getItem('nick')) {
				if (confirm("로그인을 하신 후 이용해 주시기 바랍니다.")) {
					this.$router.push('/login');
				} else {
					this.$router.push('/qna?flg=2');
				}
			} else {
				this.$router.push('/write?flg=3');
			}
		},
		// 건의 로그인 확인
		checklocal3() {
			if (!localStorage.getItem('nick')) {
				if (confirm("로그인을 하신 후 이용해 주시기 바랍니다.")) {
					this.$router.push('/login');
				} else {
					this.$router.push('/qna?flg=3');
				}
			} else {
				this.$router.push('/write?flg=3');
			}
		},
		
		// 작성 게시글 확인 할 때 작성자만 확인 가능
		// 건의 로그인 확인

		// 유저 본인 확인(삭제&수정 버튼 활성화를 위한)
		checkUser(email) {
			return email === localStorage.getItem('email');
		},
	},
}
</script>

<style lang="scss" scoped></style>
