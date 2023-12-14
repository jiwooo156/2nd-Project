<template>
	<div>
		<!-- <div>
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
		</div> -->
		<div class="main">
			<div class="main_1">
				<!-- <img class="main_sl" src="./img/maru.png" alt="메인이미지" /> -->
				<div class="main_1_box">
					<div class="main_txt">
						놀러오세요! 경상도, 좋아요!<br />블루베리스무디 맛있어요.<br />이의이승이
						뭐냐구요 ?<br />일단, 와보면 알아요!
					</div>
					<!-- 날씨는 반응형 태블릿 때 사라짐 -->
					<div class="main_wea">
						<div class="main_wea_up">날씨 위</div>
						<div class="main_wea_down">날씨 아래</div>
					</div>
				</div>
			</div>
			<!-- 왼쪽 축제정보-- 이거 한 묶음, 왼쪽 색연필 + 경상도!랑 #한 묶음, 보도뉴스들 한 묶음 총 세개로 플렉스 넣기   -->
			<div class="main_2">
				<div class="main_2_box">
					<div class="main_2_box_txt">축제정보</div>
					<div class="main_2_line"></div>
					<!-- main_2_txt 같은 곳에 공통 애니 효과 넣을 거임!! -->
					<img class="main_2_y" src="/img/yellow.png" alt="색연필" />
					<div class="main_2_txt">
						경상도에서 인기있는<br />
						축제를 만나보세요!
					</div>
					<!-- 빈공간 많으면 머시기 넣을지 생각하기 -->
					<!-- <div class="mian_shap">#머시기 #머시기 #머시기</div> -->
					<!-- 반응형 사라질 때 노란효과 없애기 -->
					<div></div>
				</div>
				<div class="main_2_news">
					<!-- 네모 박스가 세로로 줄어들 때 자꾸 줄어들어억!! -->
					<!-- 뉴스 가져오기 a링크 -->
				</div>
			</div>
			<div class="main_3">
				<div class="main_3_box">
					<div class="main_3_left">
						<div class="main_2_box_txt">관광정보</div>
						<div class="main_2_line"></div>
					</div>
					<div class="main_3_mid">
						<img class="main_3_y" src="/img/yellow.png" alt="색연필" />
						<div class="main_3_txt">
							경상도에서 인기있는<br />
							관광지를 만나보세요!
						</div>
					</div>
					<div class="main_3_news">
						<!-- 가운데로 오게 해주세요 제발 -->
					</div>
				</div>
			</div>
			<div class="main_4">
				<div class="main_4_box">
					<div class="main_4_left">
						<div class="main_2_box_txt">행사정보</div>
						<div class="main_2_line"></div>
					</div>
					<img class="main_4_y" src="/img/yellow.png" alt="색연필" />
					<div class="main_4_txt">
						경상도에서 진행 중인<br />
						행사를 만나보세요!
					</div>
				</div>
				<div class="main_4_news">
					<!-- 위에랑 동일하지만 슬라이드 효과른 넣을게요 -->
				</div>
			</div>
			<!-- 똑같이 줬는데 왜 자꾸 얘만 떨어질까 ?? -->
			<div class="main_5">
				<div class="main_5_box">
					<div class="main_5_left">
						<div class="main_2_box_txt">소통광장</div>
						<div class="main_2_line"></div>
					</div>
				</div>
				<!-- 색연필은 맨 위로 올라감 -_- -->
				<img class="main_5_y" src="/img/yellow.png" alt="색연필" />
				<div class="main_5_txt">
					'가가가가?' 다양한<br />
					재미를 공유해 보세요!
				</div>
			</div>
		</div>
		<div>
			<footer class="footer">푸터 띄우기</footer>
		</div>
	</div>
	<div class="main_topBtn"></div>
</template>

<script></script>

<style lang="scss" scoped></style>