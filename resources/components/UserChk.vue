<template>
	<br>
	<div class="userChk_container">
		<h1 class="pt-4 pb-3">마이페이지</h1>
		<div class="container">
			<div class="row userchk_header pointer">
				<div class="col font_air bold" @click="flgchange(0)" :class="[{ 'userchk_header_focus': this.mainflg === 0 }]">
					좋아요목록
				</div>
				<div class="col font_air bold" @click="flgchange(1)" :class="[{ 'userchk_header_focus': this.mainflg === 1 }]">
					작성목록
				</div>
				<div class="col font_air bold" @click="flgchange(2)" :class="[{ 'userchk_header_focus': this.mainflg === 2 }]">
					유저정보수정
				</div>
			</div>
		</div>
		<div v-if="mainflg===0" class="userchk_body">
			<select class="form-select form-select-lg mb-3 pointer userchk_select font_air bold	" aria-label=".form-select-lg example" v-model="likeflg" @change="likeget(this.likeflg,1)">
				<option value="0" class="font_air bold">축제</option>
				<option value="1" class="font_air bold">관광</option>
				<option value="2" class="font_air bold">커뮤니티</option>
			</select>
			<div class="userchk_card_gird" v-if="likeflg!=='2'">
				<div class="userchk_card" v-for="data in likedata" :key="data">
					<router-link :to='"/detail?id="+data.id' v-if="data.flg==='축제'||data.flg==='관광'">
						<img :src="data.img" v-if="data.flg === '축제'||data.flg === '관광'">
						<div class="region_title ">{{ data.title }}</div>
						<div class="region_content font_air bold" v-if="data.flg==='축제'">기간 : {{ data.start_at }} ~ {{ data.end_at }}</div>
					</router-link>
					<!-- <router-link :to='"/community?id="+data.id' v-if="data.flg==='0'||data.flg==='1'">
						<img :src="data.img" v-if="data.flg === '축제'||data.flg === '관광'">
						<div class="region_title ">{{ this.community[data.flg] }}</div>
						<div class="region_title ">제목 : {{ data.title }}</div>
					</router-link>
					<router-link :to='"/post?id="+data.id' v-if="data.flg==='2'||data.flg==='3'">
						<div class="region_title ">{{ this.community[data.flg] }}</div>
						<div class="region_title ">제목 : {{ data.title }}</div>
					</router-link> -->
					<div v-if="data.flg === '축제'">
						<div v-if="indate(today,data.start_at,data.end_at)" class="region_date_msg1 font_air bold">진행중</div>
						<div v-else-if="beforedate(today, data.start_at)" class="region_date_msg2 font_air bold">
							D-{{ d_day(data.start_at) }}
						</div>
						<div v-else class="region_date_msg3 font_air bold">종료</div>
					</div>
				</div>
				<div class="pb-3 pt-5"
						v-if="likedata.length < 1"
					>조회된 게시글이 없습니다.</div>
			</div>
			<div v-else>
				<table class="table table-hover  table-border mb-3 table-bordered font_air bold" >
					<thead>	
						<tr>
							<th scope="col" class="none">작성위치</th>
							<th scope="col">게시글제목</th>
							<th scope="col" class="none">작성시간</th>
						</tr>								
					</thead>
					<tbody>
						<tr v-if="writeflg === '0'" v-for="data in likedata" :key="data"  @click="writedetail(data)">
							<td class="userchk_body_td1 none font_air bold">{{ community[data.flg] }}</td>
							<td class="userchk_body_td2 font_air bold">	
								<div>
									<div class="userchk_title font_air bold">
										{{ data.title }}
									</div>
								</div>				
								<div class="userchk_mobile_box font_air bold">
									<div>
										작성위치 : {{ community[data.flg] }}
									</div>
									<div>
										작성일자 : {{ data.created_at }}
									</div>
								</div>
							</td>
							<td class="userchk_body_td3 none font_air bold">
								{{ data.created_at }}
							</td>
						</tr>
						<td colspan="4" class="pb-3 pt-5" 
							v-if="likedata.length < 1&&writeflg==='0'"
						>작성하신 게시글이 없습니다.</td>
					</tbody>
				</table>
			</div>
				<div class='admin_page  mt-3'>
					<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
							<span class="page-link" @click="likeget(likeflg,1)">&lt;&lt;</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
							<span class="page-link" @click="likeget(likeflg,prevnum)">이전</span>
						</li>
						<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
							<span class="page-link" @click="likeget(likeflg,num)">{{ num }}</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
							<span class="page-link" @click="likeget(likeflg,nextnum)">다음</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
							<span class="page-link" @click="likeget(likeflg,lastpage)">>></span>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<div v-if="mainflg===1" class="userchk_body">
			<select class="form-select form-select-lg mb-3 pointer userchk_select font_air bold" aria-label=".form-select-lg example" v-model="writeflg" @change="writeget(this.writeflg,1)">
				<option value="0" class="font_air bold">게시글</option>
				<option value="1" class="font_air bold">댓글</option>
			</select>
			<table class="table table-hover  table-border mb-3 table-bordered">
				<thead>	
					<tr
					v-if="writeflg==='0'"
					>
						<th scope="col" class="none">작성위치</th>
						<th scope="col">게시글제목</th>
						<th scope="col" class="none">작성시간</th>
					</tr>					

					<tr
						v-if="writeflg==='1'"
					>
						<th scope="col" class="none">게시글제목</th>
						<th scope="col">댓글내용</th>
						<th scope="col" class="none">작성시간</th>
					</tr>	
							
				</thead>
				<tbody>
					<tr v-if="writeflg === '0'" v-for="data in writedata" :key="data.id" @click="writedetail(data)">
						<td class="userchk_body_td1 none font_air bold" v-if="data.flg === '축제'||data.flg === '관광'">{{ data.flg }}</td>
						<td class="userchk_body_td1 none font_air bold" v-else>{{ community[data.flg] }}</td>
						<td class="userchk_body_td2 font_air bold">	
							<div>
								<div class="userchk_title font_air bold">
									{{ data.title }}
								</div>
							</div>				
							<div class="userchk_mobile_box font_air bold">
								<div>
									작성위치 : {{ community[data.flg] }}
								</div>
								<div>
									작성일자 : {{ data.created_at }}
								</div>
							</div>
						</td>
						<td class="userchk_body_td3 none font_air bold">
							{{ data.created_at }}
						</td>
					</tr>
					<tr v-for="data in writedata" :key="data"
						v-if="writeflg==='1'"
						@click="repliemodal(data)"
					>
						<td class="userchk_body_td1 none font_air bold">{{ data.title }}</td>
						<td class="userchk_body_td2">
							<div class="userchk_consol font_air bold">
								{{ data.replie }}
							</div>
							<div class="userchk_mobile_box font_air bold">
								<div>
									작성위치 : {{ community[data.flg] }}
								</div>
								<div>
									작성일자 : {{ data.created_at }}
								</div>
							</div>
						</td>
						<td class="userchk_body_td3 none font_air bold">
							{{ data.created_at }}
						</td>
					</tr>
					<td colspan="4" class="pb-3 pt-5" 
						v-if="writedata.length < 1&&writeflg==='0'"
					>작성하신 게시글이 없습니다.</td>
					<td colspan="4" class="pb-3 pt-5"
						v-if="writedata.length < 1&&writeflg==='1'"
					>작성하신 댓글이 없습니다.</td>
				</tbody>
			</table>
			<div class='admin_page  mt-3'>
				<nav aria-label="Page navigation example userchk_page">
					<ul class="pagination">
						<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
							<span class="page-link" @click="writeget(writeflg,1)">&lt;&lt;</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === 1 }, (this.page !== 1) ? 'pointer' : '']">
							<span class="page-link" @click="writeget(writeflg,prevnum)">이전</span>
						</li>
						<li class="page-item" v-for="num in numbox" :key="num" :class="[{ 'active': num === this.page }, (num !== this.page) ? 'pointer' : '']">
							<span class="page-link" @click="writeget(writeflg,num)">{{ num }}</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
							<span class="page-link" @click="writeget(writeflg,nextnum)">다음</span>
						</li>
						<li class="page-item" :class="[{ 'disabled': this.page === this.lastpage }, (this.page !== this.lastpage) ? 'pointer' : '']">
							<span class="page-link" @click="writeget(writeflg,lastpage)">>></span>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<div v-if="mainflg===2">
			<br>	
			<br>	
			<br>	
			<br>	
			<h4 class="font_air bold">본인확인을 위해 비밀번호를 입력해 주세요.</h4>	
			<div>
				<span
					class="sign_errmsg font_air bold"
					>{{ $store.state.varErr[0] }}</span>
					<br><br>
				<input type="password" placeholder="비밀번호" id="userchk_pw"
					@keyup.enter="chk_pw"
				>
			</div>
			<br><br>
			<button
				@click="chk_pw"
				class="userChk_button font_air bold"
			>확인</button>
			<button class="userChk_button font_air bold"><router-link class="userChk_button font_air bold" to="/main">취소</router-link></button>
		</div>
	</div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
	name: 'UserChk',

	data() {
		return {
			mainflg:0,
			// 페이지셋팅
			page:1,
			lastpage:1,
			first_num:1,
			last_num:1,
			prevnum:1,
			nextnum:2,
			numbox:[],
			community: {
				"0": "자유",
				"1": "질문",
				"2": "정보",
				"3": "건의",
				"축제": "축제",
				"관광": "관광"
			},
			likeflg:'0',
			writeflg:'0',
			likedata:{},
			writedata:{},
			today: "",
			mobile: "0",
		}
	},
	created() {
		this.getToday();
		this.likeget('0',1)
	},
	methods: {
		// 유저정보변경페이지로
		chk_pw(){	
			this.$store.dispatch('actionUserChk');
		},
		// 좋아요 누른 목록불러오기
		likeget(flg,page){
			console.log('실행')
			this.$store.commit('setLoading',true);
			const URL = 'userchk/like?page='+page+'&flg='+flg
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){
					this.page = res.data.data.current_page
					this.lastpage = res.data.data.last_page
					this.likedata=res.data.data.data
					this.paging()
				}
			})
			.catch(err => {
				if(err.response.data.code === "E99"){
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '에러발생.',
						confirmButtonText: '확인'
					})
				}
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		// 작성 목록불러오기
		writeget(flg,page){
			console.log('실행')
			this.$store.commit('setLoading',true);
			const URL = 'userchk/write?page='+page+'&flg='+flg
			axios.get(URL)
			.then(res => {
				if(res.data.code === "0"){	
					this.page = res.data.data.current_page
					this.lastpage = res.data.data.last_page
					this.writedata=res.data.data.data
					console.log(this.writedata);
					this.paging()
				}
			})
			.catch(err => {
				if(err.response.data.code === "E99"){
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '에러발생.',
						confirmButtonText: '확인'
					})
				}
			})
			.finally(() => {
				this.$store.commit('setLoading', false);
			});
		},
		flgchange(flg){
			if(flg === 0){
				this.likeget(this.likeflg,1)
			}
			else if(flg === 1){
				this.writeget(this.writeflg,1)
			}
			this.mainflg = flg;
		},
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
		// 오늘날짜함수
		indate(date, startDate, endDate) {
			const today = new Date(date);
			const start = new Date(startDate);
			const end = new Date(endDate);
			return today >= start && today <= end;
		},
		beforedate(date, startDate) {
			const today = new Date(date);
			const start = new Date(startDate);
			return today < start;
		},
		d_day(startDate) {
			const startday = new Date(startDate).getTime();
			const today = new Date(this.today).getTime();
			const result = startday - today;
			const d_day = Math.ceil(result / (1000 * 3600 * 24));
			return d_day;
		},
		getToday() {
			const now = new Date();
			const year = now.getFullYear();
			const month = String(now.getMonth() + 1).padStart(2, '0');
			const day = String(now.getDate()).padStart(2, '0');
			this.today = `${year}-${month}-${day}`;
			// console.log(this.today)
		},
		// tr이라 클릭이벤트로
		writedetail(data) {
			console.log("이벤트진입")
			console.log(data)
			if (data.flg === '0' || data.flg === '1') {
				this.$router.push('/community?id='+data.id);
			} else if (data.flg === '2' || data.flg === '3') {
				this.$router.push('/post?id=' + data.id);
			}
		},
		writedetail2(data) {
			console.log("이벤트진입")
			console.log(data)
			if (data.flg === '0' || data.flg === '1') {
				this.$router.push('/community?id='+data.b_id);
			} else if (data.flg === '2' || data.flg === '3') {
				this.$router.push('/post?id=' + data.b_id);
			} else if (data.flg === '축제' || data.flg === '관광') {
				this.$router.push('/detail?id=' + data.b_id);
			}
		},
		// tr이라 클릭이벤트로
		repliemodal(data) {
			Swal.fire({
				title: '댓글',
				html: `
					<p>작성위치: ${this.community[data.flg]}</p>
					<p>게시글 제목: ${data.title}</p>
					<p>작성내용: ${data.replie}</p>
					<p>작성일자: ${data.created_at}</p>
					<p><button class="user_chk_btn" id="goToPost">-게시글로 이동-</button></p>
				`,
				showConfirmButton: true,
				confirmButtonText: '삭제',
				showCancelButton: true,
				cancelButtonText: '취소',
            })
            .then((result) => {
                if (result.isConfirmed) {
					const URL = 'userchk/replie?id='+data.id
					axios.delete(URL)
					.then(res => {
						if(res.data.code === "0"){
							this.writeget(this.writeflg,this.page)
							Swal.fire({
								icon: 'success',
								title: '완료',
								text: '정상처리되었습니다.',
								confirmButtonText: '확인'
							})
						}
					})
					.catch(err => {
						if(err.response.data.code === "E99"){
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: '에러발생.',
								confirmButtonText: '확인'
							})
						}
					})
				}
			})
			document.getElementById('goToPost').addEventListener('click', () => {
				this.writedetail2(data);
				Swal.close();
			});
		},
	},
}
</script>