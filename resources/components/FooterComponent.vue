<template>
	<div class="footer"  v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/admin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
		<div class="footer_main">
			<div class="footer_team">
				<h3>경상도의 다양한 모습을 이의이승에서 접해보세요:)</h3>
				<span>저희는 Quintrillion(퀸트릴rㅕㄴ)이라 쓰고 오조라고 해요. 이의이승을 함께 꾸린 저희를 소개할게요!</span>
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
				<div>
					<h3 class="footer_con_tit font_air bold">아카데미 정보</h3>
				</div>
				<div class="footer_array">
					<span><div><font-awesome-icon :icon="['fas', 'house']" /></div>그린컴퓨터아트학원 대구</span>
					<a href="https://maps.app.goo.gl/num9JqLFP3GA1d849" target="_blank"  class="font_air"><div><font-awesome-icon :icon="['fas', 'location-dot']" /></div>대구광역시 중구 중앙대로 394, 제일빌딩 5F</a>
					<a href="tel:053-572-1005" class="font_air"><div><font-awesome-icon :icon="['fas', 'phone']" /></div>053.572.1005</a>
					<span><div><font-awesome-icon :icon="['fas', 'desktop']" /></div>기업요구를 반영한 PHP풀스택(프론트앤드 + 백앤드) 개발자 양성 과정</span>
				</div>
			</div>
			<div class="footer_ref font_air">
				<div class="footer_ref_left">
					<h3>참고 웹사이트</h3>
				</div>
				<div class="footer_ref_right">
					<!-- a태그해서 페이지 이동하게 하고 크기 조절하고 정렬잘하고 -->
					<a href="https://knto.or.kr/index" target="_blank"><img src="/img/footer_img1.png" alt="footer_logo" class="footer_img1"></a>
					<a href="https://tour.gb.go.kr/" target="_blank"><img src="/img/footer_img2.png" alt="footer_logo" class="footer_img2"></a>
					<a href="https://tour.gyeongnam.go.kr/index.gyeong" target="_blank"><img src="/img/footer_img3.png" alt="footer_logo" class="footer_img3"></a>
					<a href="https://www.msit.go.kr/index.do" target="_blank"><img src="/img/footer_img4.png" alt="footer_logo" class="footer_img4"></a>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'FooterComponent',
	data() {
		return {
			setting: '',
		}
	},
}
</script>