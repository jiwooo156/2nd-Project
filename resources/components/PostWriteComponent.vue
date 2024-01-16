<template lang="">
	<div class="detail_frame">
		<div class="detail_container">
			<div class="detail_header_flex">
				<form action="/write/update" methods="post">
					<div class="detail_type font_air bold">
						<!-- <select v-model="flg" name="flg" class="form-select qna_drop" aria-label=".form-select-sm">
							<option value="free" class="qna_drop_item" selected>자유</option>
							<option value="info" class="qna_drop_item">정보</option>
							<option value="question" class="qna_drop_item">질문</option>
							<option value="tendinous" class="qna_drop_item">건의</option>
						</select> -->
						<span>{{ this.detaildata.flg }}게시판입니다.</span>
						<span>{{ this.detaildata.category_flg }}</span>
						<!-- <select v-model="category_flg" name="category_flg" class="form-select qna_drop" aria-label=".form-select-sm">
							<option value="all" class="qna_drop_item" selected>전체</option>
							<option value="festival" class="qna_drop_item">축제</option>
							<option value="tourism" class="qna_drop_item">관광</option>
							<option value="etc" class="qna_drop_item">기타</option>
						</select> -->
					</div>
					<div class="detail_header font_air bold">
						<div class="detail_title">
							<textarea type="text" maxlength="50"
							name="title"
							v-model="title"  
							@input="changeKeywordT"
							placeholder="제목을 입력하세요."
							></textarea>
						</div>
					</div>
					<div>
						<p class="font_air bold">						
							<textarea type="text" maxlength="3000"
							name="content"
							v-model="content" 
							@input="changeKeywordC"
							placeholder="내용을 입력하세요."
							></textarea></p>
					</div>
					<div class="post_btn_bot">
							<button type="button" @click="uppost">수정</button>
							<button type="button" @click="goBack">취소</button>
					</div>
				</form>
			</div>
		</div>
		<div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
	</div>
</template>
<script>
import Swal from 'sweetalert2';

export default {
	name: "PostWriteComponent",
	data() {
		return {
			detaildata: {},
			title:"",
			content:"",
			flg: "",
			category_flg: "",
			// flg: 'free',
			// category_flg: 'all',
		}
	},
	methods: {
		// 게시글 수정
		uppost() {
			this.$store.commit('setLoading',true);
			let URL = '/write/update';
			const formData = new FormData();
			formData.append('id', this.detaildata.id);
			formData.append('title', this.detaildata.title);
			formData.append('content', this.detaildata.content);
			formData.append('flg', this.detaildata.flg);
			formData.append('category_flg', this.detaildata.category_flg);
			axios.post(URL, formData)
			.then(res => {
				if(res.data.code === "0") {
					this.detaildata = res.data.data[0];
					Swal.fire({
						icon: 'success',
						title: '완료',
						text: '정상처리되었습니다.',
						confirmButtonText: '확인'
					});
				}
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '에러 발생.',
                    confirmButtonText: '확인'
                })
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
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
		changeKeywordT(e) {
			this.post_title = e.target.value;
		},
		changeKeywordC(e) {
			this.post_content = e.target.value;
		},
	}
}

</script>
<style lang="">
	
</style>