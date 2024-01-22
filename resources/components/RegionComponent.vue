<template>
	<div class="region_frame">
		<div class="region_header_frame">
			<div class="center">
				<div class="region_ns">{{ this.nowns }}</div><span class="region_ns_span font_air bold">골라보이소🤗</span>
			</div>
			<div class="region_slider_container">
				<Carousel :itemsToShow="item" :wrapAround="true" :transition="400" :autoplay="3000" :mouseDrag="true" ref="myCarousel">
					<Slide v-for="state in states" :key="state" >
						<div @click="getRegionfestival(state.states_name)" class="font_air bold carousel__item pointer" :class="'state' + statearr[state.states_name]">{{ state.states_name }}</div>
					</Slide>
					<template #addons>
						<navigation />
					</template>
				</Carousel>
			</div>
			<div class="region_search_frame">
				<div class="region_search_flex">
					<select class="region_select_list pointer" v-model="searchstate"
						@keyup.enter="searchFestival"
					>
						<option class=" font_air bold">지역</option>
						<option v-for="state in states" :key="state" class=" font_air bold">{{ state.states_name }}</option>
					</select>
					<div>
						<input type="date" class="region_date font_air bold" v-model="startdate"
							@keyup.enter="searchFestival"
						>
						<span class="font_air bold region_date_span">~</span>
						<input type="date" class="region_date font_air bold" v-model="enddate"
							@keyup.enter="searchFestival"
						>
                    </div>
				</div>
				<div class="region_relative">
					<input type="text" class="region_search_text font_air bold" placeholder="키워드로 검색 해 보세요"
						v-model="searchkeyword" 
						@input="koreachk"
						@keyup.enter="searchFestival"
					>
					<button @click="searchFestival()" class="region_form_btn pointer font_air bold" >검색</button>
				</div>
				<div class="region_span_box">
					<span class="font_air bold pointer" :class="{ 'region_span': span_flg1 === '1' }" @click="spanflg(0)">#커플추천</span>
					<span class="font_air bold pointer" :class="{ 'region_span': span_flg2 === '1' }" @click="spanflg(1)">#친구끼리</span>
					<span class="font_air bold pointer" :class="{ 'region_span': span_flg3 === '1' }" @click="spanflg(2)">#가족들과</span>
					<span class="font_air bold pointer" :class="{ 'region_span': span_flg4 === '1' }" @click="spanflg(3)">#주차가능</span>
					<span class="font_air bold pointer" :class="{ 'region_span': span_flg5 === '1' }" @click="spanflg(4)">#무료</span>
				</div>
			</div>	
		</div>
		<div class="region_container" v-if="!regionnameflg&&!(searchflg)">
			<div class="region_container_header">
				<p class="region_p2">여 축제 어떻노?</p>
				<img src="/img/blue.png" class="region_container_header_img1">
			</div>
			<div class="region_container_list">
				<div class="region_container_body pointer" v-for="festival in recommendfestival" :key="festival">
					<router-link :to='"/detail?id="+festival.id'>
						<img :src="festival.img1" >
						<div class="region_title">{{ festival.title }}</div>
						<div class="region_content font_air bold">기간  :  {{ festival.start_at }} ~ {{ festival.end_at }}</div>
					</router-link>
					<div>
						<div v-if="indate(today,festival.start_at,festival.end_at)" class="region_date_msg1 font_air bold">진행중</div>
						<div v-else-if="beforedate(today, festival.start_at)" class="region_date_msg2 font_air bold">
							D-{{ d_day(festival.start_at) }}
						</div>
						<div v-else class="region_date_msg3 font_air bold">종료</div>
					</div>
				</div>
			</div>
		</div>
		<div class="region_container" v-if="!regionnameflg&&!(searchflg)">
			<div class="region_container_header">
				<p class="region_p2">저 관광지 어떻노?</p>
				<img src="/img/blue.png" class="region_container_header_img2">
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="tour in recommendtour" :key="tour">
					<router-link :to='"/detail?id="+tour.id'>
						<img :src="tour.img1">
						<div class="region_title">{{ tour.title }}</div>
						<div class="region_content font_air bold">{{ tour.content }}</div>
					</router-link>
				</div>
			</div>
		</div>
		<!-- <div class="region_sort">
			<button class="region_sort1 pointer">인기순</button> -->
			<!-- <div class="region_sort_line"></div> -->
			<!-- <button class="region_sort2 pointer">최신순</button>
		</div> -->
		<div class="region_container"  v-if="regionnameflg&&!(searchflg)">
			<div class="region_container_header">
				<span class="region_p2">{{ this.nowstate }}의 축제는? </span>
				<img src="/img/blue.png" class="region_container_header_img3">
			</div>
			<div class="region_container_list">
				<p v-if="this.regionfestival.length === 0" class="region_p5 font_air bold">검색된 결과물이 없습니다.</p>
				<div class="region_container_body" v-for="rfestival in regionfestival" :key="rfestival">
					<router-link :to='"/detail?id="+rfestival.id'>
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<img :src="rfestival.img1">
						<div class="region_title ">{{ rfestival.title }}</div>
						<div class="region_content font_air bold">기간 : {{ rfestival.start_at }} ~ {{ rfestival.end_at }}</div>
					</router-link>
					<div>
						<div v-if="indate(today,rfestival.start_at,rfestival.end_at)" class="region_date_msg1 font_air bold">진행중</div>
						<div v-else-if="beforedate(today, rfestival.start_at)" class="region_date_msg2 font_air bold">
							D-{{ d_day(rfestival.start_at) }}
						</div>
						<div v-else class="region_date_msg3 font_air bold">종료</div>
					</div>
				</div>
			</div>
		</div>
		<div class="region_container"  v-if="regionnameflg&&!(searchflg)">
			<div class="region_container_header">
				<span class="region_p2">{{ this.nowstate }}의 관광지는? </span>
				<img src="/img/blue.png" class="region_container_header_img4">
			</div>
			<div class="region_container_list" >
				<p v-if="this.regiontour.length === 0" class="region_p5 font_air bold">검색된 결과물이 없습니다.</p>
				<div class="region_container_body" v-for="rtour in regiontour" :key="rtour">
					<router-link :to='"/detail?id="+rtour.id'>
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<img :src="rtour.img1">
						<div class="region_title">{{ rtour.title }}</div>
						<div class="region_content font_air bold">{{ rtour.content }}</div>
					</router-link>
				</div>
			</div>
		</div>
		<div class="region_more_btn">
			<button class="pointer" v-if="regionnameflg&&!(searchflg)&&!((regionfestival.length === region_f_cnt)&&(regiontour.length === region_t_cnt))" @click="getMoreFestival()">더보기</button>
		</div>

		<div class="region_container" v-if="searchflg&&!(regionnameflg)">
			<div class="region_container_header">
				<span class="region_p2">여 축제 찾았나?</span>
				<img src="/img/blue.png" class="region_container_header_img1">
			</div>
			<div class="region_container_list">
				<p v-if="this.searchfestivalresult.length === 0" class="region_p5 font_air bold">검색된 결과물이 없습니다.</p>
				<div class="region_container_body" v-for="rfestival in searchfestivalresult" :key="rfestival">
					<router-link :to='"/detail?id="+rfestival.id'>
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<img :src="rfestival.img1">
						<div class="region_title ">{{ rfestival.title }}</div>
						<div class="region_content font_air bold">기간 : {{ rfestival.start_at }} ~ {{ rfestival.end_at }}</div>
					</router-link>
					<div>
						<div v-if="indate(today,rfestival.start_at,rfestival.end_at)" class="region_date_msg1 font_air bold">진행중</div>
						<div v-else-if="beforedate(today, rfestival.start_at)" class="region_date_msg2 font_air bold">
							D-{{ d_day(rfestival.start_at) }}
						</div>
						<div v-else class="region_date_msg3 font_air bold">종료</div>
					</div>
				</div>
			</div>
		</div>
		<div class="region_more_btn">
			<button class="pointer" v-if="!(searchfestivalresult.length=== search_f_cnt)&&searchmoreflg_f"  @click="MoreSearchFestival()">더보기</button>
		</div>
		<div class="region_container" v-if="searchflg&&!(regionnameflg)">
			<div class="region_container_header">
				<span class="region_p2">저 관광지 찾았나?</span>
				<img src="/img/blue.png" class="region_container_header_img2">
			</div>
			<div class="region_container_list" >
				<p v-if="this.searchtourresult.length === 0" class="region_p5 font_air bold">검색된 결과물이 없습니다.</p>
				<div class="region_container_body" v-for="rtour in searchtourresult" :key="rtour">
					<router-link :to='"/detail?id="+rtour.id'>
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<img :src="rtour.img1">
						<div class="region_title">{{ rtour.title }}</div>
						<div class="region_content font_air bold">{{ rtour.content }}</div>
					</router-link>
				</div>
			</div>
		</div>
		<div class="region_more_btn">
			<button class="pointer" v-if="!(searchtourresult.length === search_t_cnt)&&searchmoreflg_t"  @click="MoreSearchTour()">더보기</button>
		</div>
		<div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
	</div>
</template>
<script>
import axios from 'axios'
import { defineComponent } from 'vue'
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import Swal from 'sweetalert2';

export default {
	name: 'RegionComponent',
	data() {
		return {
			setting: '',
			states: [],
			recommendfestival: [],
			recommendtour: [],
			// 지역 축제 총갯수 
			region_f_cnt: 0, 
			// 지역 관광 총갯수 
			region_t_cnt: 0, 
			regionfestival: [],
			regiontour: [],
			morefestival: [],
			moretour: [],
			offset: 3, 
			nowstate: "", 
			// 현재지역
			nowns: "", 
			regionname: "",
			regionnameflg: false,
			searchflg: false,
			// 슬라이드 초기값
			item: 7,
			searchstate: "지역",
			startdate: "",
			enddate: "",
			searchkeyword: "",
			// 검색한 축제 정보저장
			searchfestivalresult: [],
			// 검색한 관광 정보저장
			searchtourresult: [],
			// 검색용 축제 더보기 플래그
			searchmoreflg_f: false,
			// 검색용 관광 더보기 플래그
			searchmoreflg_t: false,
			// 오늘
			today: "",
			// 검색용 축제 오프셋
			searchoffset_f: 6, 
			// 검색용 관광 오프셋
			searchoffset_t: 6,
			// 검색용 축제 총갯수 
			search_f_cnt: 0, 
			// 검색용 관광 총갯수 
			search_t_cnt: 0, 
			span_flg1: "0", 
			span_flg2: "0", 
			span_flg3: "0", 
			span_flg4: "0", 
			span_flg5: "0", 
			statearr : { "경산시": 1, "경주시": 2, "고령군": 3,"구미시": 4,"김천시": 5, "봉화군": 6, "문경시": 7, "상주시": 8, "성주군": 9, "안동시": 10, "영덕군": 11, "영양군": 12, "영주시": 13, "영천시": 14, "포항시": 15, "예천군": 16, "울릉군": 17, "울진군": 18, "의성군": 19, "청도군": 20, "청송군": 21, "칠곡군": 22, "거제시": 23, "김해시": 24, "밀양시": 25, "사천시": 26, "양산시": 27, "진주시": 28, "창원시": 29, "통영시": 30, "거창군": 31, "고성군": 32, "남해군": 33, "산청군": 34, "의령군": 35, "함안군": 36, "창녕군": 37, "하동군": 38, "함양군": 39, "합천군": 40, "군위군": 41}
		}
	},
	components: {
		Carousel,
		Slide,
		Pagination,
		Navigation,
  	},
	created() {
		// 오늘날짜셋팅
		this.getToday();
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowns = objUrlParam.get('ns')
		// 파라미터의 ns를 확인해서 store의 NsFlg셋팅
		// url의 파라미터 중 ns를 세팅함
		if(this.nowns==="경상남도"){
			this.$store.commit('setNsFlg','1');
		}else if(this.nowns==="경상북도"){
			this.$store.commit('setNsFlg','2');
		}
		this.getState( objUrlParam.get('ns') );
		this.getRecommendFestival(objUrlParam.get('ns'));
		// 로컬스토리지에 저장된 정보있는지 확인
		let boo = localStorage.getItem('nick') ?  true : false;
		this.$store.commit('setLocalFlg', boo);
	},
	watch: {
		// 넣은이유 -> 검색하고나서 더보기 클릭할때 v-model로 데이터 바인딩 된 정보를 기준으로 추가 조회하는대
		// 				만약 데이터바인딩된 값이 바뀌면 다른 조건을 추가조회해서 기존정보와 다른 조건의정보가
		// 				조회되니 조건 변경시 더보기 버튼이 사라지게 설계
		searchstate(){
			this.changeSearchFlg()
		},
		startdate(){
			this.changeSearchFlg()
		},
		enddate(){
			this.changeSearchFlg()
		},
		searchkeyword(){
			this.changeSearchFlg()
		},
	},
	mounted() {
		// 오늘날짜
		this.getToday();
		// 화면 크기에 따라 item 업데이트
		this.updateItem();
		window.addEventListener("resize", this.updateItem);

		// 이전다음버튼css
		const myCarousel = this.$refs.myCarousel;
		const prevButton = myCarousel.$el.querySelector('.carousel__prev');
		const nextButton = myCarousel.$el.querySelector('.carousel__next');

		if (prevButton && nextButton) {
			prevButton.style.left = '-25px';
			nextButton.style.right = '-25px';
		}
	},
	beforeDestroy() {
		// 컴포넌트가 파괴되기 전에 이벤트 리스너 제거
		window.removeEventListener("resize", this.updateItem);
	},
	beforeRouteUpdate(){
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowns = objUrlParam.get('ns')==="경상남도"? "경상북도":"경상남도";
		// 파라미터의 ns를 확인해서 store의 NsFlg셋팅
		// url의 파라미터 중 ns를 세팅함
		if(this.nowns==="경상남도"){
			this.$store.commit('setNsFlg','1');
		}else if(this.nowns==="경상북도"){
			this.$store.commit('setNsFlg','2');
		}
		this.getState( this.nowns );
		this.searchstate = "지역";
		this.getRecommendFestival(this.nowns);
		this.regionnameflg= false;
		this.searchflg= false;
	},
	methods: {
		// 시군명 가져오기
		getState(ns){
			// 해당url의 데이터 가져오기
			const URL = '/region/state?ns='+ ns;
			// 헤더에서 클릭시 url 설정됨(ns에 남도/북도 설정됨)

			axios.get(URL)
			// axios는 http status code가 200번대면 then으로, 그외에는 catch로
			.then(res => {
				if(res.data.code === '0') {
					this.states = res.data.data;
				} else {
					this.$router.push('/error');
				}
			})
			.catch(err => {
        		this.$router.push('/error');
			})
		},
		// 추천축제관광지 가져오기
		getRecommendFestival(ns) {
			// 로딩시작
			this.$store.commit('setLoading',true);
			const URL = '/region/recommendf?ns='+ ns+'&today='+this.today;
			axios.get(URL)
			.then(res => {
				this.recommendfestival = res.data.rfestival;
				this.recommendtour = res.data.rtour;
			})
			.catch(err => {
				// 로딩종료
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '데이터 에러 발생.',
                    confirmButtonText: '확인'
                })

			
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},	
		// 지역축제관광지 가져오기
		getRegionfestival(state) {
			// 로딩시작
			this.$store.commit('setLoading',true);
			const URL = '/region/festivalget/'+state;
			axios.get(URL)
			.then(res => {
				this.offset = 3;
				this.nowstate = state;
				this.regionfestival = res.data.sfestival;
				this.regiontour = res.data.stour;
				this.searchflg = false;
				this.searchmoreflg_t = false;
				this.searchmoreflg_f = false;
				// 지역축제 총 갯수
				this.region_f_cnt = res.data.f_cnt;
				// 지역관광 총 갯수
				this.region_t_cnt = res.data.t_cnt;
				this.regionnameflg = true;
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '데이터 에러 발생',
                    confirmButtonText: '확인'
                })
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 더보기 지역축제,관광지 가져오기
		getMoreFestival() {
			// 로딩시작
			this.$store.commit('setLoading',true);
			this.searchflg = false;
			const URL = '/region/morefestivalget?states_name='+this.nowstate+'&offset='+this.offset;
			axios.get(URL)
			.then(res => {

				// 중복된 속성을 허용하고 그대로 합침				
				this.regionfestival = [ ...this.regionfestival, ...res.data.mfestival ];
				this.regiontour = [ ...this.regiontour, ...res.data.mtour ];
				this.offset = this.offset + 3;
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '데이터 에러 발생',
                    confirmButtonText: '확인'
                })
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 검색 결과 가져오기
		searchFestival() {
			// 조건 1 검색조건 아무것도 없이 클릭시
			if (this.searchstate === "지역"&&this.startdate===""&&this.enddate===""&&this.searchkeyword===""&&this.span_flg1==='0'&&this.span_flg2==='0'&&this.span_flg3==='0'&&this.span_flg4==='0'&&this.span_flg5==='0') {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '검색조건을 최소 1개이상 입력해 주세요.',
                    confirmButtonText: '확인'
                })
			// 조건 2 시작일자보다 종료일자가 과거일시
			}else if(this.startdate > this.enddate&&this.startdate!==""&&this.enddate!==""){
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '종료일자를 시작일자 보다 크게 설정해 주세요.',
                    confirmButtonText: '확인'
                })
			}else{
				// 로딩시작
				this.$store.commit('setLoading',true);
				// 더보기를 눌렀을수도 있어서 오프셋 전체 초기화
				this.searchoffset_f= 6;	
				this.searchoffset_t= 6;
				// this.searchfilter = "";
				// if(this.searchstate !== ""){
					// 	this.searchfilter=this.searchfilter+" 지역 = "+this.searchstate
					// }
					// if(this.startdate !== ""){
						// 	this.searchfilter=this.searchfilter+this.startdate+" 부터 "
						// }
						// if(this.enddate !== ""){
							// 	this.searchfilter=this.searchfilter+this.enddate+" 까지 "
							// }
							// if(this.searchkeyword !== ""){
								// 	this.searchfilter=this.searchfilter+" 검색어 = "+this.searchkeyword
								// }
								// 1227 수정 최정훈 검색결과 남기기만들었는대 생각보다 못생김
				const URL = '/region/searchkeyword?states_name='+this.searchstate+'&start_at='+this.startdate+'&end_at='+this.enddate+'&searchkeyword='+this.searchkeyword+'&ns='+this.nowns+'&couple_flg='+this.span_flg1+'&friend_flg='+this.span_flg2+'&family_flg='+this.span_flg3+'&parking_flg='+this.span_flg4+'&fee='+this.span_flg5
				axios.get(URL)
				.then(res => {
					// 검색된 축제정보 저장
					this.searchfestivalresult = res.data.festival;
					// 검색된 관광정보 저장
					this.searchtourresult = res.data.tour;
					// 검색된 축제 갯수 저장
					this.search_f_cnt = res.data.f_cnt;
					// 검색된 관광 갯수 저장
					this.search_t_cnt = res.data.t_cnt;
					// 검색된 축제정보가 있을때 더보기버튼 활성화
					if(this.searchfestivalresult.length > 0){
						this.searchmoreflg_f = true
					}
					// 검색된 관광정보가 있을때 더보기버튼 활성화
					if(this.searchtourresult.length > 0){
						this.searchmoreflg_t = true
					}
					// if (this.searchstate === ""&&this.searchkeyword==="") {
					// 	this.searchtourresult =	[]
					// }
					this.regionnameflg = false;
					this.searchflg = true;
				})
				.catch(err => {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '데이터 에러 발생.',
						confirmButtonText: '확인'
					})
				})
				.finally(() => {
					this.$store.commit('setLoading', false);
				});
			}
		},
		// 검색 축제 더보기
		MoreSearchFestival() {	
			// 로딩시작
			this.$store.commit('setLoading',true);		
			const URL =  '/region/moresearchf?states_name='+this.searchstate+'&start_at='+this.startdate+'&end_at='+this.enddate+'&searchkeyword='+this.searchkeyword+'&offset='+this.searchoffset_f+'&ns='+this.nowns+'&couple_flg='+this.span_flg1+'&friend_flg='+this.span_flg2+'&family_flg='+this.span_flg3+'&parking_flg='+this.span_flg4+'&fee='+this.span_flg5
			axios.get(URL)
			.then(res => {
				if(res.data.code==="0"){	
					this.searchfestivalresult = [ ...this.searchfestivalresult, ...res.data.festival ];
					this.searchoffset_f = this.searchoffset_f + 6;
				}
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '데이터 에러 발생',
                    confirmButtonText: '확인'
                })
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});	
		},
		// 검색 관광 더보기
		MoreSearchTour() {			
			// 로딩시작
			this.$store.commit('setLoading',true);		
			const URL =  '/region/moresearcht?states_name='+this.searchstate+'&start_at='+this.startdate+'&end_at='+this.enddate+'&searchkeyword='+this.searchkeyword+'&offset='+this.searchoffset_t+'&ns='+this.nowns+'&couple_flg='+this.span_flg1+'&friend_flg='+this.span_flg2+'&family_flg='+this.span_flg3+'&parking_flg='+this.span_flg4+'&fee='+this.span_flg5
			axios.get(URL)
			.then(res => {
				if(res.data.code==="0"){	
					this.searchtourresult = [ ...this.searchtourresult, ...res.data.tour ];
					this.searchoffset_t = this.searchoffset_t + 6;
				}
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '데이터 에러 발생',
                    confirmButtonText: '확인'
                })
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 반응형으로 item값 수정
		updateItem() {
			// 화면 크기에 따라 itemsToShow를 조절
			if (window.innerWidth <= 607) {
				this.item = 3;
			} else if (window.innerWidth <= 747) {
				this.item = 4;
			} else if (window.innerWidth <= 904) {
				this.item = 5;
			} else if (window.innerWidth <= 1024) {
				this.item = 6;
			} else{
				this.item = 7;
			}
		},
		// 오늘날짜함수
		indate(date, startDate, endDate) {
			const today = new Date(date);
			const start = new Date(startDate);
			const end = new Date(endDate);
			return today >= start && today <= end;
		},
		beforedate(date, startDate) {
			const today = new Date(date);
			const start = new Date(startDate);
			return today < start;
		},
		d_day(startDate) {
			const startday = new Date(startDate).getTime();
			const today = new Date(this.today).getTime();
			const result = startday - today;
			const d_day = Math.ceil(result / (1000 * 3600 * 24));
			return d_day;
		},
		getToday() {
			const now = new Date();
			const year = now.getFullYear();
			const month = String(now.getMonth() + 1).padStart(2, '0');
			const day = String(now.getDate()).padStart(2, '0');
			this.today = `${year}-${month}-${day}`;
		},
		changeSearchFlg() {
			this.searchmoreflg_f = false
			this.searchmoreflg_t = false
		},
		koreachk(e) {
			this.searchkeyword = e.target.value;
		},
		spanflg(flg) {
			let arr = ['span_flg1', 'span_flg2', 'span_flg3', 'span_flg4', 'span_flg5'];
			if(this[arr[flg]]==="0"){
				this[arr[flg]]="1";
			}else{
				this[arr[flg]]="0";
			}
		}
	}
}
</script>

<style scoped>
.carousel__slide {
	padding: 5px 10px;
}

.carousel__viewport {
	perspective: 2000px;
}

.carousel__track {
	transform-style: preserve-3d;
}

.carousel__slide--sliding {
	transition: 0.5s;
}

.carousel__slide {
	opacity: 0.9;
	transform: rotateY(-20deg) scale(0.9);
}

.carousel__slide--active ~ .carousel__slide {
	transform: rotateY(20deg) scale(0.9);
}

.carousel__slide--prev {
	opacity: 1;
	transform: rotateY(-10deg) scale(0.95);
}

.carousel__slide--next {
	opacity: 1;
	transform: rotateY(10deg) scale(0.95);
}

.carousel__slide--active {
	opacity: 1;
	transform: rotateY(0) scale(1.1);
}
</style>