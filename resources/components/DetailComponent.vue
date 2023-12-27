<template>
	<div class="detail_frame">
		<div class="detail_container">
			<div class="detail_header_flex">
				<div class="detail_type font_air bold center">
					{{this.detaildata.ns_flg}} {{this.detaildata.states_name}} {{this.detaildata.main_flg}}
				</div>
				<div class="detail_header font_air bold">
					<div class="detail_title  center">
						{{this.detaildata.title}}
					</div>
				</div>
			</div>
			<div>
				<div class="font_air bold center detail_place">
					장소 : {{this.detaildata.place}}
				</div>
				<div 
					v-if="this.detaildata.main_flg==='축제'"
					class="font_air bold center detail_tofrom"
					>
					축제기간 : {{this.detaildata.start_at}} ~ {{this.detaildata.end_at}}
				</div>
				<div class="font_air bold detail_hits">
					조회수 : {{this.detaildata.hits}}
				</div>
			</div>
			<div class="detail_body">
				<div class="detail_img"
					v-if="this.detaildata.img1||this.detaildata.img2||this.detaildata.img3"
				>
					<img :src="this.detaildata.img1"
						v-if="this.detaildata.img1"
					>
					<img :src="this.detaildata.img2"
						v-if="this.detaildata.img2"
					>
					<img :src="this.detaildata.img3"
						v-if="this.detaildata.img3"
					>
				</div>
				<div class="detail_content font_air bold">
					{{this.detaildata.content}}
				</div>
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
						placeholder="이곳에 댓글을 입력해 주세요"
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
					v-if="checkUser(data.nick)"
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
	
	</div>
</template>
<script>
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
		}
	},
	watch: {
		replie(){
			this.replieLength();
		},
	},
	created() {
		this.getinfo();
	},

	updated() {
	},
	methods: {
		getinfo(){
			// 현재url가져오기
			let params = new URLSearchParams(window.location.search);
			this.b_id = params.get('id');
			
			const URL = '/detail/info/'+this.b_id;
			axios.get(URL)
			.then(res => {
				if(res.data.code==="0"){
					this.detaildata = res.data.data[0]
					this.repliedata = res.data.replie
					this.repliecount = res.data.repliecount
					
				}else if(res.data.code==="E99"){
					alert(res.data.errmsg)
				}
			})
			.catch(err => {
				alert('에러가 발생했습니다')
			})
		},
		// 댓글작성
		repliewrite(){
			const URL = '/detail/'+this.b_id;
			const formData = new FormData();
			formData.append('replie', this.replie);
			formData.append('b_id', this.b_id);
			formData.append('nick', this.$store.state.NowUser);
			axios.post(URL,formData)
			.then(res =>{
				if(res.data.code==="0"){
					
					
					this.replie = "",
					this.repliecount++,
					this.repliedata.unshift(res.data.data)
				}
			})
			.catch(err =>{
				// this.$router.push('/error');
			})
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
			this.replie_length = this.replie.length
		},
		// 한글 바로입력
		changeKeyword(e) {
			this.replie = e.target.value
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
		checkUser(nick) {
			return nick === this.$store.state.NowUser;
		},
		// 댓글삭제
		del_replie(id){		
			if (confirm("댓글을 삭제하시겠습니까?")) {
				const URL = '/detail/del/'+id;
				const formData = new FormData();
				axios.post(URL,formData)
				.then(res =>{
					if(res.data.code==="0"){
						
						document.querySelector('#detail_replie'+id).remove()
						this.repliecount--;
					}else{
						
					}
				})
				.catch(err =>{
					// this.$router.push('/error');
			})
			} else {
				return
			}
			
		},
		// 댓글추가 불러오기
		morereplie(){		
			
			
			const URL = '/detail/more/?b_id='+this.b_id+'&offset='+this.replie_offset;
			axios.get(URL)
			.then(res =>{
				if(res.data.code==="0"){
					this.repliedata = [ ...this.repliedata, ...res.data.data ];
					this.replie_offset = this.replie_offset+20;
					
					if(this.repliedata.length === this.repliecount||res.data.data.length<20){
						this.moreflg = true;
					}
					
				}else{
					
				}
			})
				.catch(err =>{
					
			})
			
		},
		// 이메일 마스킹
		masking(str) {
			const checkNull = (s) => {
				return typeof s === 'undefined' || s === null || s === '';
			};
			let originStr = str;
			let emailStr = originStr.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
			let strLength;
			if (checkNull(originStr) || checkNull(emailStr)) {
				return originStr;
			} else {
				strLength = emailStr.toString().split('@')[0].length - 5;
				return originStr.toString().replace(new RegExp('.(?=.{0,' + strLength + '}@)', 'g'), '*');
			}
		},	
	},
	beforeRouteLeave(to, from, next) {
		next();
	},

}
</script>