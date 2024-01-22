<template>
	<div class="qna_frame">
		<!-- 질문게시판 -->
		<div v-if="this.nowflg==='2'" class="qna_container">
			<div class="qna_header">
				<h1 >질문게시판</h1>
				<div class="qna_header_bot">
					<div class="qna_header_l">
						<select v-model="option" @click="getInfo()" class="form-select qna_drop my-3" aria-label=".form-select-sm">
							<option value="3" class="qna_drop_item" selected>전체</option>
							<option value="0" class="qna_drop_item">축제</option>
							<option value="1" class="qna_drop_item">관광</option>
							<option value="2" class="qna_drop_item">기타</option>
						</select>
						<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
						<div class="qna_btn">
							<div class="btn-group" role="group">
								<button type="button"  class="btn" value="1" @click="buttonclick(1)" :class="{'qna_btn_button_on': this.rangevalue == 1}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
								</button>
								<button type="button" class="btn" value="2" @click="buttonclick(2)" :class="{'qna_btn_button_on': this.rangevalue == 2}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
								</button>
								<button type="button" class="btn" value="3" @click="buttonclick(3)" :class="{'qna_btn_button_on': this.rangevalue == 3}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
								</button>
							</div>
						</div>
					</div>
					<div class="qna_header_r">
						<div>
							총 <span class="qna_pink"> {{ cntinfo }}</span>건의 게시글이 있습니다.
						</div>
					</div>
				</div>
			</div>	
			<!-- 공지 -->
			<div id="carouselExampleIndicators" class="carousel slide qna_content px-2 qna_notice_card" data-bs-ride="carousel">
				<div class="carousel-inner">
					<div v-for="(notice, index) in noticedata" :key="notice.id" class="carousel-item" :class="{ 'active': index === currentIndex }">
						<div class="card pointer qna_card_width" @click="$router.push('/post?id=' + notice.id)">
							<div class="card-body qna_card_body qna_mobile">
								<h6 class="card-subtitle mb-2 qna_pink" id="qna_notice_icon"><font-awesome-icon :icon="['fas', 'volume-off']" /> {{ isNotice(notice.category_flg) }}</h6>
								<h5 class="card-title mb-3 qna_card_tit">
									{{ notice.title }}
								</h5>
								<div class="d-flex justify-content-between">
									<span class="card-text"
										><span class="qna_card_span font_center"
											><font-awesome-icon :icon="['fas', 'user']" />
										</span>{{ isAdmin(notice.nick) }}</span>
									<!-- <span class="card-text qna_created">{{ formatEventDate(notice.created_at) }}</span> -->
									<div class="qna_def ">
										<span class="card-text qna_card_etc qna_gray"
											><span class="qna_card_span"
												><font-awesome-icon :icon="['fas', 'heart']" /></span
											>{{ notice.cnt ?? 0 }}</span
										>
										<span class="card-text qna_gray"
											><span class="qna_card_span"
												><font-awesome-icon :icon="['fas', 'eye']" /></span
											>{{ notice.hits }}</span
										>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button class="carousel-control-prev" id="qna_prev" type="button" @click="prevSlide">&lt;</button>
				<button class="carousel-control-next" id="qna_next" type="button" @click="nextSlide">&gt;</button>
			</div>
			<!-- 게시글 -->
			<div class="qna_content d-flex gap-4 row g-3 px-2">
				<div v-for="info in infolist" :key="info" class="card pointer" style="width: 19rem" @click="$router.push('/post?id='+info.id)">
					<div class="card-body qna_card_body d-flex flex-column justify-content-around">
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
							<span class="card-text qna_created">{{ formatEventDate(info.created_at) }}</span>
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
				</div>
			</div>
			<div class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
				<router-link to="/commuwrite" type="button" @click="checklocal2">질문하기</router-link>
			</div>
		</div>
		<!-- 건의게시판 -->
		<div v-else="this.nowflg==='3'" class="qna_container">
			<div class="qna_header">
				<h1>건의게시판</h1>
				<div class="qna_header_bot_2">
					<div class="qna_header_l">
						<select v-model="option" @click="getInfo()" class="form-select mt-3 qna_drop" aria-label=".form-select-sm">
							<option value="3" class="qna_drop_item" selected>전체</option>
							<option value="0" class="qna_drop_item">축제</option>
							<option value="1" class="qna_drop_item">관광</option>
							<option value="2" class="qna_drop_item">기타</option>
						</select>
						<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
						<!-- <div class="qna_btn">
							<div class="btn-group" role="group">
								<button type="button"  class="btn" value="1" @click="buttonclick(1)" :class="{'qna_btn_button_on': this.rangevalue == 1}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
								</button>
								<button type="button" class="btn" value="2" @click="buttonclick(2)" :class="{'qna_btn_button_on': this.rangevalue == 2}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
								</button>
								<button type="button" class="btn" value="3" @click="buttonclick(3)" :class="{'qna_btn_button_on': this.rangevalue == 3}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
								</button>
							</div>
						</div> -->
					</div>
					<div class="qna_header_r">
						<div>
							총 <span class="qna_pink"> {{ cntinfo }}</span>건의 게시글이 있습니다.
						</div>
					</div>
				</div>
			</div>	
			<!-- 공지 -->
			<div id="carouselExampleIndicators" class="carousel slide qna_content px-2 qna_notice_card" data-bs-ride="carousel">
				<div class="carousel-inner">
					<div v-for="(notice, index) in noticedata" :key="notice.id" class="carousel-item" :class="{ 'active': index === currentIndex }">
						<div class="card pointer qna_card_width" @click="$router.push('/post?id=' + notice.id)">
							<div class="card-body qna_card_body qna_mobile">
								<h6 class="card-subtitle mb-2 qna_pink" id="qna_notice_icon"><font-awesome-icon :icon="['fas', 'volume-off']" /> {{ isNotice(notice.category_flg) }}</h6>
								<h5 class="card-title mb-3 qna_card_tit">
									{{ notice.title }}
								</h5>
								<div class="d-flex justify-content-between">
									<span class="card-text"
										><span class="qna_card_span font_center"><font-awesome-icon :icon="['fas', 'user']" />
										</span>{{ isAdmin(notice.nick) }}</span>
									<span class="card-text qna_created">{{ formatEventDate(notice.created_at) }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button class="carousel-control-prev" id="qna_prev" type="button" @click="prevSlide">&lt;</button>
				<button class="carousel-control-next" id="qna_next" type="button" @click="nextSlide">&gt;</button>
			</div>
			<!-- 게시글 -->
			<div class="qna_content d-flex gap-4 row g-3 px-2">
				<div v-for="info in infolist" :key="info" class="card pointer" style="width: 19rem" @click="$router.push('/post?id='+info.id)">
					<div class="card-body qna_card_body d-flex flex-column justify-content-around">
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
							<span class="card-text qna_created">{{ formatEventDate(info.created_at) }}</span>
						</div>
						<div class="qna_def d-flex flex-row-reverse">
							<span class="card-text" :class="{ 'qna_wait mt-3': info.admin_flg === '0', 'qna_answer mt-3': info.admin_flg === '1' }">
								{{ info.admin_flg === '0' ? '접수대기' : '답변완료' }}
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
				<router-link to="/commuwrite" type="button" @click="checklocal3">건의하기</router-link>
			</div>
		</div>
		<!-- 페이징 -->
		<div class="d-flex justify-content-center qna_page_bot">
			<nav aria-label="Page navigation">
				<ul class="pagination" id="qna_page">
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']" id="qna_item">
						<span class="page-link" id="qna_paging" @click="scrollToTopAndInfo(1)">&lt;&lt;</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']" id="qna_item">
						<span class="page-link" id="qna_paging" @click="scrollToTopAndInfo(prevnum)">&lt;</span>
					</li>
					<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']" id="qna_item">
						<span class="page-link" id="qna_paging" @click="scrollToTopAndInfo(num)">{{ num }}</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']" id="qna_item">
						<span class="page-link" id="qna_paging" @click="scrollToTopAndInfo(nextnum)">&gt;</span>
					</li>
					<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']" id="qna_item">
						<span class="page-link" id="qna_paging" @click="scrollToTopAndInfo(lastpage)">&gt;&gt;</span>
					</li>
				</ul>
			</nav>
		</div>
		<div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
	</div>
</template>
<script>
export default {
	name: "QnaComponent",

	data() {
		return {
			infolist: [],
			nowflg: "",
			cntinfo: 0,
			rangevalue: "1",
			option: "3",
			// 페이지셋팅
			page:1,
            lastpage:1,
            first_num:1,
            last_num:1,
            prevnum:1,
            nextnum:2,
            numbox:[],
			// 공지
			noticedata: "",
			// 캐러셀
			currentIndex: 0,
		}
	},
	created() {
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg');
		// console.log( "created flg"+this.nowflg );
		this.getInfo(1);
	},
	beforeRouteUpdate() {
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg')==="2"? "3":"2";
		// console.log("beforeupdated flg"+this.nowflg);
		this.option = "3";
		this.rangevalue = "1";
		this.getInfo(1);
	},
	methods: {
		getInfo(page) {
			// 스피너 로딩바
			this.$store.commit('setLoading',true);
			// 해당url의 데이터 가져오기
			const URL = '/qna/info?page='+page;
			// axios는 http status code가 200번대면 then으로, 그외에는 catch로
			axios.get(URL, {
				params: {
					"flg": this.nowflg,
					"category": this.option,
					"orderby": this.rangevalue,
					"page": page,
				}
			})
			.then(res => {
				this.infolist = res.data.data.data;
				this.cntinfo = res.data.infocnt;
				this.page = res.data.data.current_page;
                this.lastpage = res.data.data.last_page;
				this.noticedata = res.data.noticedata;
				this.paging();
			})
			.catch(err => {
				this.$router.push('/error');
			})
			.finally(() => {
                this.$store.commit('setLoading', false);
            });
		},
		// button 클릭시 value 데이터바인딩
		buttonclick(value) {
			this.rangevalue = value;
			this.getInfo();
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
		// 닉네임 관리자 출력 변환
		isAdmin(noticedata) {
			return '관리자';
		},
		// 공지 출력 변환
		isNotice(noticedata) {
			return '공지';
		},
		// 질문 로그인 확인
		checklocal2() {
			if (!localStorage.getItem('nick')) {
				if (confirm("로그인을 하신 후 이용해 주시기 바랍니다.")) {
					this.$router.push('/login');
				} else {
					this.$router.push('/qna?flg=2');
				}
			} else {
				this.$router.push('/commuwrite');
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
				this.$router.push('/commuwrite');
			}
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
		// 페이징 이동시 
		scrollToTopAndInfo(page) {
			this.getInfo(page);
			window.scrollTo(0, 0);
		},
		// 캐러셀 이동
		prevSlide() {
			this.currentIndex = (this.currentIndex - 1 + this.noticedata.length) % this.noticedata.length;
		},
		nextSlide() {
			this.currentIndex = (this.currentIndex + 1) % this.noticedata.length;
		},
	}
}
</script>
<style lang="scss" scoped></style>