<template>
	<div class="region_frame">
		<div class="login_header">
			<router-link :to="'/main'" class="login_header_a pointer">이의이승</router-link>
		</div>
		<div class="region_slider_frame">
			<div class="region_slider_container">
				<div class="region_slider" :style="{ transform: 'translateX(' + slidePosition + 'px)' }">
					<div class="region_slide" v-for="(item, index) in items" :key="index">{{ item }}</div>
				</div>
				<button class="region_slider_left" @click="prevSlide">Previous</button>
				<button class="region_slider_right" @click="nextSlide">Next</button>
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
				<input type="date" value="2023-01-01">
				-
				<input type="date" value="2023-12-31">
				<input type="submit">
				<br>
				<input type="textarea">
				<input type="submit">
			</form>
		</div>
		<div class="region_recommend">
			<div class="region_recommend_festival">
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_1.jpg" alt="">
					</div>
					<div class="region_title">제목1</div>
					<div class="region_period">내용1</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_1.jpg" alt="">
					</div>
					<div class="region_title">제목2</div>
					<div class="region_period">내용2</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_1.jpg" alt="">
					</div>
					<div class="region_title">제목3</div>
					<div class="region_period">내용3</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_1.jpg" alt="">
					</div>
					<div class="region_title">제목4</div>
					<div class="region_period">내용4</div>
				</div>
			</div>
			<div class="region_recommend_tour">
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_2.jpg" alt="">
					</div>
					<div class="region_title">제목1</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_2.jpg" alt="">
					</div>
					<div class="region_title">제목2</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_2.jpg" alt="">
					</div>
					<div class="region_title">제목3</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_2.jpg" alt="">
					</div>
					<div class="region_title">제목4</div>
				</div>
			</div>
		</div>
		<div class="region_total">
			<div class="region_total_festival">
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_3.jpg" alt="">
					</div>
					<div class="region_title">제목1</div>
					<div class="region_period">내용1</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_3.jpg" alt="">
					</div>
					<div class="region_title">제목2</div>
					<div class="region_period">내용2</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_3.jpg" alt="">
					</div>
					<div class="region_title">제목3</div>
					<div class="region_period">내용3</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_3.jpg" alt="">
					</div>
					<div class="region_title">제목4</div>
					<div class="region_period">내용4</div>
				</div>
			</div>
			<div class="region_total_tour">
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_4.jpg" alt="">
					</div>
					<div class="region_title">제목1</div>
					<div class="region_period">내용1</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_4.jpg" alt="">
					</div>
					<div class="region_title">제목2</div>
					<div class="region_period">내용2</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_4.jpg" alt="">
					</div>
					<div class="region_title">제목3</div>
					<div class="region_period">내용3</div>
				</div>
				<div class="region_list">
					<div class="region_img">
						<img src="/img/item_4.jpg" alt="">
					</div>
					<div class="region_title">제목4</div>
					<div class="region_period">내용4</div>
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
		}
	}
}
</script>
<style>

</style>