<template>
	<div>
		<div>
			<div>회원가입</div>
			<div
				v-for="item in $store.state.varErr" :key="item" class="regist_err">{{ item[0] }}</div>
			<div>
				<div>
					<div>
						<div>E-mail</div>
						<input type="email">
						<button>중복확인</button>
					</div>
					<div>
						<div>비밀번호</div>
						<input type="password">
					</div>
					<div>
						<div>비밀번호확인</div>
						<input type="password">
					</div>
					<div>
						<div>이름</div>
						<input type="text">
					</div>
					<div>
						<div>성별</div>
						<select  id="shop_type" class="shop_modal_select">
							<option>남자</option>
							<option>여자</option>
						</select>	
					</div>
					<div>
						<div>닉네임</div>
						<input type="text">
					</div>
					<div>
						<div>전화번호</div>
						<input type="text">
					</div>
					<div>
						<button>회원가입</button>
						<router-link :to="'/main'">취소</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'SigninComponent',
	props: {

	},
	
	components: {

	},

	data() {
		return {
			setting: '',
		}
	},

	created() {

	},

	mounted() {

	},

	methods: {

	}
}
</script>