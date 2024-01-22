<template>
    <!-- 헤더 영역 -->
    <div v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/admin'&&$route.fullPath != '/error'&&$route.fullPath != '/kakaologin'">
		<header class="header">
			<div class="header_left">
				<router-link to="/main" class="logo">안냥</router-link>
			</div>
			<div class="header_mid">
				<nav class="lnb">
					<ul class="nav">
						<li class="header_li_1">
							<router-link to="/main">홈이야요</router-link>
						</li>
						<li class="header_li_2">
							<router-link to="/region?ns=경상북도"  >경상도오</router-link>
							<ul class="depth1">
								<li>
									<router-link to="/region?ns=경상북도" >경상북도구</router-link>
								</li>
								<li> 
									<!-- 아예 페이지를 새로 불러옴(created 구문을 실행하기 위해서) -->
									<router-link to="/region?ns=경상남도">경상남돈디</router-link>
								</li>
							</ul>
						</li>
						<li class="header_li_3">
							<router-link to="/board?flg=0">커뮤니티</router-link>
							<ul class="depth1">
								<li>
									<router-link to="/board?flg=0" >자유게시판</router-link>
								</li>
								<li>
									<router-link to="/board?flg=1" >정보게시판</router-link>
								</li>
								<li>
									<router-link to="/qna?flg=2" >질문게시판</router-link>
								</li>
								<li>
									<router-link to="/qna?flg=3" >건의게시판</router-link>
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
					<li @click="logout" class="pointer gnb_logout gnb_li">	
						<font-awesome-icon :icon="['fas', 'right-from-bracket']" />
						로그아웃
					</li>
				</ul>
			</div>
		</header>
		<div class="hidden-on-mobile">
			<!-- 여기에 모바일 화면에서만 보이게 하고 싶은 컨텐츠를 넣으세요 -->
			<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top p-3">
			<div class="container-fluid">
				<router-link to="/main" class="navbar-brand font_air bold">      
					<img src="/img/logo.png" alt="" width="100" height="35">
				</router-link>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item">
						<router-link to="/main" class="nav-link active font_air bold" aria-current="page" @click="closeheader">홈이야요</router-link>
					</li>
					<li class="nav-item dropdown">
						<router-link to="/region?ns=경상북도" class="nav-link active font_air bold" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							경상도오
						</router-link>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<li>
								<router-link to="/region?ns=경상북도" class="header_ns dropdown-item font_air bold" @click="closeheader">경상북도구</router-link>
							</li>
							<li> 
								<router-link to="/region?ns=경상남도" class="header_ns dropdown-item font_air bold" @click="closeheader">경상남돈디</router-link>
							</li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<router-link to="/board?flg=0" class="nav-link active font_air bold" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							커뮤니티
						</router-link>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<li>
								<router-link to="/board?flg=0" class="dropdown-item header_ns font_air bold" @click="closeheader">자유게시판</router-link>
							</li>
							<li> 
								<router-link to="/board?flg=1" class="dropdown-item header_ns font_air bold" @click="closeheader">정보게시판</router-link>
							</li>
							<!-- <li><hr class="dropdown-divider"></li> -->
							<li> 
								<router-link to="/qna?flg=2" class="dropdown-item header_ns font_air bold" @click="closeheader">질문게시판</router-link>
							</li>
							<li> 
								<router-link to="/qna?flg=3" class="dropdown-item header_ns font_air bold" @click="closeheader">건의게시판</router-link>
							</li>
						</ul>
					</li>
						<ul v-if="!$store.state.localFlg">
							<li>
								<router-link to="/login" class="nav-link active font_air bold" @click="closeheader" >로그인</router-link>
							</li>
							<li>
								<router-link to="/authemail" class="nav-link active font_air bold" @click="closeheader">회원가입</router-link>
							</li>
						</ul>
						<ul v-if="$store.state.localFlg">
							<li>
								<router-link to="/userchk" class="header_icon nav-link active font_air bold" @click="closeheader">
									<div>
										<font-awesome-icon :icon="['fas', 'circle-user']"/>
									</div>
									{{ $store.state.NowUser }}
								</router-link>
							</li>
							<li @click="logout" class="nav-link active font_air bold">
								<font-awesome-icon :icon="['fas', 'right-from-bracket']" @click="closeheader"/>
								로그아웃
							</li>
						</ul>	
				</ul>
				</div>
			</div>
			</nav>
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
        closeheader(){
            document.querySelector('.navbar-toggler').click();	
        },
	}
}
</script>