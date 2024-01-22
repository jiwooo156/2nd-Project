<template lang="">
	<div class="write_frame">
		<div class="write_container">
			<div class="write_headertitle">
				<h1>게시글 작성</h1>
			</div>
			<div class="write_flgframe">
				<div class="col-md-3 position-relative mb-3">
					<label for="writeflg" class="form-label">게시판</label>
					<select class="form-select" id="writeflg" v-model="flg" name="flg">
						<option value="0">자유게시판</option>
						<option value="1">정보게시판</option>
						<option value="2">질문게시판</option>
						<option value="3">건의게시판</option>
					</select>
				</div>
				<div class="col-md-3 position-relative mb-3">
					<label for="writeflg" class="form-label">카테고리</label>
					<select class="form-select" id="writeflg" v-model="categoryflg" name="flg">
						<option value="0" class="qna_drop_item" selected>축제</option>
						<option value="1" class="qna_drop_item">관광</option>
						<option value="2" class="qna_drop_item">기타</option>
					</select>
				</div>
			</div>
			
			<div class="input-group mb-1">
				<span class="input-group-text" id="basic-addon1">제목</span>
				<input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" v-model="title">
			</div>
			<div class="input-group mb-1">
				<span class="input-group-text">내용</span>
				<textarea class="form-control" aria-label="With textarea" v-model="content"></textarea>
			</div>
			<div class="input-group mb-3 align-items-center write_input_group">
				<input id="write_file_img1" class="form-control write_form" type="file" accept="image/*">
				<input id="write_file_img2" class="form-control write_form" type="file" accept="image/*">
				<input id="write_file_img3" class="form-control write_form" type="file" accept="image/*">
			</div>
			<div class="write_btnframe">
				<button class="pointer write_btn" @click="commuWrite">작성</button>
				<button class="pointer write_btn" @click="goBack">취소</button>
			</div>
		</div>
	</div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
	name: "WriteComponent",
	data() {
		return {
			nowflg: "",
			flg: "0",
			categoryflg: "0",
			title: "",
			content: "",
			communityresult: "",
			thumbnailSrc: [],
		}
	},
	created() {
	},
	methods: {
		// 로그인확인
		checklocal() {
			if(!(localStorage.getItem('nick'))){
				Swal.fire({
                    icon: 'error',
                    title: '주의',
                    text: '로그인 뒤 작성 해 주세요',
                    confirmButtonText: '확인'
                })
				this.$router.push('/login');
			}
		},
		// 이미지 미리보기
		setThumbnail(index, event) {
			var reader = new FileReader();

			reader.onload = (event) => {
				this.$set(this.thumbnailSrc, index, event.target.result);
			};

			reader.readAsDataURL(event.target.files[0]);
		},
		// 게시글 작성
		commuWrite() {
			// 스피너 로딩바
			this.$store.commit('setLoading',true);
			const URL = '/commuwrite';
			// const uploadFile = event.target.files[0]
			let img1 = document.querySelector('#write_file_img1');
			let img2 = document.querySelector('#write_file_img2');
			let img3 = document.querySelector('#write_file_img3');
			const formData = new FormData();
			formData.append('title', this.title);
			formData.append('content', this.content);
			formData.append('flg', this.flg);
			formData.append('category_flg', this.categoryflg);
			formData.append('img1', img1.files[0]);
			formData.append('img2', img2.files[0]);
			formData.append('img3', img3.files[0]);
			axios.post(URL, formData)
			.then(res => {
				this.communityresult = res.data.data;
				if((this.communityresult.flg==="2")||(this.communityresult.flg==="3")) {
					this.$router.replace('/post?id='+this.communityresult.id);
					return false;
				}
				this.$router.replace('/community?id='+this.communityresult.id);
			})
			.catch(err => {
				Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '에러가 발생했습니다',
                    confirmButtonText: '확인'
                })
            })
			.finally(() => {
                this.$store.commit('setLoading', false);
            });
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