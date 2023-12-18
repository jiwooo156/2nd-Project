<template>
	<div class="error_wasands">
		<div class="error_txtmsg">
			<h1 class="error_h1">니 어데가노?</h1>
			<br>
			<div class="error_container">
				<div class="error_header">
					존재하지않는 주소를 입력하셨거나
				</div>
				<div class="error_header">
					에러가 발생하였습니다
				</div>
				<div class="error_main">
					<div class="error_title">에러코드 : <span>E404</span></div>
					<div class="error_content">페이지를 찾을수 없습니다.</div>
				</div>
			</div>
			<br>
			<router-link :to="'/main'" class="error_btn">메인으로</router-link>
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