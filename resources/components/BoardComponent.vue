<template>
	<div class="qna_frame">
		<div class="qna_container">
			<div class="qna_header">
				<h1 v-if="this.nowflg==='0'">자유게시판</h1>
				<h1 v-else="this.nowflg==='1'">정보게시판</h1>
				<div class="qna_header_bot">
					<div class="qna_header_l">
						<select v-model="option" @click="getInfo()" class="form-select qna_drop my-3" aria-label=".form-select-sm">
							<option value="3" class="qna_drop_item">전체</option>
							<option value="0" class="qna_drop_item">축제</option>
							<option value="1" class="qna_drop_item">관광</option>
							<option value="2" class="qna_drop_item">기타</option>
						</select>
						<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
						<div class="qna_btn">
							<!-- 정렬 button -->
							<div class="btn-group" role="group">
								<button type="button"  class="btn" value="1" @click="buttonclick(1)" :class="{'qna_btn_button_on': this.rangevalue == 1}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
								</button>
								<button type="button" class="btn" value="2" @click="buttonclick(2)" :class="{'qna_btn_button_on': this.rangevalue == 2}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
								</button>
								<button type="button" class="btn" value="3" @click="buttonclick(3)" :class="{'qna_btn_button_on': this.rangevalue == 3}">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>좋아요순
								</button>
							</div>
						</div>
					</div>
					<!-- 반응형 숨기기 -->
					<div class="qna_header_r">
						<div>
							총 <span class="qna_pink"> {{ cntinfo }}</span>건의 게시글이 있습니다.
						</div>
					</div>
				</div>
			</div>	
			<div class="info_list" >
				<table>
					<colgroup>
						<col class="info_id col_hidden">
						<col class="info_category">
						<col class="info_title">
						<col class="info_writer">
						<col class="info_create_at">
						<col class="info_hits col_hidden">
						<col class="info_likes col_hidden">
					</colgroup>
					<thead>
						<tr>
							<th class="col_hidden font_air bold">번호</th>
							<th class="font_air bold">카테고리</th>
							<th class="font_air bold">제목</th>
							<th class="font_air bold">작성자</th>
							<th class="font_air bold">작성일자</th>
							<th class="col_hidden font_air bold">조회수</th>
							<th class="col_hidden font_air bold">좋아요</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="notice in noticedata" :key="notice" v-if="this.noticedata&&this.page === 1" class="info_notice pointer font_air bold" @click="$router.push('/community?id='+notice.id)">
							<td class="col_hidden">{{ notice.id }}</td>
							<td>공지사항</td>
							<td class="info_title">{{ notice.title }}</td>
							<td>관리자</td>
							<td>{{ formatEventDate(notice.created_at) }}</td>
							<td class="col_hidden">{{ notice.hits }}</td>
							<td class="col_hidden">{{ notice.cnt }}</td>
						</tr>
						<tr v-for="infodata in infolist" :key="infodata" class="pointer font_air bold" @click="$router.push('/community?id='+infodata.id)">
							<td class="col_hidden font_air bold">{{ infodata.id }}</td>
							<td class="font_air bold">{{ infodata.category_flg==='0' ? '축제' : infodata.category_flg==='1' ? '관광' : '기타'}}</td>
							<td class="info_title font_air bold">{{ infodata.title }}</td>
							<td class="font_air bold">{{ infodata.nick }}</td>
							<td class="font_air bold">{{ formatEventDate(infodata.created_at) }}</td>
							<td class="col_hidden font_air bold">{{ infodata.hits }}</td>
							<td class="col_hidden font_air bold">{{ infodata.cnt }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
				<router-link to="/commuwrite" @click="checklocal()">글 작성하기</router-link>
			</div>
			<div class='admin_page  mt-3'>
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
							<span class="page-link" @click="getInfo(1)">&lt;&lt;</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
							<span class="page-link" @click="getInfo(prevnum)">이전</span>
						</li>
						<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
							<span class="page-link" @click="getInfo(num)">{{ num }}</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
							<span class="page-link" @click="getInfo(nextnum)">다음</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
							<span class="page-link" @click="getInfo(lastpage)">>></span>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: "BoardComponent",

	data() {
		return {
			infolist: [],
			nowflg: "",
			cntinfo: 0,
			rangevalue: "1",
      		option: "3",
			page:1,
			lastpage:1,
			first_num:1,
			last_num:1,
			prevnum:1,
			nextnum:2,
			numbox:[],
			noticedata: ""
		}
	},
	created() {
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg');
		console.log( "created flg"+this.nowflg )
		this.getInfo(1);
	},
	beforeRouteUpdate() {
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg')==="0"? "1":"0";
		console.log("beforeupdated flg"+this.nowflg);
		this.option = "3";
		this.rangevalue = "1";
		this.getInfo(1);
	},
	mounted() {
	},
	methods: {
		// button 클릭시 value 데이터바인딩
		buttonclick(value) {
			this.rangevalue = value;
			console.log("버튼밸류:"+value);
			this.getInfo();
			console.log("버튼함수끝"+value);
		},
		// 해당 게시판의 모든 게시글 조회
		getInfo(page) {
			// 해당url의 데이터 가져오기
			const URL = '/board/info?page='+page;
			
			console.log("getinfo 함수진입")
			console.log("nowflg="+this.nowflg)
			console.log("option="+this.option)
			console.log("rangevalue="+this.rangevalue)
			console.log("page="+page)
			// axios는 http status code가 200번대면 then으로, 그외에는 catch로
			axios.get(URL, {
				params: {
					"flg": this.nowflg,
					"category": this.option,
					"orderby": this.rangevalue,
					"page": page,
				}
			})
			.then(res => {
				console.log('정상처리')
				this.infolist = res.data.information.data;
				this.cntinfo = res.data.infocnt;
				this.page = res.data.information.current_page
				this.lastpage = res.data.information.last_page
				this.noticedata = res.data.noticedata;
				this.paging()
				// console.log("공지사항은 : "+this.infolist.notice_flg);
				console.log("공지사항은 : "+this.noticedata);
				console.log('페이지네이션종료')
			})
			.catch(err => {
				// this.$router.push('/error');
			})
		},
		// 해당 게시판의 공지사항 조회
		// getNotice(flg) {
		// 	// 해당url의 데이터 가져오기
		// 	const URL = '/board/notice?flg='+this.nowflg;
			
		// 	console.log("getNotice 함수진입")
		// 	console.log("nowflg="+this.nowflg)
		// 	// axios는 http status code가 200번대면 then으로, 그외에는 catch로
		// 	axios.get(URL)
		// 	.then(res => {
		// 		console.log('정상처리')
		// 		this.noticedata = res.data.data;
		// 		console.log("공지사항은 : "+this.noticedata);
		// 	})
		// 	.catch(err => {
		// 		// this.$router.push('/error');
		// 	})
		// },
		// 페이징처리
		paging(){
			this.numbox = [];
			if(this.lastpage < 5){
				this.first_num = 1
				this.last_num = this.lastpage
			}else{
				if(this.page <= 3){
						this.first_num = 1
						this.last_num = 5
				}else if(this.page >= this.lastpage-2){
					this.first_num = this.lastpage-4
					this.last_num = this.lastpage
				}else{
					this.first_num = this.page-2
					this.last_num = this.page+2
				}
			}
			for(let i = this.first_num; i <= this.last_num; i++){
				this.numbox.push(i);
			}
			if(this.page === 1){
				this.prevnum = 1
				this.nextnum = 2
			}else if(this.page === this.lastpage){
				this.prevnum = this.lastpage-1
				this.nextnum = this.lastpage
			}else{	
				this.prevnum = this.page-1
				this.nextnum = this.page+1
			}
		},
		// created_at 데이터 출력 변환
		formatEventDate(dateString) {
			const dateObject = new Date(dateString);
			const year = dateObject.getFullYear();
			const month = String(dateObject.getMonth() + 1).padStart(2, "0");
			const day = String(dateObject.getDate()).padStart(2, "0");

			return `${year}-${month}-${day}`;
		},
		// 로그인확인
		checklocal() {
			if(!(localStorage.getItem('nick'))){
				if (confirm("로그인을 하신 후 이용해 주시기 바랍니다.")) {
					this.$router.push('/login');
				} else {
					return
				}
			}
		},
	}
}
</script>
<style lang="scss" scoped></style>