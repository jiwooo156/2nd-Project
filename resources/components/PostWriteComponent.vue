<template lang="">
    <div class="detail_frame">
        <div class="detail_container">
            <div class="detail_header_flex">
                <form action="/write/create" methods="post">
					<div class="detail_type font_air bold">
						<select v-model="flg" name="flg" class="form-select qna_drop" aria-label=".form-select-sm">
							<option value="free" class="qna_drop_item" selected>자유</option>
							<option value="info" class="qna_drop_item">정보</option>
							<option value="question" class="qna_drop_item">질문</option>
							<option value="tendinous" class="qna_drop_item">건의</option>
						</select>
						<span>게시판입니다.</span>
						<select v-model="category_flg" name="category_flg" class="form-select qna_drop" aria-label=".form-select-sm">
							<option value="all" class="qna_drop_item" selected>전체</option>
							<option value="festival" class="qna_drop_item">축제</option>
							<option value="tourism" class="qna_drop_item">관광</option>
							<option value="etc" class="qna_drop_item">기타</option>
						</select>
					</div>
					<div class="detail_header font_air bold">
						<div class="detail_title">
							<textarea type="text" maxlength="50"
							name="title"
							v-model="title"  
							@input="changeKeywordT"
							@keyup.enter="title"
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
							@keyup.enter="content"
							placeholder="내용을 입력하세요."
							></textarea></p>
					</div>
					<div class="post_btn_bot">
							<button type="button" @click="writepost()">작성</button>
							<button type="button" @click="goBack">취소</button>
					</div>
				</form>
            </div>
        </div>
        <div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
    </div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
    name: "TestComponent",
    data() {
        return {
            nowflg: "",
            flg: "0",
            categoryflg: "3",
            title: "",
            content: "",
            communityresult: ""
        }
    },
    created() {
    },
    methods: {
        // 게시글 작성
        testWrite() {
            const URL = '/testwrite';
            const formData = new FormData();
            formData.append('title', this.title);
            formData.append('content', this.content);
            formData.append('flg', this.flg);
            formData.append('category_flg', this.categoryflg);
            axios.post(URL, formData)
            .then(res => {
                console.log(res);
                this.communityresult = res.data.data;
                console.log(this.communityresult);
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