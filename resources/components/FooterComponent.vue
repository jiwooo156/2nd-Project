<template>
	<div class="footer"  v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
		<div class="footer_main">
			<div class="footer_team">
				<h4>Quintrillion</h4>
				<span>퀸트릴rㅕㄴ이라 읽고 오조라고합니다:) 이의이승 뚜비두밥 오뚜기밥 냥냥냥 우리 경상도 아이가나다라마바사</span>
			</div>
			<div class="footer_team_mem">
				<ul>
					<li class="footer_box footer_box_1">
						<span>김지웅</span>
						<div>#하..<br>#자칭과학왕<br>#영어꼴등</div>
						<!-- <div class="footer_box_img"><img src="/img/box_1.png" alt="box"></div> -->
					</li>
					<li class="footer_box footer_box_2">
						<span>정지우</span>
						<div>#햄스터<br>#또먹어?<br>#계속먹어</div>
						<!-- <div class="footer_box_img"><img src="/img/box_2.png" alt="box"></div> -->
					</li>
					<li class="footer_box footer_box_3">
						<span>차민지</span>
						<div>#한입충<br>#아안먹을래<br>#히히히</div>
						<!-- <div class="footer_box_img"><img src="/img/box_3.png" alt="box"></div> -->
					</li>
					<li class="footer_box footer_box_4">
						<span>최정훈</span>
						<div>#제발<br>#이러시는이유가<br>#있을거아니에요</div>
						<!-- <div class="footer_box_img"><img src="/img/box_4.png" alt="box"></div> -->
					</li>
				</ul>
			</div>
			<div class="footer_con">
				<h4>Academy Connect</h4>
				<span><font-awesome-icon :icon="['fas', 'house']" /> 그린컴퓨터아트학원 대구</span>
				<span><font-awesome-icon :icon="['fas', 'location-dot']" /> 대구광역시 중구 중앙대로 394, 제일빌딩 5F</span>
				<span><font-awesome-icon :icon="['fas', 'phone']" /> 053.572.1005</span>
				<span><font-awesome-icon :icon="['fas', 'desktop']" /> 기업요구를 반영항 PHP풀스택(프론트앤드 + 백앤드)개발자양성과정</span>
			</div>
			<div class="footer_ref">
				<div class="footer_ref_left">
					<h4>Reference Website</h4>
					<span>참고 웹사이트</span>
				</div>
				<!-- a태그해서 페이지 이동하게 하고 크기 조절하고 정렬잘하고 -->
				<div class="footer_ref_right">
					<span><img src="/img/footer_img1.png" alt="footer_logo" class="footer_img1"></span>
					<span><img src="/img/footer_img2.png" alt="footer_logo"></span>
					<span><img src="/img/footer_img3.png" alt="footer_logo"></span>
					<span><img src="/img/footer_img4.png" alt="footer_logo"></span>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'FooterComponent',
	props: {

	},
	
	components: {

	},

	data() {
		return {
			setting: '',
		}
	},

	created() {

	},

	mounted() {

	},

	methods: {

	}
}
</script>