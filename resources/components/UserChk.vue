<template>
	<br>
	<div class="userChk_container">
		<div class="container">
			<div class="row userchk_header pointer">
				<div class="col font_air bold" @click="flgchange(0)">
					좋아요목록
				</div>
				<div class="col font_air bold" @click="flgchange(1)">
					작성목록
				</div>
				<div class="col font_air bold" @click="flgchange(2)">
					유저정보수정
				</div>
			</div>
		</div>
		<div v-if="mainflg===0" class="userchk_body">
			<select class="form-select form-select-lg mb-3 pointer" aria-label=".form-select-lg example" v-model="likeflg" @change="likeget(this.likeflg,1)">
				<option value="0">축제</option>
				<option value="1">관광</option>
				<option value="2">커뮤니티</option>
			</select>
			<div class="userchk_card_gird">
				<div class="userchk_card" v-for="data in likedata" :key="data">
					<router-link :to='"/detail?id="+data.id' v-if="data.flg==='축제'||data.flg==='관광'">
						<img :src="data.img" v-if="data.flg === '축제'||data.flg === '관광'">
						<div class="region_title ">{{ data.title }}</div>
						<div class="region_content font_air bold">{{ this.nowdate }}기간 : {{ data.start_at }} ~ {{ data.end_at }}</div>
					</router-link>
					<router-link :to='"/community?id="+data.id' v-if="data.flg==='0'||data.flg==='1'">
						<img :src="data.img" v-if="data.flg === '축제'||data.flg === '관광'">
						<div class="region_title ">{{ this.community[data.flg] }}</div>
						<div class="region_title ">제목 : {{ data.title }}</div>
					</router-link>
					<router-link :to='"/post?id="+data.id' v-if="data.flg==='2'||data.flg==='3'">
						<div class="region_title ">{{ this.community[data.flg] }}</div>
						<div class="region_title ">제목 : {{ data.title }}</div>
					</router-link>
					<div v-if="data.flg === '축제'">
						<div v-if="indate(today,data.start_at,data.end_at)" class="region_date_msg1 font_air bold">진행중</div>
						<div v-else-if="beforedate(today, data.start_at)" class="region_date_msg2 font_air bold">
							D-{{ d_day(data.start_at) }}
						</div>
						<div v-else class="region_date_msg3 font_air bold">종료</div>
					</div>
				</div>
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
			<select class="form-select form-select-lg mb-3 pointer" aria-label=".form-select-lg example" v-model="writeflg" @change="writeget(this.writeflg,1)">
				<option value="0">게시글</option>
				<option value="1">댓글</option>
			</select>
			<table class="table table-hover  table-border mb-3">
				<thead>
					<tr
						v-if="writeflg==='0'"
					>
						<th scope="col">작성위치</th>
						<th scope="col">게시글제목</th>
						<th scope="col">내용</th>
						<th scope="col">작성시간</th>
					</tr>			
					<tr
						v-if="writeflg==='1'"
					>
						<th scope="col">작성위치</th>
						<th scope="col">게시글제목</th>
						<th scope="col">댓글내용</th>
						<th scope="col">작성시간</th>
					</tr>			
				</thead>
				<tbody>
					<tr v-for="data in writedata" :key="data"
						v-if="writeflg==='0'"
					>
						<td class="admin_table_td2">{{ community[data.flg] }}</td>
						<td class="admin_table_td2">{{ data.title }}</td>
						<td class="admin_table_td">{{ data.content }}</td>
						<td class="admin_table_td2">{{ data.created_at }}</td>
					</tr>
					<tr v-for="data in writedata" :key="data"
						v-if="writeflg==='1'"
					>
						<td class="admin_table_td2" v-if="data.flg === '축제'||data.flg === '관광'">{{ data.flg }}</td>
						<td class="admin_table_td2" v-if="!(data.flg === '축제'||data.flg === '관광')">{{ community1[data.flg] }}</td>
						<td class="admin_table_td2">{{ data.title }}</td>
						<td class="admin_table_td">{{ data.replie }}</td>
						<td class="admin_table_td2">{{ data.created_at }}</td>
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
				<nav aria-label="Page navigation example">
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
			community:["자유게시판","질문게시판","정보게시판","건의게시판"],
			community1:["자유","질문","정보","건의"],
			likeflg:'0',
			writeflg:'0',
			likedata:{},
			writedata:{},
			today: "",
		}
	},
	created() {
		this.getToday();
		this.likeget('0',1)
	},
	mounted(){
		// 화면 크기에 따라 item 업데이트
		this.updateItem();
		window.addEventListener("resize", this.updateItem);
	},
	beforeDestroy() {
		// 컴포넌트가 파괴되기 전에 이벤트 리스너 제거
		window.removeEventListener("resize", this.updateItem);
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
		// 화면 크기에 따라 itemsToShow를 조절
		updateItem() {
			if (window.innerWidth <= 607) {
				this.item = 3;
			} else if (window.innerWidth <= 747) {
				this.item = 4;
			} else if (window.innerWidth <= 904) {
				this.item = 5;
			} else if (window.innerWidth <= 1024) {
				this.item = 6;
			} else{
				this.item = 7;
			}
		},
	},
}
</script>