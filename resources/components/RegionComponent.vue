<template>
	<div class="region_frame">
		<div class="region_header_frame">
			<div class="region_slider_container">
				<Carousel :itemsToShow="6" :wrapAround="true" :transition="800" :autoplay="2000">
					<Slide v-for="state in states" :key="state">
						<div @click="getRegionfestival(state.states_name)" class="carousel__item pointer">{{ state.states_name }}</div>
					</Slide>
					<template #addons>
						<Pagination />
					</template>
				</Carousel>
			</div>
			<div class="region_search_frame center">
				<div>
					<select id="region_select_list" v-model="searchstate">
						<option>지역</option>
						<option v-for="state in states" :key="state">{{ state.states_name }}</option>
					</select>
						<input type="date" class="region_date" v-model="startdate">
						-
						<input type="date" class="region_date" v-model="enddate">
				</div>
				<div>
					<input type="text" class="region_search_text" v-model="searchkeyword" placeholder="키워드로 검색 해 보세요">
					<button @click="searchFestival()" class="region_form_btn pointer">검색</button>
				</div>
			</div>		
		</div>
		<div class="region_container" v-if="!regionnameflg&&!(searchflg)">
			<div class="region_container_header">
				<p class="region_p1">이런 축제</p>
				<p class="region_p2">추천드려요</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body pointer" v-for="festival in recommendfestival" :key="festival">
					<router-link :to='"/detail?id="+festival.id'>
						<img :src="festival.img1" >
						<div class="region_title">{{ festival.title }}</div>
						<div class="region_content">기간 : {{ festival.start_at }} ~ {{ festival.end_at }}</div>
					</router-link>
				</div>
			</div>
		</div>
		<div class="region_container" v-if="!regionnameflg&&!(searchflg)">
			<div class="region_container_header">
				<p class="region_p1">이런 관광지</p>
				<p class="region_p2">추천드려요</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="tour in recommendtour" :key="tour">
					<router-link :to='"/detail?id="+tour.id'>
						<img :src="tour.img1">
						<div class="region_title">{{ tour.title }}</div>
						<div class="region_content">{{ tour.content }}</div>
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
			<div class="region_container_header2">
				<p class="region_p4">{{ this.nowstate }}의 축제를 여기에서 확인 해 보세요!</p>
				<p v-if="this.regionfestival.length === 0" class="region_p4">검색된 결과물이 없습니다.</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="rfestival in regionfestival" :key="rfestival">
					<router-link :to='"/detail?id="+rfestival.id'>
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<img :src="rfestival.img1">
						<div class="region_title">{{ rfestival.title }}</div>
						<div class="region_content">기간 : {{ rfestival.start_at }} ~ {{ rfestival.end_at }}</div>
					</router-link>
				</div>
			</div>
		</div>
		<div class="region_container"  v-if="regionnameflg&&!(searchflg)">
			<div class="region_container_header2">
				<p class="region_p4">{{ this.nowstate }}의 관광지를 여기에서 확인 해 보세요!</p>
				<p v-if="this.regiontour.length === 0" class="region_p4">검색된 결과물이 없습니다.</p>
			</div>
			<div class="region_container_list" >
				<div class="region_container_body" v-for="rtour in regiontour" :key="rtour">
					<router-link :to='"/detail?id="+rtour.id'>
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<img :src="rtour.img1">
						<div class="region_title">{{ rtour.title }}</div>
						<div class="region_content">{{ rtour.content }}</div>
					</router-link>
				</div>
			</div>
		</div>
		<div class="region_more_btn">
			<button class="pointer" v-if="regionnameflg&&!(searchflg)&&!(moreflg)" @click="getMoreFestival()">더보기</button>
		</div>
		<div class="region_container" v-if="searchflg&&!(regionnameflg)">
			<div class="region_container_header2">
				<p v-if="this.searchresults.length > 0" class="region_p4">검색 결과 입니다.</p>
				<p v-if="this.searchresults.length === 0" class="region_p4">검색된 결과물이 없습니다.</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="searchfestival in searchresults" :key="searchfestival">
					<router-link :to='"/detail?id="+searchfestival.id'>
						<img :src="searchfestival.img1">
						<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
						<div class="region_title">{{ searchfestival.title }}</div>
						<div class="region_content">{{ searchfestival.content }}</div>
					</router-link>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import axios from 'axios'
import { defineComponent } from 'vue'
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

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
			moreflg: false,
			searchstate: "지역",
			// startdate: "2023-12-01",
			// enddate: "2023-12-31",
			startdate: "",
			enddate: "",
			searchkeyword: "",
			searchresults: [],
		}
	},
	components: {
		Carousel,
		Slide,
		Pagination,
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
		this.getRecommendFestival();
		console.log('create');
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
				console.log("getState");
				console.log("레스데이터"+res.data);

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
		getRecommendFestival() {
			const URL = '/region/recommendf'
			axios.get(URL)
			.then(res => {
				console.log("추천축제 댄");
				this.recommendfestival = res.data.rfestival;
				this.recommendtour = res.data.rtour;
				console.log(this.recommendfestival);
				console.log(this.recommendtour);
			})
			.catch(err => {
				console.log("캐치");
				alert("데이터 에러 발생")
			})
		},	
		// 지역축제관광지 가져오기
		getRegionfestival(state) {
			const URL = '/region/festivalget/'+state
			axios.get(URL)
			.then(res => {
				this.offset = 4;
				this.moreflg=false;
				console.log("지역축제 댄");
				console.log("현재지역 댄");
				this.nowstate = state;
				console.log(this.nowstate);
				console.log("축제정보");
				this.regionfestival = res.data.sfestival;
				console.log(this.regionfestival);
				console.log("타워 값넣기");
				this.regiontour = res.data.stour;
				console.log(this.regiontour);
				this.searchflg = false;
				this.regionnameflg = true;
			})
			.catch(err => {
				console.log("캐치");
				alert("데이터 에러 발생")
			})
		},
		// 더보기 지역축제,관광지 가져오기
		getMoreFestival() {
			console.log(this.nowstate)
			const URL = '/region/morefestivalget?states_name='+this.nowstate+'&offset='+this.offset
			console.log("현재주소"+this.nowstate);
			console.log("오프셋"+this.offset);
			axios.get(URL)
			.then(res => {
				if(res.data.mfestival.length === 0&&res.data.mtour.length === 0){
					alert("조회된 게시물이 없습니다")
					this.moreflg=true
				}
				console.log(res.data.mfestival);
				// 중복된 속성을 허용하고 그대로 합침				
				console.log("페스티발"+res.data.mfestival);
				console.log("관광"+res.data.mtour);
				console.log("원래잇던애");
				this.regionfestival = [ ...this.regionfestival, ...res.data.mfestival ];
				this.regiontour = [ ...this.regiontour, ...res.data.mtour ];
				console.log("추가한후");
				console.log(this.regiontour);
				this.offset = this.offset + 4;
			})
			.catch(err => {
				console.log("캐치");
				alert("데이터 에러 발생")
			})
		},
		// 검색 결과 가져오기
		searchFestival() {
			if(this.searchstate === "지역"){
				this.searchstate = "";
			}
			console.log(this.searchstate);
			const URL = '/region/searchkeyword?states_name='+this.searchstate+'&start_at='+this.startdate+'&end_at='+this.enddate+'&searchkeyword='+this.searchkeyword
			axios.get(URL)
			.then(res => {
				this.moreflg=false
				console.log("검색결과 댄");
				this.searchresults = res.data.searchresult;
				console.log(this.searchresults);
				this.regionnameflg = false;
				this.searchflg = true;
			})
			.catch(err => {
				console.log("캐치");
				alert("데이터 에러 발생")
			})
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