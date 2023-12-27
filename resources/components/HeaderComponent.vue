<template>
    <!-- 헤더 영역 -->
    <!-- <div v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
		<header class="header">
			<div class="header_left">
				<router-link to="/main" class="logo">안냥</router-link>
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
								<li>  -->
									<!-- 아예 페이지를 새로 불러옴(created 구문을 실행하기 위해서) -->
									<!-- <a href="/region?ns=경상남도">경상남도구</a>
								</li>
								<li>
									<a href="/region?ns=경상북도">경상북돈디</a>
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
    </div> -->
	<div v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding:30px 0px;">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> -->
		<nav class="lnb">
			<ul class="nav">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            경상도오
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
			
            <li><a class="dropdown-item" href="/region?ns=경상북도">경상북도</a></li>
            <li><a class="dropdown-item" href="/region?ns=경상남도">경상남도</a></li>
		
          </ul>
        </li>
		<li class="nav-item dropdown">
          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            커뮤니티
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">자유게시판</a></li>
            <li><a class="dropdown-item" href="#">정보게시판</a></li>
            <li><a class="dropdown-item" href="#">질문게시판</a></li>
            <li><a class="dropdown-item" href="#">건의게시판</a></li>
          </ul>
        </li>
		</ul>
		</nav>
      </ul>
    </div>
	<div class="header_right" v-if="!$store.state.localFlg">
				<ul class="gnb">
					<li>
						<router-link to="/login" style="text-decoration: none;">로그인</router-link>
					</li>
					<li>
						<router-link to="/authemail" style="text-decoration: none;">회원가입</router-link>
					</li>
				</ul>
			</div>
            <div class="header_right" v-if="$store.state.localFlg">
				<ul class="gnb">
                    <li>
                        <router-link to="/userchk" class="header_icon" style="text-decoration: none;">
                            <div>
                                <font-awesome-icon :icon="['fas', 'circle-user']"/>
                            </div>
                            {{ $store.state.NowUser }}
                        </router-link>
                    </li>
					<li @click="logout" class="pointer gnb_logout" style="text-decoration: none;">로그아웃</li>
				</ul>
			</div>
  </div>
</nav>
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