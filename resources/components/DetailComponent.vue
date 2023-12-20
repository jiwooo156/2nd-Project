<template>
	<div class="detail_frame">
		<div class="detail_container">
			<div class="detail_header_flex">
				<div class="detail_type font_air bold">
					{{this.detaildata.ns_flg}} {{this.detaildata.states_flg}} {{this.detaildata.main_flg}}
				</div>
				<div class="detail_header font_air bold">
					<div class="detail_title font_air bold">
						{{this.detaildata.title}}
					</div>
					<div class="font_air bold">
						조회수 : {{this.detaildata.hits}}
					</div>
				</div>
			</div>
			<div>
				<div class="font_air bold">
					장소 : {{this.detaildata.place}}
				</div>
				<div 
					v-if="this.detaildata.main_flg==='축제'"
					class="font_air bold"
					>
					축제기간 {{this.detaildata.start_at}} ~ {{this.detaildata.end_at}}
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
				<div>
					댓글쓰기 
				</div>
				<input type="text" v-model="replie">
				<button
					@click="repliewrite"
				>+</button>
			</div>
			<div class="detail_replie_read" v-for="data in repliedata" :key="data">
				<div class="font_air bold">
					{{ data.nick }}
				</div>
				<div class="font_air bold">
					{{ data.content }}
				</div>
				<div class="font_air bold">
					{{ converttime(data.created_at) }}
				</div>
			</div>
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
			b_id: "",
		}
	},

	created() {
		this.getinfo();
		this.scrollToTop();
	},

	updated() {

	},
	methods: {
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
		getinfo(){
			// 현재url가져오기
			let params = new URLSearchParams(window.location.search);
			this.b_id = params.get('id');

			const URL = '/detail/'+this.b_id;
			axios.get(URL)
			.then(res => {
				this.detaildata = res.data.data[0]
				this.repliedata = res.data.replie
				console.log(this.repliedata)
			})
			.catch(err => {
				console.log("캐치");
			})
		},
		// 댓글작성
		repliewrite(){
			const URL = '/detail/'+this.b_id;
			const formData = new FormData();
			formData.append('content', this.replie);
			formData.append('b_id', this.b_id);
			formData.append('nick', this.$store.state.NowUser);
			axios.post(URL,formData)
			.then(res =>{
				console.log("댄입장")
				console.log(res.data.data)
				this.replie = "",
				this.repliedata.unshift(res.data.data)
			})
			.catch(err =>{
				console.log("캐치입장")

			})
		},
		scrollToTop() {
			window.scrollTo(0, 0); // 페이지의 맨 위로 스크롤 이동
		},
	},
	beforeRouteLeave(to, from, next) {
		this.$store.commit('setBid',"")
		next();
	},

}
</script>