<template>
	<!-- 헤더 영역 -->
	<div class="header" v-if="$route.fullPath != '/login'||$route.fullPath != '/signin'">
				<h1>헤더</h1>
                <div
                    v-if="!$store.state.cookieFlg"
                >
                <router-link to="/login"
                >로그인</router-link>
                <router-link to="/signin"
                >회원가입</router-link>
                </div>
                <div
                    v-if="$store.state.cookieFlg"
                >
                <router-link 
                    to="/user"
                >{{ $store.state.NowUser }}</router-link>
                <div
                    class="pointer"
                    @click="logout"
                >로그아웃</div>
                </div>
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
        logout(){
            this.$store.dispatch('actionLogout');
        },
        cookienick(){
            let boo = $cookies.get('nick') ?  true : false;
            this.$store.commit('setCookieFlg', boo);
            if(boo){
                let nick = decodeURIComponent(this.$cookies.get('nick'));
                this.$store.commit('setNowUser',nick);
            }
        }
    },
    created() {
        this.cookienick()
    },
    updated(){
        let boo = $cookies.get('nick') ?  true : false;
        this.$store.commit('setCookieFlg', boo);
        if(boo){
            let nick = decodeURIComponent(this.$cookies.get('nick'));
            this.$store.commit('setNowUser',nick);
        }
    },
    data() {
        return {

        }
    }, 
}
</script>
