<template>
	<div class="region_frame">
		<div class="region_header_frame">
			<div class="region_slider_container">
				<Carousel :itemsToShow="6" :wrapAround="true" :transition="800" :autoplay="2000">
					<Slide v-for="state in states1" :key="state" v-if="$store.state.nsFlg==='1'"
					>
						<div @click="getRegionfestival(state.states_name)" class="carousel__item pointer">{{ state.states_name }}</div>
					</Slide>
					<Slide v-for="state in states2" :key="state" v-if="$store.state.nsFlg==='2'"
					>
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
						<option v-for="state in states1" :key="state" :value="state" v-if="$store.state.nsFlg==='1'">{{ state.states_name }}</option>
						<option v-for="state in states2" :key="state" :value="state" v-if="$store.state.nsFlg==='2'">{{ state.states_name }}</option>
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
		<div class="region_container" v-if="!regionnameflg">
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
		<div class="region_container" v-if="!regionnameflg">
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
		<div class="region_sort">
			<button class="region_sort1 pointer">인기순</button>
			<!-- <div class="region_sort_line"></div> -->
			<button class="region_sort2 pointer">최신순</button>
		</div>
		<div class="region_container">
			<div class="region_container_header2">
				<p class="region_p4" v-if="regionnameflg">{{ this.regionname }}의 축제를 여기에서 확인 해 보세요!</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="rfestival in regionfestival" :key="rfestival">
					<img :src="rfestival.img1">
					<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
					<div class="region_title">{{ rfestival.title }}</div>
					<div class="region_content">기간 : {{ rfestival.start_at }} ~ {{ rfestival.end_at }}</div>
				</div>
			</div>
		</div>
		<div class="region_container">
			<div class="region_container_header2">
				<p class="region_p4" v-if="regionnameflg">{{ this.regionname }}의 관광지를 여기에서 확인 해 보세요!</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="rtour in regiontour" :key="rtour">
					<img :src="rtour.img1">
					<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
					<div class="region_title">{{ rtour.title }}</div>
					<div class="region_content">{{ rtour.content }}</div>
				</div>
			</div>
		</div>
		<div class="region_more_btn">
			<button class="pointer" v-if="regionnameflg" @click="getMoreFestival()">더보기</button>
		</div>
		<div class="region_container">
			<div class="region_container_header2">
				<p class="region_p4">검색 결과 입니다.</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="searchfestival in searchresults" :key="searchfestival">
					<img :src="searchfestival.img1">
					<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
					<div class="region_title">{{ searchfestival.title }}</div>
					<div class="region_content">{{ searchfestival.content }}</div>
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
			cities: ['경주시', '포항시', '영천시'],
			states1: [],
			states2: [],
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
			searchstate: "지역",
			startdate: "2023-12-01",
			enddate: "2023-12-31",
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
		if(new URLSearchParams(window.location.search).get('ns')==="경상남도"){
			this.$store.commit('setNsFlg','1')
		}else if(new URLSearchParams(window.location.search).get('ns')==="경상북도"){
			this.$store.commit('setNsFlg','2')
		}
		this.getState(),
		this.getRecommendFestival(),
		console.log('create');
	},
	mounted() {
	},
	updated() {
	},
	methods: {
		// 시군명 가져오기
		getState(){
			// 해당url의 데이터 가져오기
			const URL = '/region/state/'
			axios.get(URL)
			.then(res => {
        		console.log("댄");
				this.states1 = res.data.data1;
				this.states2 = res.data.data2;
				console.log(res.data.data);
				console.log(this.states);
			})
			.catch(err => {
        		console.log("캐치");
				alert("데이터 에러 발생")
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
				this.nowstate = state;
				console.log("지역축제 댄");
				this.regionfestival = res.data.sfestival;
				this.regiontour = res.data.stour;
				this.regionname = res.data.sfestival[0].states_name;
				console.log(this.regionfestival);
				console.log(this.regiontour);
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
				// 중복된 속성을 허용하고 그대로 합침				
				console.log("원래잇던애");
				console.log(this.regiontour);
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
			console.log(this.startdate);
			console.log(this.enddate);
			console.log(this.searchkeyword);
			console.log(this.searchstate);
			const URL = '/region/searchkeyword?states_name='+this.searchstate+'&start_at='+this.startdate+'&end_at='+this.enddate+'&searchkeyword='+this.searchkeyword
			axios.get(URL)
			.then(res => {
				console.log("검색결과 댄");
				this.searchresults = res.data.searchresult;
				console.log(this.searchresults);
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