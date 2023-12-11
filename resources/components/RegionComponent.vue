<template>
	<div class="region_frame">
		<div class="login_header">
			<router-link :to="'/main'" class="login_header_a pointer">이의이승</router-link>
		</div>
		<div class="region_slide">
			<a href="">화살표왼쪽</a>
			<ul class="region_slide_list">
				<li><a href="">경주시</a></li>
				<li><a href="">포항시</a></li>
				<li><a href="">영천시</a></li>
				<li><a href="">김천시</a></li>
				<li><a href="">안동시</a></li>
				<li><a href="">구미시</a></li>
				<li><a href="">영주시</a></li>
				<li><a href="">문경시</a></li>				
			</ul>
			<a href="">화살표오른쪽</a>
			<div v-for="(item, index) in items" :key="index" :style="{ transform: `translateX(${currentIndex * -100}%)` }">
				{{ item.text }}
			</div>
			<button @click="prevSlide">이전</button>
			<button @click="nextSlide">다음</button>
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
				<input type="date" value="2023-12-31">
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
			더보기 버튼 js로 구현
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
			items: [
				{ id: 1, text: 'Slide 1' },
				{ id: 2, text: 'Slide 2' },
				{ id: 3, text: 'Slide 3' },
			],
			currentIndex: 0,
		}
	},
	methods: {
		prevSlide() {
			this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
		},
		nextSlide() {
			this.currentIndex = (this.currentIndex + 1) % this.items.length;
		},
	}
}
</script>