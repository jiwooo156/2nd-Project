<template>
	<div class="region_frame">
		<div class="region_header_frame">
			<div class="region_slider_container">
				<Carousel :itemsToShow="6" :wrapAround="true" :transition="800" :autoplay="2000">
					<Slide v-for="state in states" :key="state">
						<router-link to="main" class="carousel__item">{{ state.states_name }}</router-link>
					</Slide>
					<template #addons>
						<Pagination />
					</template>
				</Carousel>
			</div>
			<div class="region_search_frame center">
				<div>
					<select id="region_select_list">
						<option>지역</option>
						<option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
					</select>
					<input type="date" class="region_date" ref="currentdate" v-model="currentDates">
					-
					<input type="date" class="region_date" ref="currentdate" v-model="currentDates">
				</div>
				<div>
					<input type="text" class="region_search_text" placeholder="키워드로 검색 해 보세요">
					<button type="submit" class="region_form_btn pointer">검색</button>
				</div>
			</div>		
		</div>
		<div class="region_container">
			<div class="region_container_header">
				<p class="region_p1">이런 축제</p>
				<p class="region_p2">추천드려요</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="festival in recommendfestival" :key="festival">
					<img :src="festival.img1" >
					<div class="region_title">{{  festival.title }}</div>
					<div class="region_content">{{ festival.content }}</div>
				</div>
			</div>
		</div>
		<div class="region_container">
			<div class="region_container_header">
				<p class="region_p1">이런 관광지</p>
				<p class="region_p2">추천드려요</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body" v-for="tour in recommendtour" :key="tour">
					<img :src="tour.img1">
					<div class="region_title">{{ tour.title }}</div>
					<div class="region_content">{{ tour.content }}</div>
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
				<p class="region_p4">{해당지역}의 축제를 여기에서 확인 해 보세요!</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body">
					<img src="/img/item_3.jpg">
					<!-- <div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div> -->
					<div class="region_title">지역축제제목</div>
					<div class="region_content">지역축제기간</div>
				</div>
				<!-- <div class="region_container_body">
					<img src="/img/item_3.jpg">
					<div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div>
					<div class="region_title">지역축제제목</div>
					<div class="region_content">지역축제기간</div>
				</div>
				<div class="region_container_body">
					<img src="/img/item_3.jpg">
					<div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div>
					<div class="region_title">지역축제제목</div>
					<div class="region_content">지역축제기간</div>
				</div>
				<div class="region_container_body">
					<img src="/img/item_3.jpg">
					<div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div>
					<div class="region_title">지역축제제목</div>
					<div class="region_content">지역축제기간</div>
				</div> -->
			</div>
		</div>
		<div class="region_container">
			<div class="region_container_header2">
				<p class="region_p4">{해당지역}의 관광지를 여기에서 확인 해 보세요!</p>
			</div>
			<div class="region_container_list">
				<div class="region_container_body">
					<img src="/img/item_4.jpg">
					<div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div>
					<div class="region_title">지역관광지제목</div>
					<div class="region_content">지역관광지위치</div>
				</div>
				<div class="region_container_body">
					<img src="/img/item_4.jpg">
					<div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div>
					<div class="region_title">지역관광지제목</div>
					<div class="region_content">지역관광지위치</div>
				</div>
				<div class="region_container_body">
					<img src="/img/item_4.jpg">
					<div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></div>
					<div class="region_title">지역관광지제목</div>
					<div class="region_content">지역관광지위치</div>
				</div>
				<div class="region_container_body">
					<img src="/img/item_4.jpg">
					<div class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']"/></div>
					<div class="region_title">지역관광지제목</div>
					<div class="region_content">지역관광지위치</div>
				</div>
			</div>
		</div>
		<div class="region_more_btn">
			<button class="pointer">더보기</button>
		</div>
	</div>
</template>
<script>
import { defineComponent } from 'vue'
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

export default {
	name: 'RegionComponent',
	data() {
		return {
			setting: '',
			// items: ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5', 'Item 6', 'Item 7', 'Item 8', 'Item 9', 'Item 10', 'Item 11', 'Item 12', 'Item 13', 'Item 14', 'Item 15', 'Item 16'],
			cities: ['경주시', '포항시', '영천시'],
			currentDates: this.getTodayFormatted(),
			states: [],
			recommendfestival: [],
			recommendtour: [],
		}
	},
	components: {
		Carousel,
		Slide,
		Pagination,
  	},
	created() {
		this.getState(),
		this.getRecommendFestival(),
		this.getRecommendTour()
	},
	updated() {
		this.getState()
	},
	mounted() {
		this.$refs.currentdate.value = new Date().toISOString().slice(0, 8);
	},
	methods: {
		getTodayFormatted() {
			const today = new Date();
			const year = today.getFullYear();
			const month = (today.getMonth() + 1).toString().padStart(2, '0');
			const day = today.getDate().toString().padStart(2, '0');
			return '${year}-${month}-${day}';
		},
		// 시군명 가져오기
		getState(){
			// 현재url가져오기
            let params = new URLSearchParams(window.location.search);
            let ns = params.get('ns');
			// 해당url의 데이터 가져오기
			const URL = '/region/state/'+ns
			axios.get(URL)
			.then(res => {
        		console.log("댄");
				this.states =res.data.data;
				console.log(res.data.data);
				console.log(this.states);
			})
			.catch(err => {
        		console.log("캐치");
				alert("데이터 에러 발생")
			})
		},
		// 추천축제 가져오기
		getRecommendFestival() {
			// 현재url 가져오기
			const URL = '/region/recommendf'
			axios.get(URL)
			.then(res => {
				console.log("댄");
				this.recommendfestival = res.data.rfestival;
				console.log(res.data.rfestival);
				console.log(this.recommendfestival);
			})
			.catch(err => {
				console.log("캐치");
				alert("데이터 에러 발생")
			})
		},
		// 추천관광지 가져오기
		getRecommendTour() {
			// 현재url 가져오기
			const URL = '/region/recommendf'
			axios.get(URL)
			.then(res => {
				console.log("댄");
				this.recommendtour = res.data.rtour;
				console.log(res.data.rfestival);
				console.log(this.recommendtour);
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