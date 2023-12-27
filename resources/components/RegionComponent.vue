<template>
	<div class="region_frame">
		<div class="region_header_frame">
			<div class="region_slider_container">
				<Carousel :itemsToShow="item" :wrapAround="true" :transition="400" :autoplay="4000" :mouseDrag="true" >
					<Slide v-for="state in states" :key="state">
						<div @click="getRegionfestival(state.states_name)" class="font_air bold carousel__item pointer">{{ state.states_name }}</div>
					</Slide>
					<template #addons>
						<navigation />
      					<pagination />
					</template>
				</Carousel>
			</div>
			<div class="region_search_frame">
				<div class="region_search_flex">
					<select class="region_select_list pointer" v-model="searchstate">
						<option class=" font_air bold">지역</option>
						<option v-for="state in states" :key="state" class=" font_air bold">{{ state.states_name }}</option>
					</select>
					<div>
						<input type="date" class="region_date font_air bold" v-model="startdate">
						<span class="font_air bold region_date_span">~</span>
						<input type="date" class="region_date font_air bold" v-model="enddate">
					</div>
				</div>
				<div class="region_relative">
					<input type="text" class="region_search_text  " v-model="searchkeyword" placeholder="키워드로 검색 해 보세요">
					<button @click="searchFestival()" class="region_form_btn pointer font_air bold">검색</button>
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
				<span class="region_p2">{{ this.nowstate }}의 축제는 </span><span class="region_p6 font_air bold">여서 확인해 보이소!</span>
				<img src="/img/blue.png" class="region_container_header_img3">
			</div>
			<div class="region_container_list">
				<p v-if="this.regionfestival.length === 0" class="region_p5 font_air bold">검색된 결과물이 없습니다.</p>
				<div class="region_container_body" v-for="rfestival in regionfestival" :key="rfestival">
					<router-link :to='"/detail?id="+rfestival.id'>
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<img :src="rfestival.img1">
						<div class="region_title ">{{ rfestival.title }}</div>
						<div class="region_content font_air bold">{{ this.nowdate }}기간 : {{ rfestival.start_at }} ~ {{ rfestival.end_at }}</div>
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
				<span class="region_p2">{{ this.nowstate }}의 관광지는 </span><span class="region_p6 font_air bold">여서 확인해 보이소!</span>
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
			<button class="pointer" v-if="regionnameflg&&!(searchflg)&&!(moreflg)" @click="getMoreFestival()">더보기</button>
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
						<div class="region_content font_air bold">{{ this.nowdate }}기간 : {{ rfestival.start_at }} ~ {{ rfestival.end_at }}</div>
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
	</div>
</template>
<script>
import axios from 'axios'
import { defineComponent } from 'vue'
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

export default {
	name: 'RegionComponent',
	data() {
		return {
			setting: '',
			states: [],
			recommendfestival: [],
			recommendtour: [],
			regionfestival: [],
			morefestival: [],
			regiontour: [],
			moretour: [],
			offset: 4, 
			nowstate: "", 
			regionname: "",
			regionnameflg: false,
			searchflg: false,
			item: 7, // 초기값 설정
			moreflg: false,
			searchstate: "지역",
			startdate: "",
			enddate: "",
			searchkeyword: "",
			searchfestivalresult: [],
			searchtourresult: [],
			today: new Date(),
			// searchfilter: "",
			// 1227 수정 최정훈 검색결과 남기기만들었는대 생각보다 못생김
		}
	},
	components: {
		Carousel,
		Slide,
		Pagination,
		Navigation,
  	},
	created() {
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);

		// 파라미터의 ns를 확인해서 store의 NsFlg셋팅
		// url의 파라미터 중 ns를 세팅함
		if(objUrlParam.get('ns')==="경상남도"){
			this.$store.commit('setNsFlg','1');
		}else if(objUrlParam.get('ns')==="경상북도"){
			this.$store.commit('setNsFlg','2');
		}
		this.getState( objUrlParam.get('ns') );
		this.getRecommendFestival(objUrlParam.get('ns'));
		// console.log('create');
	},
	mounted() {
		// 오늘날짜
    	this.getToday();
		// 화면 크기에 따라 itemsToShow를 동적으로 업데이트
		this.updateItem();
		window.addEventListener("resize", this.updateItem);
	},
	beforeDestroy() {
		// 컴포넌트가 파괴되기 전에 이벤트 리스너 제거
		window.removeEventListener("resize", this.updateItem);
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
				// console.log("getState");
				// console.log("레스데이터"+res.data);

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
			const URL = '/region/recommendf?ns='+ ns;
			axios.get(URL)
			.then(res => {
				console.log("추천축제 댄");
				this.recommendfestival = res.data.rfestival;
				this.recommendtour = res.data.rtour;
				console.log(this.recommendfestival);
				console.log(this.recommendtour);
			})
			.catch(err => {
				// console.log("캐치");
				alert("데이터 에러 발생");
			})
		},	
		// 지역축제관광지 가져오기
		getRegionfestival(state) {
			const URL = '/region/festivalget/'+state;
			axios.get(URL)
			.then(res => {
				this.offset = 4;
				this.moreflg=false;
				// console.log("지역축제 댄");
				// console.log("현재지역 댄");
				this.nowstate = state;
				// console.log(this.nowstate);
				// console.log("축제정보");
				this.regionfestival = res.data.sfestival;
				// console.log(this.regionfestival);
				// console.log("타워 값넣기");
				this.regiontour = res.data.stour;
				// console.log(this.regiontour);
				this.searchflg = false;
				this.regionnameflg = true;
			})
			.catch(err => {
				// console.log("캐치");
				alert("데이터 에러 발생");
			})
		},
		// 더보기 지역축제,관광지 가져오기
		getMoreFestival() {
			// console.log(this.nowstate)
			const URL = '/region/morefestivalget?states_name='+this.nowstate+'&offset='+this.offset;
			// console.log("현재주소"+this.nowstate);
			// console.log("오프셋"+this.offset);
			axios.get(URL)
			.then(res => {
				if(res.data.mfestival.length === 0&&res.data.mtour.length === 0){
					alert("조회된 게시물이 없습니다")
					// moreflg가 false일때 더보기버튼 활성화
					this.moreflg=true;
				}
				// console.log(res.data.mfestival);

				// 중복된 속성을 허용하고 그대로 합침				
				// console.log("페스티발"+res.data.mfestival);
				// console.log("관광"+res.data.mtour);
				// console.log("원래잇던애");
				this.regionfestival = [ ...this.regionfestival, ...res.data.mfestival ];
				this.regiontour = [ ...this.regiontour, ...res.data.mtour ];
				// console.log("추가한후");
				// console.log(this.regiontour);
				this.offset = this.offset + 4;
			})
			.catch(err => {
				// console.log("캐치");
				alert("데이터 에러 발생");
			})
		},
		// 검색 결과 가져오기
		searchFestival() {
			if (this.searchstate === "지역"&&this.startdate===""&&this.enddate===""&&this.searchkeyword==="") {
				alert("검색조건을 최소 1개이상 입력해 주세요.")
			}else if(this.startdate > this.enddate&&this.startdate!==""&&this.enddate!==""){
				alert("종료일자를 시작일자 보다 크게 설정해 주세요")
			}else{
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
				const URL = '/region/searchkeyword?states_name='+this.searchstate+'&start_at='+this.startdate+'&end_at='+this.enddate+'&searchkeyword='+this.searchkeyword
				axios.get(URL)
				.then(res => {
					this.moreflg=false
					console.log("검색결과 댄");
					this.searchfestivalresult = res.data.festival;
					this.searchtourresult = res.data.tour;
					if (this.searchstate === ""&&this.searchkeyword==="") {
						this.searchtourresult =	[]
					}
					this.regionnameflg = false;
					this.searchflg = true;
				})
				.catch(err => {
					console.log("캐치");
					alert("데이터 에러 발생")
				})
			}
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