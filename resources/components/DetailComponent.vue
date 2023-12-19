<template>
	<div class="detail_frame">
		<div class="detail_container">
			<div class="detail_header_flex">
				<div class="detail_type">
					{{this.detaildata.ns_flg}} {{this.detaildata.states_flg}} {{this.detaildata.main_flg}}
				</div>
				<div class="detail_header">
					<div class="detail_title">
						{{this.detaildata.title}}
					</div>
					<div class="detail_write_time">
						{{this.detaildata.created_at}}
					</div>
					<div>
						조회수 : {{this.detaildata.hits}}
					</div>
				</div>
			</div>
			<div>
				<div>
					장소 : {{this.detaildata.place}}
				</div>
				<div v-if="this.detaildata.main_flg==='축제'">
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
				<div class="detail_content">
					{{this.detaildata.content}}
				</div>
			</div>
		</div>
		<div class="detail_replie_container">
			<div class="detail_replie_write_box">
				댓글
				<input type="text">
				<button>+</button>
			</div>
			<div class="detail_replie_read">
				<div>
					작성자 : {{ this.repliedata.nick }}
				</div>
				<div>
					내용 : {{ this.repliedata.content }}
				</div>
				<div>
					작성시간 : {{ this.repliedata.created_at }}
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
		}
	},

	created() {
		this.getinfo();
	},

	mounted() {

	},

	methods: {
		getinfo(){
			// 현재url가져오기
			let params = new URLSearchParams(window.location.search);
			let idValue = params.get('id');

			console.log(idValue);
			const URL = '/detail/'+idValue;
			axios.get(URL)
			.then(res => {
				this.detaildata = res.data.data[0]
				this.repliedata = res.data.replie[0]
				console.log(this.repliedata )
			})
			.catch(err => {
				console.log("캐치");
			})
		},
	},
	beforeRouteLeave(to, from, next) {
		this.$store.commit('setBid',"")
		next();
	},
}
</script>