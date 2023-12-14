<template>
	<div class="region_frame">
		<div class="region_slider_frame">
			<div class="region_slider_container">
				<div class="region_slider" :style="{ transform: 'translateX(' + slidePosition + 'px)' }">
					<div class="region_slide" v-for="(item, index) in items" :key="index">{{ item }}</div>
				</div>
				<img class="region_slider_left" src="/img/prev.png" @click="prevSlide">
				<img class="region_slider_right" src="/img/next.png" @click="nextSlide">
			</div>
		</div>
		<div class="region_search">
			<form class="region_search_form" action="">
				<select name="region_select_list" id="region_select_list">
					<option selected>지역</option>
					<option value="Gyeongju">경주시</option>
					<option value="Pohang">포항시</option>
					<option value="Yeongcheon">영천시</option>
					<option value="Gimcheon">김천시</option>
					<option value="Andong">안동시</option>
					<option value="Gumi">구미시</option>
					<option value="Yeongju">영주시</option>
					<option value="Mungyeong">문경시</option>
				</select>
				<input class="region_date" v-model="startDate" type="date" value="2023-01-01">
				-
				<input class="region_date" v-model="endDate" type="date" value="2023-12-31">
				<button class="region_form_btn" @click="getSelectedDates()">검색</button>
				<br>
				<input class="region_text" type="text" placeholder="키워드로 검색 해 보세요">
				<button class="region_form_btn" type="submit">검색</button>
			</form>
		</div>
		<div class="region_list_frame">
			<div class="region_recommend">
				<div class="region_recommend_festival">
					<div class="region_comment">
						<p class="region_p1">이런 축제</p>
						<p class="region_p2">추천드려요</p>
					</div>
					<div class="region_list">
						<div class="region_img">
							<a href=""><img src="/img/jjangu.jpg" alt=""></a>
						</div>
						<div class="region_title">
							<a href="">추천축제제목1</a>
						</div>
						<div class="region_period">20231212-20231212</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<a href=""><img src="/img/jjangu.jpg" alt=""></a>
						</div>
						<div class="region_title">
							<a href="">추천축제제목2</a>
						</div>
						<div class="region_period">내용2</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<a href=""><img src="/img/jjangu.jpg" alt=""></a>
						</div>
						<div class="region_title">
							<a href="">추천축제제목3</a>
						</div>
						<div class="region_period">내용3</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<a href=""><img src="/img/jjangu.jpg" alt=""></a>
						</div>
						<div class="region_title">
							<a href="">추천축제제목4</a>
						</div>
						<div class="region_period">내용4</div>
					</div>
				</div>
				<div class="region_recommend_tour">
					<div class="region_comment">
						<p class="region_p1">이런 관광지</p>
						<p class="region_p2">추천드려요</p>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_2.jpg" alt="">
						</div>
						<div class="region_title">추천관광지제목1</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_2.jpg" alt="">
						</div>
						<div class="region_title">추천관광지제목2</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_2.jpg" alt="">
						</div>
						<div class="region_title">추천관광지제목3</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_2.jpg" alt="">
						</div>
						<div class="region_title">추천관광지제목4</div>
					</div>
				</div>
			</div>
			<div class="region_total">
				<div class="region_total_line">
					<div class="region_total_cityname">
						지역명
					</div>
					<div class="region_total_citycomment">
						지역별로 추천 해 드릴게요!
					</div>
				</div>
				<div class="region_total_festival">
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_3.jpg" alt="">
						</div>
						<div class="region_title">지역축제제목1</div>
						<div class="region_period">내용1</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_3.jpg" alt="">
						</div>
						<div class="region_title">지역축제제목2</div>
						<div class="region_period">내용2</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_3.jpg" alt="">
						</div>
						<div class="region_title">지역축제제목3</div>
						<div class="region_period">내용3</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_3.jpg" alt="">
						</div>
						<div class="region_title">지역축제제목4</div>
						<div class="region_period">내용4</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
				</div>
				<div class="region_total_tour">
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_4.jpg" alt="">
						</div>
						<div class="region_title">지역관광지제목1</div>
						<div class="region_period">내용1</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_4.jpg" alt="">
						</div>
						<div class="region_title">지역관광지제목2</div>
						<div class="region_period">내용2</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_4.jpg" alt="">
						</div>
						<div class="region_title">지역관광지제목3</div>
						<div class="region_period">내용3</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<img src="/img/item_4.jpg" alt="">
						</div>
						<div class="region_title">지역관광지제목4</div>
						<div class="region_period">내용4</div>
						<button href="#" class="region_heart"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
				</div>
			</div>
		</div>
		<div class="region_btn_more">
			<button>더보기</button>
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
			slidePosition: 0
		}
	},
	methods: {
		nextSlide() {
		this.slidePosition -= 1000;
		},
		prevSlide() {
		this.slidePosition += 1000;
		},
		getSelectedDates() {
          var startDate = this.startDate;
          var endDate = this.endDate;
        }
	}
}
</script>
<style>

</style>