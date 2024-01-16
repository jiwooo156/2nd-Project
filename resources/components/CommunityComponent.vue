<template>
	<div class="detail_frame">
		<div class="detail_container">
			<div class="detail_header_flex">
				<div v-if="this.detaildata.flg === '0'" class="detail_type font_air bold center">
					자유게시판
				</div>
				<div v-else="this.detaildata.flg === '1'" class="detail_type font_air bold center">
					정보게시판
				</div>
				<div class="detail_header font_air bold">
					<div class="detail_title  center">
						{{this.detaildata.title}}
					</div>
				</div>
			</div>
			<div class="detail_flex">
				<div class="font_air bold detail_hits">
					{{this.detaildata.nick}}
				</div>
				<div class="font_air bold detail_hits">
					{{this.detaildata.created_at}}
				</div>
				<div class="font_air bold detail_hits" v-if="!(this.detaildata.created_at === this.detaildata.updated_at)">
					(수정됨)
				</div>
				<div class="font_air bold detail_hits">
					조회수 : {{this.detaildata.hits}}
				</div>
			</div>
			<div class="detail_body">
				<!-- <div class="detail_img"
					v-if="this.detaildata.img1||this.detaildata.img2||this.detaildata.img3"
				>
					<img :src="this.detaildata.img1"
						v-if="this.detaildata.img1"
					>
					<br>
					<img :src="this.detaildata.img2"
						v-if="this.detaildata.img2"
					>
					<br>
					<img :src="this.detaildata.img3"
						v-if="this.detaildata.img3"
					>
				</div> -->
				<div class="detail_content font_air bold">
					{{this.detaildata.content}}
				</div>
			</div>
			<div class="detail_content community_heart font_air bold pointer" @click="plusheart()" >
				<!-- fas : 꽉 찬 하트 -->
				<font-awesome-icon :icon="['fas', 'heart']" />
				좋아요 {{this.detaildata.cnt}}
			</div>
			<div class="post_btn_bot">
				<button type="button" v-if="this.detaildata.u_id === this.userauth">수정</button>
				<button type="button" @click="goBack">목록</button>
				<button type="button">삭제</button>
			</div>
		</div>
		<div class="detail_replie_container">
			<div class="detail_replie_write_box font_air bold">
				<div class="font_air bold">
					댓글쓰기  ({{ this.repliecount }})
				</div>
				<div class="detail_replie_relative">	
					<textarea type="text" maxlength="200"
						v-model="replie"  
						@click="checklocal"
						@input="changeKeyword"
						@keyup.enter="repliewrite"
						placeholder="이곳에 소중한 댓글을 작성해 주세요."
					></textarea>
					<div class="detail_replie_length font_air bold">
						{{ this.replie_length }}/200
					</div>
					<button
						@click="repliewrite"
						class="detail_replie_write_box_btn pointer"
					><font-awesome-icon :icon="['fas', 'pen-to-square']" /></button>
				</div>
			</div>
			<div class="detail_replie_read" 
				v-if="repliedata.length !== 0"
				v-for="data in repliedata" :key="data"
				:id='"detail_replie"+data.id'
				>
				<div class="detail_replie_flex">
					<div class="font_air bold detail_replie_nick">
						{{ data.nick }}
						<span class="font_air bold">
							({{ masking(data.email) }})
						</span>
					</div>
					<div class="font_air bold detail_replie_created_at">
						{{ converttime(data.created_at) }}
					</div>
				</div>
				<div class="font_air bold detail_replie_content">
					{{ data.replie }}
				</div>
				<div class="detail_replie_change"
					v-if="checkUser(data.email)"
				>
					<div class="font_air bold pointer"
						@click="del_replie(data.id)"
					>
						삭제
					</div>
				</div>
			</div>
			<div class="detail_replie_read" 
				v-if="repliedata.length === 0">
				<div class="font_air bold detail_no_replie">
					작성된 댓글이 없습니다.
				</div>
			</div>
		</div>
		<div class="center detail_more_btn">
			<span class="center pointer font_air bold"
				@click="morereplie"
				v-if="!(moreflg)&& this.repliecount > 20"
			>
				더보기
				<br>
				<font-awesome-icon :icon="['fass', 'caret-down']" />
			</span>
		</div>
		<div class="goingTop" onclick="window.scrollTo(0,0);"><font-awesome-icon :icon="['fas', 'chevron-up']" /></div>
	</div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
	name: 'DetailComponent',

	data() {
		return {
			detaildata: [],
			repliedata: [],
			replie: "",
			replie_length: 0,
			b_id: "",
			repliecount: "",
			new_replie: "",
			replie_offset: 20,
			moreflg: false,
			userauth: "",
			
		}
	},
	watch: {
		replie(){
			this.replieLength();
		},
	},
	created() {
		// 로컬스토리지에 저장된 정보있는지 확인
		let boo = localStorage.getItem('nick') ?  true : false;
		this.$store.commit('setLocalFlg', boo);

		// 현재url가져오기
		let params = new URLSearchParams(window.location.search);
		this.b_id = params.get('id');
		this.getinfo(this.b_id);
	},

	updated() {
	},
	methods: {
		getinfo(){
			// 현재url가져오기
			// let params = new URLSearchParams(window.location.search);
			// this.b_id = params.get('id');
			
			const URL = '/community/info?id='+this.b_id;
			axios.get(URL)
			.then(res => {
				if(res.data.code==="0"){
					this.detaildata = res.data.data[0];
					this.repliedata = res.data.replie;
					this.repliecount = res.data.repliecount;
					this.userauth = res.data.userauth;
					console.log('zcdvc'+this.userauth);
					console.log('zcdvc'+this.detaildata.u_id);
					console.log('디테일 data : '+this.detaildata.flg);
				}else if(res.data.code==="E99"){
					Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.data.errmsg,
                    confirmButtonText: '확인'
                })
				}
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
		// 댓글작성
		repliewrite(){
			if(this.replie){
				const URL = '/community/reply/'+this.b_id;
				console.log("댓글작성함수 url은 : "+URL);
				const formData = new FormData();
				formData.append('replie', this.replie);
				formData.append('b_id', this.b_id);
				formData.append('flg', '0');
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
						icon: 'error',
						title: 'Error',
						text: '댓글을 작성해 주세요.',
						confirmButtonText: '확인'
                })
			}		
		},
		// 좋아요 입력
		plusheart() {
			if(!(this.userauth === "")) {
				console.log("plusheart 함수 진입");
				// 현재url가져오기
				let params = new URLSearchParams(window.location.search);
				this.b_id = params.get('id');
				console.log("현재 url의 id는 : "+this.b_id);
				const URL = '/community/heartpost';
				console.log("좋아요작성함수 url은 : "+URL);
				axios.post(URL, {
					"b_id": this.b_id,
					"flg": "1"
				})
				.then(res=>{
					console.log("plusheart 함수 then");
					if(res.data.code==="0"){
						this.$router.push('/community?id='+this.b_id);
						this.detaildata.cnt++;
					}
				})
				.catch(err => {
					console.log("plusheart 함수 catch");
					this.$router.push('/error');
				})
			} else {
				Swal.fire({
					icon: 'error',
					title: '주의',
					text: '로그인 후 이용 해 주세요.',
					confirmButtonText: '확인'
                })
			}
		},
		// 시간초기화
		converttime(date){
			const start = new Date(date);
			const end = new Date();
			const diff = (end - start) / 1000;
			const times = [
				{ name: '년', milliSeconds: 60 * 60 * 24 * 365 },
				{ name: '개월', milliSeconds: 60 * 60 * 24 * 30 },
				{ name: '일', milliSeconds: 60 * 60 * 24 },
				{ name: '시간', milliSeconds: 60 * 60 },
				{ name: '분', milliSeconds: 60 },
			];
			for (const value of times) {
				const betweenTime = Math.floor(diff / value.milliSeconds);
				if (betweenTime > 0) {
				return `${betweenTime}${value.name} 전`;
				}
			}
			return '방금 전';
		},
		// 몇글자 적은지 확인
		replieLength() {
			this.replie_length = this.replie.length;
		},
		// 한글 바로입력
		changeKeyword(e) {
			this.replie = e.target.value;
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
		// 유저 본인인지 확인
		checkUser(email) {
			return email === localStorage.getItem('email');
		},
		// 댓글삭제
		del_replie(id){		
			if (confirm("댓글을 삭제하시겠습니까?")) {
				const URL = '/community/del/'+id;
				const formData = new FormData();
				axios.post(URL,formData)
				.then(res =>{
					if(res.data.code==="0"){
						document.querySelector('#detail_replie'+id).remove();
						this.repliecount--;
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
			} else {
				return;
			}
			
		},
		// 댓글추가 불러오기
		morereplie(){
			const URL = '/community/more/?b_id='+this.b_id+'&offset='+this.replie_offset;
			axios.get(URL)
			.then(res =>{
				if(res.data.code==="0"){
					this.repliedata = [ ...this.repliedata, ...res.data.data ];
					this.replie_offset = this.replie_offset+20;			
					if(this.repliedata.length === this.repliecount||res.data.data.length<20){
						this.moreflg = true;
					}
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
		},
		// 이메일 마스킹
		masking(str) {
			// 전달받은 값이 문제가있는지 확인하는 함수
			const testText = (text) => {
				return typeof text === 'undefined' || text === null || text === '';
			};
			// 전달받은 값 변수에 저장
			let teststr = str;
			// 전달받은값 이메일 형식인지 확인
			let result = teststr.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);
			// 공변수 셋팅
			let strLength;
			// 전달받은 값이 문제가 있었거나 정규식 한 값이 잘못됬을경우 
			if (testText(teststr) || testText(result)) {
				// 기존값 리턴
				return teststr;
			} else {
				// 전달받은값의 @전의길이 - 5한 값
				strLength = result.toString().split('@')[0].length - 5;
				// 전달받은 값의 @앞 부분내용중 @ 앞에 있는 부분의 4글자 만큼 *로 변경
				return teststr.toString().replace(new RegExp('.(?=.{0,' + strLength + '}@)', 'g'), '*');
			}
		},	
		// 뒤로가기 동작 실행
		goBack() {
			this.$router.go(-1);
		},
	},
	beforeRouteLeave(to, from, next) {
		next();
	},

}
</script>