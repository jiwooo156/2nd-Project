<template lang="">
	<div class="detail_frame">
		<div class="detail_container">
			<div class="detail_header_flex">
				<div class="detail_type font_air bold center">
					어떤게시판입니다.<br>
					카테고리를 선택하세요(축제/관광/기타)
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
		}
	},
	methods: {
		// 댓글작성
		postwrite(){
			if(this.title){
				const URL = '/post/'+this.b_id;
				const formData = new FormData();
				formData.append('title', this.replie);
				formData.append('b_id', this.b_id);
				formData.append('flg', '1');
				axios.post(URL,formData)
				.then(res =>{
					if(res.data.code==="0"){
						this.replie = "";
						this.repliecount++;
						this.repliedata.unshift(res.data.data);
					}else{
						Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.data.errorMsg,
                    confirmButtonText: '확인'
                })

					}
				})
				.catch(err => {
					Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.response.data.errorMsg,
                    confirmButtonText: '확인'
                })

				})
			}else{
				Swal.fire({
                    icon: 'warning',
                    title: '주의',
                    text: '댓글을 작성해 주세요.',
                    confirmButtonText: '확인'
                })
			}
		
		},
	},
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
	// 한글 바로입력
	changeKeyword(e) {
		this.replie = e.target.value;
	},
}

</script>
<style lang="">
	
</style>