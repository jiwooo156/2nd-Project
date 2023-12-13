<template>
	<div class="region_frame">
		<div class="login_header">
			<router-link :to="'/main'" class="login_header_a pointer">이의이승</router-link>
		</div>
		<div class="region_slide">
			<ul class="region_slide_list">
				<!-- <li v-for="item in items" :key="item.id">
					{{ item.text }}
				</li>			 -->
				<li id="lastClone"><a href="">경주시</a></li>
				<li><a href="">포항시</a></li>
				<li><a href="">영천시</a></li>
				<li><a href="">김천시</a></li>
				<li><a href="">안동시</a></li>
				<li><a href="">구미시</a></li>
				<li><a href="">영주시</a></li>
				<li id="firstClone"><a href="">문경시</a></li>	
			</ul>
			<button id="region_slide_prev">prev</button>
			<button id="region_slide_next">next</button>
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
			// key: 0,
      		// infoList: [],
			// items: [
			// 	{ id: 1, text: 'Item 1' },
			// 	{ id: 2, text: 'Item 2' },
			// 	{ id: 3, text: 'Item 3' },
			// ],
		}
	},
	methods: {
	// 	goPrev() {
	// 		if (this.key !== 0) {
	// 			document.querySelector(".info-slide").classList.remove("next");
	// 			document.querySelector(".info-slide").classList.add("prev");
	// 			this.key -= 1;
	// 		}
    // },
	// 	goNext() {
	// 	if (this.key !== this.infoList.length - 1) {
	// 		document.querySelector(".info-slide").classList.remove("prev");
	// 		document.querySelector(".info-slide").classList.add("next");
	// 		this.key += 1;
	// 	}
    // },
		// addItem() {
		// const newItem = { id: Date.now(), text: 'New Item' };
		// this.items.push(newItem);
		// },
	}
}
	// const carouselSlide = document.querySelector('.region_slide_list');
	// const carouselList = document.querySelectorAll('.region_slide_list li');

	// const prevBtn = document.querySelector('#region_slide_prev');
	// const nextBtn = document.querySelector('#region_slide_next');

	// let counter = 1;
	// const size = carouselList[0].clientWidth;
	// carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';

	// // Buttons
	// nextBtn.addEventListener('click', ()=> {
	// 	if(counter >= carouselList.length -1) return;
	// 	carouselSlide.style.transition = "transform 0.4s ease-in-out";
	// 	counter++;
	// 	carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
	// });

	// prevBtn.addEventListener('click', ()=> {
	// 	if(counter <= 0) return;
	// 	carouselSlide.style.transition = "transform 0.4s ease-in-out";
	// 	counter--;
	// 	carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
	// });

	// // Jump to First/Last Slide
	// carouselSlide.addEventListener('transitionend', () => {
	// 	console.log(carouselList[counter]);
	// 	if (carouselList[counter].id === 'lastClone'){
	// 		carouselSlide.style.transition = 'none'; // 트랜지션 효과 없애기
	// 		counter = carouselList.length -2; // couter 초기화
	// 		carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)'; // 실제 마지막 이미지로 이동.
	// 	} else if (carouselList[counter].id === 'firstClone') {
	// 		carouselSlide.style.transition = 'none';
	// 		counter = carouselList.length - counter; // couter 초기화
	// 		carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
	// 	}
	// });
</script>
<style>
	/* .region_slide{
	width: 900px;
	margin: 30px auto;
	border: 0px solid #000;
	overflow: hidden;
	position: relative;
	}
	.region_slide_list{
	display: flex;
	width: 100%;
	height: 450px;
	} */
	/* #prevBtn{
	position:absolute;
	top: 50%;
	left: 0;
	transform: translate(0%, -50%);
	width: 20px;
	height: 36px;
	background: url(img/carousel_prevBtn.png) no-repeat;
	text-indent: -9999px;
	}
	#nextBtn{
	position:absolute;
	top: 50%;
	right: 0;
	transform: translate(0%, -50%);
	width: 20px;
	height: 36px;
	background: url(img/carousel_nextBtn.png) no-repeat;
	text-indent: -9999px;
	} */
</style>