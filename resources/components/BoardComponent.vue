<template lang="">
	<div class="info_frame">
		<div class="info_header">
			<div class="info_header_title">정보게시판</div>
		</div>
		<div class="info_container">
			<div class="info_sortframe">
				<div class="info_sortlist">
					<div class="info_sort">
						<div class="info_sortp">●</div>
						<div class="info_sortc pointer">최신순</div>
					</div>
					<div class="info_sort">
						<div class="info_sortp">●</div>
						<div class="info_sortc pointer">조회순</div>
					</div>
					<div class="info_sort">
						<div class="info_sortp">●</div>
						<div class="info_sortc pointer">좋아요순</div>
					</div>
				</div>
				<div class="info_btnwrite pointer">글 작성하기</div>
			</div>
			<div class="info_list">
				<table>
					<colgroup>
						<col class="info_id">
						<col class="info_category">
						<col class="info_title">
						<col class="info_writer">
						<col class="info_create_at">
						<col class="info_hits col_hidden">
						<col class="info_likes col_hidden">
					</colgroup>
					<thead>
						<tr>
							<th>번호</th>
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
							<td>23</td>
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
							<td>22</td>
							<td>관광지</td>
							<td class="info_title">경리단길 카페 추천드립니다!</td>
							<td>랄로</td>
							<td>23-10-09</td>
							<td class="col_hidden">232</td>
							<td class="col_hidden">15</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="info_pageframe">
			<div class="info_previous pointer">이전페이지</div>
			<div class="info_page pointer">1</div>
			<div class="info_page pointer">2</div>
			<div class="info_page pointer">3</div>
			<div class="info_next pointer">다음페이지</div>
		</div>
	</div>
</template>
<script>
export default {
	name: "BoardComponent",
}
</script>
<style lang="">
	
</style>