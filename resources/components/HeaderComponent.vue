<template>
    <!-- 헤더 영역 -->
    <div v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
		<header class="header">
			<div class="header_left">
				<router-link to="/main" class="logo" >안냥</router-link>
			</div>
			<div class="header_mid">
				<nav class="lnb">
					<ul class="nav">
						<li>
							<a href="#" target="_self">홈이야요</a>
							<ul class="depth1">
								<li>
									<a href="#" target="_self" onclick="">블루베리</a>
								</li>
								<li>
									<a href="#" target="_self" onclick="">스우므디</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" target="_self">경상도오</a>
							<ul class="depth1">
								<li>
									<router-link to="/region?ns=경상남도" @click="$store.commit('setNsFlg','1')">경상남도구</router-link>
								</li>
								<li>
									<router-link to="/region?ns=경상북도" @click="$store.commit('setNsFlg','2')">경상북돈디</router-link>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" target="_self">배고프당</a>
							<ul class="depth1">
								<li>
									<a href="#" target="_self" onclick="">마아라탕</a>
								</li>
								<li>
									<a href="#" target="_self" onclick="">먹구시펑</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
			<div class="header_right" v-if="!$store.state.localFlg">
				<ul class="gnb">
					<li>
						<router-link to="/login">로그인</router-link>
					</li>
					<li>
						<router-link to="/authemail">회원가입</router-link>
					</li>
				</ul>
			</div>
            <div class="header_right" v-if="$store.state.localFlg">
				<ul class="gnb">
                    <li>
                        <router-link to="/userchk" class="header_icon">
                            <div>
                                <font-awesome-icon :icon="['fas', 'circle-user']"/>
                            </div>
                            {{ $store.state.NowUser }}
                        </router-link>
                    </li>
					<li @click="logout" class="pointer gnb_logout">로그아웃</li>
				</ul>
			</div>
		</header>
		<a href="javascript:void(0);" class="menu_btn">
			<span></span>
			<span></span>
			<span></span>
			<i class="sound_only">메뉴</i>
		</a>
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