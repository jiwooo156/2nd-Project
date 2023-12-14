<template>
	<div class="error_wasands">
		<!-- <img src="../../public/img/샌즈.jpeg" alt=""> -->
		<div class="error_txtmsg">
			<h3>죄송합니다. 찾을수없는 페이지입니다.</h3>
			<br>
			<h4>존재하지 않는 주소를 입력하였거나</h4>
			<h4>요청하신 페이지의 주소가 변경, 삭제되어 찾을 수 없습니다.</h4>
			<h4>감사합니다.</h4>	
			<br>
			<router-link :to="'/main'"><button class="user_button_exit">홈</button></router-link>
		</div>
	</div>
</template>
<script>
export default {
	name: 'ErrorComponent',
	watch: {	
	},
	data() {
		return {
			
		}
	},

	created() {

	},
	methods: {

	}
}
</script>