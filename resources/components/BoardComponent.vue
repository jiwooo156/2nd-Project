<template>
		<div class="qna_frame">
		<div class="qna_container">
			<div class="qna_header">
				<h1>정보게시판</h1>
				<div class="qna_header_bot">
					<div class="qna_header_l">
						<div class="dropdown">
							<!-- ***전체 카테고리 색상 잘 나오는지 확인!! -->
							<!-- 바텀 마진주기 -->
							<a
								class="btn btn-outline-light dropdown-toggle qna_drop py-3"
								href="#"
								role="button"
								id="dropdownMenuLink"
								data-bs-toggle="dropdown"
								aria-expanded="false"
							>
								전체
							</a>
							<ul
								class="dropdown-menu btn-sm"
								aria-labelledby="dropdownMenuLink"
							>
								<li>
									<a class="dropdown-item qna_drop_item" href="#">축제</a>
								</li>
								<li>
									<a class="dropdown-item qna_drop_item" href="#">관광</a>
								</li>
								<li>
									<a class="dropdown-item qna_drop_item" href="#">기타</a>
								</li>
							</ul>
						</div>
						<!-- 클릭시 버튼 동그라미 색상 변경 #D14C6C/ 글자 검정색/ 좀만 크게 -->
						<div class="qna_btn">
							<button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								최신순
							</button>
							<button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								조회수순
							</button>
							<button type="button">
								<span class="font_center"
									><font-awesome-icon :icon="['fas', 'circle']"
								/></span>
								좋아요순
							</button>
						</div>
					</div>
					<!-- 반응형 숨기기 -->
					<div class="qna_header_r">
						<div>
							총 <span class="qna_pink">50</span>건의 게시글이 있습니다.
						</div>
					</div>
				</div>
				<div class="info_list" v-for="info in infolist" :key="info">
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
						<tbody>
							<tr class="info_notice pointer">
								<td class="col_hidden">23</td>
								<td>공지사항</td>
								<router-link to="/community">
									<td class="info_title">정보게시판 글 작성시 양식을 지켜주세요!</td>
								</router-link>
								<td>운영자</td>
								<td>23-12-25</td>
								<td class="col_hidden">401</td>
								<td class="col_hidden">25</td>
							</tr>
							<tr class="pointer">
								<td class="col_hidden">{{ info.id }}</td>
								<td>{{ info.category_flg }}</td>
								<td class="info_title">{{ info.title }}</td>
								<td>{{ info.nick }}</td>
								<td>{{ info.created_at }}</td>
								<td class="col_hidden">{{ info.hits }}</td>
								<td class="col_hidden">15</td>
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
							<li class="page-item">
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
							</li>
							<li class="page-item">
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
							</li>
						</ul>
					</nav>
				</div>
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
		}
	},
	created() {
		const objUrlParam = new URLSearchParams(window.location.search);
		this.nowflg = objUrlParam.get('flg');
	},
	beforeRouteUpdate() {
		// url의 파라미터를 가져옴
		const objUrlParam = new URLSearchParams(window.location.search);
		console.log(objUrlParam);
		this.nowflg = objUrlParam.get('flg');
		console.log("nowflg="+this.nowflg);
		// 파라미터의 ns를 확인해서 store의 NsFlg셋팅
		// url의 파라미터 중 ns를 세팅함
		if(this.nowflg==="0"){
			console.log(this.nowflg);
			this.$store.commit('setCategoryFlg','0');
		}else if(this.nowflg==="1"){
			console.log(this.nowflg);
			this.$store.commit('setCategoryFlg','1');
		}else if(this.nowflg==="2"){
			console.log(this.nowflg);
			this.$store.commit('setCategoryFlg','2');
		}else if(this.nowflg==="3"){
			console.log(this.nowflg);
			this.$store.commit('setCategoryFlg','3');
		}
		this.getInfo(objUrlParam.get('flg'));
	},
	methods: {
		getInfo(flg) {
			// 해당url의 데이터 가져오기
			const URL = '/board/info?flg='+ flg;
			axios.get(URL)
			// axios는 http status code가 200번대면 then으로, 그외에는 catch로
			.then(res => {
				console.log("getInfo");
				console.log("레스데이터"+res.data);
				if(res.data.code === '0') {
					this.infolist = res.data.information;
				}
			})
			.catch(err => {
        		this.$router.push('/error');
			})
		},
	}
}
</script>
<style lang="scss" scoped></style>