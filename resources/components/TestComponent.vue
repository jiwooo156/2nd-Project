<template lang="">
    <div class="detail_frame">
        <div class="detail_container">
            <div class="detail_header_flex">
                <form action="/community/testwrite" methods="post">
                    <div class="detail_type font_air bold center">
                        <select v-model="flg" name="flg" class="form-select qna_drop" @click="checklocal" aria-label=".form-select-sm">
                            <option value="0" class="qna_drop_item" selected>자유게시판</option>
                            <option value="1" class="qna_drop_item">정보게시판</option>
                            <option value="2" class="qna_drop_item">질문게시판</option>
                            <option value="3" class="qna_drop_item">건의게시판</option>
                        </select>
                        <select v-model="categoryflg" name="categoryflg" class="form-select qna_drop" @click="checklocal" aria-label=".form-select-sm">
                            <option value="3" class="qna_drop_item" selected>전체</option>
                            <option value="0" class="qna_drop_item">축제</option>
                            <option value="1" class="qna_drop_item">관광</option>
                            <option value="2" class="qna_drop_item">기타</option>
                        </select>
                    </div>
                    <div class="detail_header font_air bold">
                        <div class="detail_title">
                            <textarea type="text" maxlength="50"
                            name="title"
                            @click="checklocal"
                            @input="changeKeyword"
                            placeholder="제목을 입력하세요."
                            v-model="title"
                            ></textarea>
                        </div>
                    </div>
                    <!-- <div class="community_inputgroup mb-3 align-items-center">
                        <input id="commu_file_img1" class="form-control" type="file" accept="image/*">
                        <input id="commu_file_img2" class="form-control" type="file" accept="image/*">
                        <input id="commu_file_img3" class="form-control" type="file" accept="image/*">
                    </div> -->
                    <div>
                        <p class="font_air bold">
                            <textarea type="text" maxlength="3000"
                            name="content"
                            @click="checklocal"
                            @input="changeKeyword"
                            placeholder="내용을 입력하세요."
                            v-model="content"
                            ></textarea>
                        </p>
                    </div>
                    <div class="post_btn_bot">
                        <button type="button" @click="testWrite()">작성</button>
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
        // 게시글 작성
        testWrite() {
            const URL = '/testwrite';
            const formData = new FormData();
            formData.append('title', this.title);
            formData.append('content', this.content);
            formData.append('flg', this.flg);
            formData.append('category_flg', this.categoryflg);
            console.log(formData);
            console.log(this.title);
            console.log(this.content);
            console.log(this.flg);
            axios.post(URL, formData)
            .then(res => {
                console.log(res);
                this.communityresult = res.data.data;
                console.log(this.communityresult);
                this.$router.replace('/post?id='+this.communityresult.id);
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