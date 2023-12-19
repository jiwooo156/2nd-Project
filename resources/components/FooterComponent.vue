<template>
	<div class="footer"  v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
		<div class="footer_team">
			<p>Quintrillion</p>
			<span>퀸트릴rㅕㄴ이라 읽고 오조라고합니다:) 이의이승 뚜비두밥 오뚜기밥 냥냥냥 우리 경상도 아이가나다라마바사</span>
		</div>
		<div class="footer_team_mem">
			<ul>
				<li class="footer_box1">
					<div>김지웅</div>
					<div>#하..<br>#자칭과학왕<br>#영어꼴등</div>
				</li>
				<li class="footer_box">
					<div>정지우</div>
					<div>#햄스터<br>#또먹어?<br>#계속먹어</div>
				</li>
				<li class="footer_box">
					<div>차민지</div>
					<div>#한입충<br>#아안먹을래<br>#히히히</div>
				</li>
				<li class="footer_box">
					<div>최정훈</div>
					<div>#제발<br>#이러시는이유가<br>#있을거아니에요</div>
				</li>
			</ul>
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