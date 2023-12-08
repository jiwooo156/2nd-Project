<template>
	<!-- 헤더 영역 -->
	<div 
        class="header"
	>
				<h1>헤더</h1>
				<p
                    v-if="$store.state.cookieFlg"
                >{{ $store.state.NowUser }}</p>
	</div>
		<!-- 메인 영역 -->
		<router-view></router-view>

		<!-- 푸터 영역 -->
		<div class="footer">

		</div>
</template>
<script>
import MainComponent from './MainComponent.vue'
import LoginComponent from './LoginComponent.vue'
import SigninComponent from './SigninComponent.vue'
import UserComponent from './UserComponent.vue'

export default {

		name: 'OpenComponent',
		components: {
		MainComponent,LoginComponent,SigninComponent,UserComponent
		},
		methods: {
		},
		created() {
            let boo = $cookies.get('nick') ?  true : false;
            this.$store.commit('setCookieFlg', boo);
            if(boo){
                let testt = decodeURIComponent(document.cookie.split(`; `).map((el) => el.split('='))[0][1]);
                this.$store.commit('setNowUser',testt);
            }
		},
		data() {
			return {

			}
		},  
}
</script>
