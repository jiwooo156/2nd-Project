<template>
	<div class="region_frame">
		<div class="region_header_frame">
			<div class="region_slider_container">
				<div class="region_slider" :style="{ transform: 'translateX(' + slidePosition + 'px)' }">
					<div class="region_slide" v-for="(item, index) in items" :key="index">{{ item }}</div>
				</div>
				<div><img class="region_slider_left pointer" src="/img/prev.png" @click="prevslide"></div>
				<div><img class="region_slider_right pointer" src="/img/next.png" @click="nextslide"></div>
			</div>
			<div class="region_search_frame">
				<div>
					<select id="region_select_list">
						<option>지역</option>
						<option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
					</select>
					<input type="date" id="region_date" :value="'2023-01-01'">
					-
					<input type="date" id="region_date" :value="'2023-12-31'">
					<br>
					<input type="text" class="region_search_text" placeholder="키워드로 검색 해 보세요">
					<button type="submit" class="region_form_btn pointer">검색</button>
				</div>
			</div>
		</div>
		<div class="region_recommend_festival_frame">
			<div class="region_comment">
				<p class="region_p1">이런 축제</p>
				<p class="region_p2">추천드려요</p>
			</div>
			<div class="region_recommend_festival">
				<div class="region_recom_festiv">
					<img src="/img/item_1.jpg">
					<div class="region_recom_festiv_title">추천축제제목</div>
					<div class="region_recom_festiv_period">추천축제기간</div>
				</div>
				<div class="region_recom_festiv">
					<img src="/img/item_1.jpg">
					<div class="region_recom_festiv_title">추천축제제목</div>
					<div class="region_recom_festiv_period">추천축제기간</div>
				</div>
				<div class="region_recom_festiv">
					<img src="/img/item_1.jpg">
					<div class="region_recom_festiv_title">추천축제제목</div>
					<div class="region_recom_festiv_period">추천축제기간</div>
				</div>
				<div class="region_recom_festiv">
					<img src="/img/item_1.jpg">
					<div class="region_recom_festiv_title">추천축제제목</div>
					<div class="region_recom_festiv_period">추천축제기간</div>
				</div>
			</div>
		</div>
		<div class="region_recommend_tour_frame">
			<div class="region_comment">
				<p class="region_p1">이런 관광지</p>
				<p class="region_p2">추천드려요</p>
			</div>
			<div class="region_recommend_tour">
				<div class="region_recom_tour">
					<img src="/img/item_2.jpg">
					<div class="region_recom_tour_title">추천관광지제목</div>
					<div class="region_recom_tour_place">추천관광지위치</div>
				</div>
				<div class="region_recom_tour">
					<img src="/img/item_2.jpg">
					<div class="region_recom_tour_title">추천관광지제목</div>
					<div class="region_recom_tour_place">추천관광지위치</div>
				</div>
				<div class="region_recom_tour">
					<img src="/img/item_2.jpg">
					<div class="region_recom_tour_title">추천관광지제목</div>
					<div class="region_recom_tour_place">추천관광지위치</div>
				</div>
				<div class="region_recom_tour">
					<img src="/img/item_2.jpg">
					<div class="region_recom_tour_title">추천관광지제목</div>
					<div class="region_recom_tour_place">추천관광지위치</div>
				</div>
			</div>
		</div>
		<div class="region_sort">
			<button class="region_sort1 pointer">인기순</button>
			<!-- <div class="region_sort_line"></div> -->
			<button class="region_sort2 pointer">최신순</button>
		</div>
		<div class="region_total_festival_frame">
			<div class="region_total_festival_msg">
				<p class="region_p4">{해당지역}의 축제를 여기에서 확인 해 보세요!</p>
			</div>
			<div class="region_festival_container">
				<div class="region_festival">
					<img src="/img/item_3.jpg">
					<div class="region_festival_title">지역축제제목</div>
					<div class="region_festival_period">지역축제기간</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
				<div class="region_festival">
					<img src="/img/item_3.jpg">
					<div class="region_festival_title">지역축제제목</div>
					<div class="region_festival_period">지역축제기간</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
				<div class="region_festival">
					<img src="/img/item_3.jpg">
					<div class="region_festival_title">지역축제제목</div>
					<div class="region_festival_period">지역축제기간</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
				<div class="region_festival">
					<img src="/img/item_3.jpg">
					<div class="region_festival_title">지역축제제목</div>
					<div class="region_festival_period">지역축제기간</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
			</div>
		</div>
		<div class="region_total_tour_frame">
			<div class="region_total_tour_msg">
				<p class="region_p4">{해당지역}의 관광지를 여기에서 확인 해 보세요!</p>
			</div>
			<div class="region_tour_container">
				<div class="region_tour">
					<img src="/img/item_4.jpg">
					<div class="region_tour_title">지역관광지제목</div>
					<div class="region_tour_place">지역관광지위치</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
				<div class="region_tour">
					<img src="/img/item_4.jpg">
					<div class="region_tour_title">지역관광지제목</div>
					<div class="region_tour_place">지역관광지위치</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
				<div class="region_tour">
					<img src="/img/item_4.jpg">
					<div class="region_tour_title">지역관광지제목</div>
					<div class="region_tour_place">지역관광지위치</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
				<div class="region_tour">
					<img src="/img/item_4.jpg">
					<div class="region_tour_title">지역관광지제목</div>
					<div class="region_tour_place">지역관광지위치</div>
					<button type="submit" class="region_heart">좋아요</button>
				</div>
			</div>
		</div>
		<div class="region_more_btn">
			<button type="submit">더보기</button>
		</div>
	</div>
</template>
<script>
export default {
	name: 'RegionComponent',
	data() {
		return {
			setting: '',
			items: ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5', 'Item 6', 'Item 7', 'Item 8', 'Item 9', 'Item 10'],
			slidePosition: 0,
			cities: ['경주시', '포항시', '영천시'],
		}
	},

	created() {

	},

	methods: {
		nextSlide() {
		this.slidePosition -= 1000;
		},
		prevSlide() {
		this.slidePosition += 1000;
		},
	},
}
</script>
<style>
	
</style>