<template>
	
	
</template>
<script>
import Swal from 'sweetalert2';

export default {
	created() {
		// this.kakaologin();
		console.log("시작")
		this.$store.dispatch('actionLoginKakao');
		console.log("시작")
	},
	mounted() {
	},

	methods: {
		// kakaologin(){
		// 	this.$store.commit('setLoading',true);
		// 	let URL = '/kakaologin/local'
		// 	axios.get(URL)
		// 	.then(res => {
		// 		if(res.data.code === "0"){
		// 			console.log("정상진입")
		// 			console.log(res.data.nick)
		// 			console.log(res.data.email)
		// 			localStorage.setItem('nick', res.data.nick);
		// 			localStorage.setItem('email', res.data.email);
		// 			console.log("라우터직전")
		// 			router.push('/main')
		// 			console.log("라우터안됨")
		// 		}
		// 	})
		// 	.catch(err => {
		// 		Swal.fire({
        //             icon: 'error',
        //             title: 'Error',
        //             text: '로그인에 실패하였습니다.',
        //             confirmButtonText: '확인'
        //         })
		// 	})
		// 	.finally(() => {
		// 		this.$store.commit('setLoading', false);
		// 	});
		// }
	}
}
</script>