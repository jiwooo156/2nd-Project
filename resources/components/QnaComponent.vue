<template lang="">
	<div class="qna_frame">
		<div class="qna_container">
			<div class="qna_header">
				<h1>질문게시판</h1>
				<div class="qna_header_l">
					<div class="dropdown">
						<a class="btn btn-outline-light dropdown-toggle qna_drop font_air bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
							전체
						</a>
						<ul class="dropdown-menu btn-sm" aria-labelledby="dropdownMenuLink">
							<li><a class="dropdown-item qna_drop_item font_air bold" href="#">축제</a></li>
							<li><a class="dropdown-item qna_drop_item font_air bold" href="#">관광</a></li>
							<li><a class="dropdown-item qna_drop_item font_air bold" href="#">기타</a></li>
						</ul>
					</div>
					<div class="qna_btn">
						<button type="button">최신순</button>
						<button type="button">조회수순</button>
						<button type="button">좋아요순</button>
					</div>
				</div>
				<div class="qna_header_r"></div>
			</div>
		</div>
	</div>
	<!-- <div class="qna_qt">{{ this.nowns }}</div> -->
</template>
<script>
export default {
	name: "QnaComponent",
	// data() {
	// 	return {
	// 		// 질문/건의 구분
	// 		nowns: "", 
	// 	}
	// },
	// created() {
	// 	// url의 파라미터를 가져옴
	// 	const objUrlParam = new URLSearchParams(window.location.search);
	// 	this.nowns = objUrlParam.get('qt')
	// 	// 파라미터의 qt를 확인해서 store의 QtFlg셋팅
	// 	// url의 파라미터 중 qt를 세팅함
	// 	if(this.nowns==="질문"){
	// 		this.$store.commit('setQtFlg','1');
	// 	}else if(this.nowns==="건의"){
	// 		this.$store.commit('setQtFlg','2');
	// 	}
	// 	this.getState( objUrlParam.get('qt') );
	// 	this.getRecommendFestival(objUrlParam.get('qt'));
	// 	// 로컬스토리지에 저장된 정보있는지 확인
	// 	let boo = localStorage.getItem('nick') ?  true : false;
	// 	this.$store.commit('setLocalFlg', boo);
	// 	this.getinfo();
	// },
	// methods: {
	// 	// 질문/건의 가져오기
	// 	getState(ns){
	// 		// 해당url의 데이터 가져오기
	// 		const URL = '/qna/?qt='+ qt;
	// 		// 헤더에서 클릭시 url 설정됨(qt에 질문/건의 설정됨)

	// 		axios.get(URL)
	// 		// axios는 http status code가 200번대면 then으로, 그외에는 catch로
	// 		.then(res => {
	// 			// console.log("getState");
	// 			// console.log("레스데이터"+res.data);

	// 			if(res.data.code === '0') {
	// 				this.states = res.data.data;
	// 			} else {
	// 				this.$router.push('/error');
	// 			}
	// 		})
	// 		.catch(err => {
    //     		this.$router.push('/error');
	// 		})
	// 	},
	// }
}
</script>
<style lang="">
	
</style>