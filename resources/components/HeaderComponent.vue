<template>
    <!-- 헤더 영역 -->
    <div class="header" v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'">
        <div class="header_head">
            <router-link to="/main" class="header_logo">
                이의이승
            </router-link>
            <div class="header_menu">
                <router-link to="/main">홈</router-link>
                <div>메뉴</div>
                <div>메뉴</div>
                <div>메뉴</div>
            </div>
        </div>
        <div
            class="header_foot"
            v-if="!$store.state.localFlg"
        >
            <router-link to="/login"
            >로그인</router-link>
            <router-link to="/signin"
            >회원가입</router-link>
        </div>
        <div
            class="header_foot"
            v-if="$store.state.localFlg"
        >
            <router-link 
                to="/userchk"
            >{{ $store.state.NowUser }}</router-link>
            <div
                class="pointer"
                @click="logout"
            >로그아웃</div>
        </div>
	</div>
</template>
<script>
export default {
	name: 'HeaderComponent',

	methods: {
        logout(){
            this.$store.dispatch('actionLogout');
        },
	}
}
</script>