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
			<div class="region_search_form">
				<select class="region_select_list" id="retion_select_list">
					<option>지역</option>
					<option v-for="city in cities" :key="city" :value="city">
						{{ city }}
					</option>
				</select>
				<input type="date" class="region_date" id="region_date" :value="'2023-01-01'"/>
				-
				<input type="date" class="region_date" id="region_date" :value="'2023-12-31'"/>

				<br>
				<input class="region_text" id="region_text" type="text" placeholder="키워드로 검색 해 보세요">
				<button class="region_form_btn" type="submit">검색</button>
			</div>
			<button class="region_category1">
				<span>최신순</span>
			</button>
			<button class="region_category2"> 
				<span>인기순</span>
			</button>
		</div>
		<div class="region_list_frame">
			<div class="region_recommend">
				<div class="region_recommend_festival">
					<div class="region_comment">
						<p class="region_p1">이런 축제</p>
						<p class="region_p2">추천드려요</p>
					</div>
					<div class="region_list_grid">
						<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/jjangu.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">추천축제제목1</router-link>
						</div>
						<div class="region_period">20231212-20231212</div>
						</div>
						<div class="region_list">
							<div class="region_img">
								<router-link :to="'/'"><img src="/img/jjangu.jpg"></router-link>
							</div>
							<div class="region_title">
								<router-link :to="'/'">추천축제제목2</router-link>
							</div>
							<div class="region_period">내용2</div>
						</div>
						<div class="region_list">
							<div class="region_img">
								<router-link :to="'/'"><img src="/img/jjangu.jpg"></router-link>
							</div>
							<div class="region_title">
								<router-link :to="'/'">추천축제제목3</router-link>
							</div>
							<div class="region_period">내용3</div>
						</div>
						<div class="region_list">
							<div class="region_img">
								<router-link :to="'/'"><img src="/img/jjangu.jpg"></router-link>
							</div>
							<div class="region_title">
								<router-link :to="'/'">추천축제제목4</router-link>
							</div>
							<div class="region_period">내용4</div>
						</div>
					</div>
				</div>
				<div class="region_recommend_tour">
					<div class="region_comment">
						<p class="region_p1">이런 관광지</p>
						<p class="region_p2">추천드려요</p>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_2.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">추천관광지제목1</router-link>
						</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_2.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">추천관광지제목2</router-link>
						</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_2.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">추천관광지제목3</router-link>
						</div>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_2.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">추천관광지제목4</router-link>
						</div>
					</div>
				</div>
			</div>
			<div class="region_total">
				<div class="region_comment2">
					<p class="region_p3">지역명</p>
					<p class="region_p4">지역별로 추천 해 드릴게요!</p>
				</div>
				<div class="region_total_festival">
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_3.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역축제제목1</router-link>
						</div>
						<div class="region_period">내용1</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_3.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역축제제목2</router-link>
						</div>
						<div class="region_period">내용2</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_3.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역축제제목3</router-link>
						</div>
						<div class="region_period">내용3</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_3.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역축제제목4</router-link>
						</div>
						<div class="region_period">내용4</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
				</div>
				<div class="region_total_tour">
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_4.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역관광지제목1</router-link>
						</div>
						<div class="region_period">내용1</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_4.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역관광지제목4</router-link>
						</div>
						<div class="region_period">내용2</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_4.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역관광지제목4</router-link>
						</div>
						<div class="region_period">내용3</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
					<div class="region_list">
						<div class="region_img">
							<router-link :to="'/'"><img src="/img/item_4.jpg"></router-link>
						</div>
						<div class="region_title">
							<router-link :to="'/'">지역관광지제목4</router-link>
						</div>
						<div class="region_period">내용4</div>
						<button type="submit" class="region_heart pointer"><font-awesome-icon :icon="['fas', 'heart']" /></button>
					</div>
				</div>
			</div>
		</div>
		<div class="region_search_result">

		</div>
		<div class="region_btn_more">
			<button class="pointer">더보기</button>
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
			cities: ['포항시','경주시','김천시','안동시','구미시','영주시','영천시','상주시','문경시','경산시','의성군','청송군','영양군','영덕군','청도군','고령군','성주군','칠곡군','예천군','봉화군','울진군','울릉군'],
			startDate: '',
			endDate: '',
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