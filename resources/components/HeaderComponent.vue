<template>
    <!-- 헤더 영역 -->
    <div>
		<header class="header">
			<div class="header_left">
				<h1 class="logo"><a href="#">안냥</a></h1>
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
									<a href="#" target="_self" onclick="">경상남도구</a>
								</li>
								<li>
									<a href="#" target="_self" onclick="">경상북돈디</a>
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
			<div class="header_right">
				<ul class="gnb">
					<li>
						<a href="#">로그인</a>
					</li>
					<li>
						<a href="#">회원가입</a>
					</li>
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