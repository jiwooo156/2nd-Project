<template>
	<!-- 헤더 영역 -->
	<div class="header" v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'">
				<h1>헤더</h1>
                <div
                    v-if="!$store.state.localFlg"
                >
                <router-link to="/login"
                >로그인</router-link>
                <router-link to="/signin"
                >회원가입</router-link>
                </div>
                <div
                    v-if="$store.state.localFlg"
                >
                <router-link 
                    to="/userchk"
                    class="header_username"
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
import RegionComponent from './RegionComponent.vue'
import UserChk from './UserChk.vue'

export default {

    name: 'OpenComponent',
    components: {
        MainComponent,LoginComponent,SigninComponent,UserComponent,UserChk,
    },
    methods: {
        logout(){
            this.$store.dispatch('actionLogout');
        },
        localStoragechk(){
            let boo = localStorage.getItem('nick') ?  true : false;
            if(boo){
                this.$store.commit('setLocalFlg', boo);
                this.$store.commit('setNowUser', localStorage.getItem('nick'));
            }
        }
    },
    created() {
        this.localStoragechk()
    },
    updated(){
        this.localStoragechk()
    },
    data() {
        return {

        }
    }, 
}
</script>
