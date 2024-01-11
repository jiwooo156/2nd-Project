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
								<button type="button" class="btn" value="1" @click="buttonclick(1)">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>최신순
								</button>
								<button type="button" class="btn" value="2" @click="buttonclick(2)">
									<span class="font_center"><font-awesome-icon :icon="['fas', 'circle']"/></span>조회순
								</button>
								<button type="button" class="btn" value="3" @click="buttonclick(3)">
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
							<th class="col_hidden">번호</th>
							<th>카테고리</th>
							<th>제목</th>
							<th>작성자</th>
							<th>작성일자</th>
							<th class="col_hidden">조회수</th>
							<th class="col_hidden">좋아요수</th>
						</tr>
					</thead>
					<tbody v-for="infodata in infolist" :key="infodata">
						<!-- <tr class="info_notice pointer">
							<td class="col_hidden">23</td>
							<td>공지사항</td>
							<router-link to="/community">
								<td class="info_title">정보게시판 글 작성시 양식을 지켜주세요!</td>
							</router-link>
							<td>운영자</td>
							<td>23-12-25</td>
							<td class="col_hidden">401</td>
							<td class="col_hidden">25</td>
						</tr> -->
						<tr class="pointer">
							<td class="col_hidden">{{ infodata.id }}</td>
							<td>{{ infodata.category_flg }}</td>
							<td class="info_title">{{ infodata.title }}</td>
							<td>{{ infodata.nick }}</td>
							<td>{{ infodata.created_at }}</td>
							<td class="col_hidden">{{ infodata.hits }}</td>
							<td class="col_hidden">{{ infodata.cnt }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="qna_btn_bot d-flex flex-row-reverse mt-5 mb-5">
				<button type="button">글 작성하기</button>
			</div>
				<div>
					<nav aria-label="Page navigation">
						<ul class="pagination justify-content-center qna_pagin">
							<li v-for="(page, index) in pagination" :key="index">
								
								<a
									id="qna_font"
									class="page-link"
									@click="getInfo(page.label)"
								>
									<span>
										{{ page.label }}
									</span>
								</a>
								<!-- <router-link 
									id="qna_font"
									class="page-link"
									to="#"
								>
									<span>
										{{ page.label }}
									</span>
								</router-link> -->
							</li>
							<!-- <li class="page-item">
								<a
									id="qna_font"
									class="page-link"
									href="#"
									aria-label="Previous"
								>
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angle-left']"
									/></span>
								</a>
							</li> -->
							<!-- <li class="page-item">
								<a
									id="qna_font"
									class="page-link"
									href="#"
									aria-label="Previous"
								>
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angles-left']"
									/></span>
								</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">1</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">2</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">3</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">4</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#">5</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#" aria-label="Next">
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angle-right']"
									/></span>
								</a>
							</li>
							<li class="page-item">
								<a id="qna_font" class="page-link" href="#" aria-label="Next">
									<span aria-hidden="true"
										><font-awesome-icon :icon="['fas', 'angles-right']"
									/></span>
								</a>
							</li> -->
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
			// categoryflg: "",
			rangevalue: "1",
			page: {},
			pagination: {},
			pageChk: {},
			// options: [
			// 	{
			// 	value: "3",
			// 	name: "전체",
			// 	},
			// 	{
			// 	value: "0",
			// 	name: "축제",
			// 	},
			// 	{
			// 	value: "1",
			// 	name: "관광",
			// 	},
			// 	{
			// 	value: "2",
			// 	name: "기타",
			// 	}
      		// ],
      		option: "3"
		}
	},
	created() {
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg');
		console.log( "created flg"+this.nowflg )
		this.getInfo();
	},
	beforeRouteUpdate() {
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg')==="0"? "1":"0";
		console.log("beforeupdated flg"+this.nowflg);
		this.option = "3";
		this.rangevalue = "1";
		this.getInfo();
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
		getInfo(page = 1) {
			// 해당url의 데이터 가져오기
			const URL = '/board/info?page='+page;
			console.log("getinfo 함수진입")
			console.log("nowflg="+this.nowflg)
			console.log("option="+this.option)
			console.log("rangevalue="+this.rangevalue)
			console.log("page="+this.page)
			// axios는 http status code가 200번대면 then으로, 그외에는 catch로
			axios.get(URL, {
				params: {
					flg: this.nowflg,
					category: this.option,
					orderby: this.rangevalue,
					page: this.page,
				}
			})
			.then(res => {
				console.log('여긴가',res.data.information);
				console.log("then");
				console.log('category='+this.option );
				console.log('nowflg='+this.nowflg );
				this.pagination = res.data.information.links;
				console.log('pagination='+this.pagination );
				this.page = res.data.information.current_page;
				console.log('page는 ',this.page);
				this.pageChk  = res.data.information.current_page;
				this.infolist = res.data.information.data;
				console.log('인포리스트='+this.infolist );
				this.cntinfo = res.data.infocnt;
				console.log('카운트인포=', res.data.infocnt);
				console.log('카운트인포='+this.cntinfo );
				console.log('정렬순='+this.rangevalue );
			})
			.catch(err => {
        		this.$router.push('/error');
			})
		},
	}
}
</script>
<style lang="scss" scoped></style>