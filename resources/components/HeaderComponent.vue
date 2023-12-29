<template>
    <!-- 헤더 영역 -->
    <div v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
		<header class="header">
			<div class="header_left">
				<router-link to="/main" class="logo">안냥</router-link>
			</div>
			<div class="header_mid">
				<nav class="lnb">
					<ul class="nav">
						<li>
							<router-link to="/main">홈이야요</router-link>
						</li>
						<li>
							<a href="#" target="_self">경상도오</a>
							<ul class="depth1">
								<li> 
									<!-- 아예 페이지를 새로 불러옴(created 구문을 실행하기 위해서) -->
									<router-link to="/region?ns=경상남도">경상남도구</router-link>
								</li>
								<li>
									<router-link to="/region?ns=경상북도">경상북돈디</router-link>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" target="_self">커뮤니티</a>
							<ul class="depth1">
								<li>
									<a href="#" target="_self" onclick="">자유게시판</a>
								</li>
								<li>
									<a href="#" target="_self" onclick="">정보게시판</a>
								</li>
								<li>
									<a href="#" target="_self" onclick="">질문게시판</a>
								</li>
								<li>
									<a href="#" target="_self" onclick="">건의게시판</a>
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
					<li class="gnb_li">
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
					<li @click="logout" class="pointer gnb_logout gnb_li">로그아웃</li>
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