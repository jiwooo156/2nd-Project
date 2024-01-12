<template lang="">
	<div class="detail_frame">
		<div class="detail_container">
			<div class="detail_header_flex">
				<div class="detail_type font_air bold center">
					어떤게시판입니다.<br>
					<select v-model="selectedCategory" @change="filterData" class="form-select qna_drop" aria-label=".form-select-sm">
						<option value="all" class="qna_drop_item" selected>전체</option>
						<option value="festival" class="qna_drop_item">축제</option>
						<option value="tourism" class="qna_drop_item">관광</option>
						<option value="etc" class="qna_drop_item">기타</option>
					</select>
				</div>
				<div class="detail_header font_air bold">
					<div class="detail_title">
						<textarea type="text" maxlength="50"
						v-model="title"  
						@input="changeKeyword"
						@keyup.enter="postwrite"
						placeholder="제목을 입력하세요."
						></textarea>
					</div>
				</div>
				<div>
					<p class="font_air bold">						
						<textarea type="text" maxlength="3000"
						v-model="content"  
						@input="changeKeyword"
						@keyup.enter="postwrite"
						placeholder="내용을 입력하세요."
						></textarea></p>
				</div>
				<div class="post_btn_bot">
						<button type="button">작성</button>
						<button type="button" @click="goBack">취소</button>
				</div>
			</div>
		</div>
		<div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
	</div>
</template>
<script>

export default {
	name: "PostWriteComponent",
	data() {
		return {
			title:"",
			content:"",
			flg:"",
			category_flg:"",
			nowflg: "",
			// 선택된 카테고리를 저장하는 초기값
			selectedCategory: 'all',
		}
	},
	methods: {
		getinfo(){
			// 현재url가져오기
			let params = new URLSearchParams(window.location.search);
			this.b_id = params.get('id');
			
			const URL = '/detail/info/'+this.b_id;
			axios.get(URL)
			.then(res => {
				if(res.data.code==="0"){
					this.detaildata = res.data.data[0];
					this.repliedata = res.data.replie;
					this.repliecount = res.data.repliecount;
					
				}else if(res.data.code==="E99"){
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: res.data.errmsg,
						confirmButtonText: '확인'
					})
				}
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '에러가 발생했습니다',
                    confirmButtonText: '확인'
                })
			})
		},
		
		//*************************************************************************
		// flg 데이터 출력 변환
		getEventType(data) {
			if(data === '0') {
				return '자유';
			}else if (data === '1') {
				return '정보';
			}else if (data === '2') {
				return '질문';
			}else {
				return '건의';
			}
		},
		// category_flg 데이터 출력 변환
		getCategoryEventType(data) {
			if(data === '0') {
				return '축제';
			}else if (data === '1') {
				return '관광';
			}else if (data === '2') {
				return '기타';
			}else {
				return '기타';
			}
		},
		// 뒤로가기 동작 실행
		goBack() {
			this.$router.go(-1);
		},	
		// 한글 바로입력
		changeKeyword(e) {
			this.replie = e.target.value;
		},
	}
}

</script>
<style lang="">
	
</style>