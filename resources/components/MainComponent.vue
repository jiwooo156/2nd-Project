<template>
	<div>
		<div class="main">
			<div class="main_1">
				<!-- <img class="main_sl" src="./img/maru.png" alt="메인이미지" /> -->
				<div class="main_1_box">
          <div class="main_txt">
            <div class="main_txt_up">
              놀러오세요! 경상도, 좋아요!<br />
            </div>
            <div class="main_txt_down">
              블루베리스무디 맛있어요.<br />이의이승이
              뭐냐구요 ?<br />일단, 와보면 알아요!
            </div>
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
          <div class="main_2_box_left">
            <div class="main_2_sub">
              <div class="main_2_sub_tit">축제정보</div>
              <div class="main_2_sub_line"></div>
            </div>
            <!-- main_2_txt 같은 곳에 공통 애니 효과 넣을 거임!! -->
            <div class="main_2_sub_con">
              <div class="main_2_sub_txt">
                경상도에서 인기있는<br />
                축제를 만나보세요!
              </div>
            </div>
            <!-- 빈공간 많으면 머시기 넣을지 생각하기 -->
            <div class="main_shap">크리스마스 우리 함께 즐겨볼까요🎅</div>
            <!-- 반응형 사라질 때 노란효과 없애기 -->
          </div>
          <div><img class="main_sub_y" src="/img/yellow.png" alt="색연필" /></div>
          <div class="main_2_box_right">
            <!-- <div class="main_2_news">뉴스</div> -->
          </div>
          <!-- <div class="main_2_news"> -->
            <!-- 네모 박스가 세로로 줄어들 때 자꾸 줄어들어억!! -->
            <!-- 뉴스 가져오기 a링크 -->
          <!-- </div> -->
				</div>
			</div>
			<div class="main_3">
				<div class="main_3_box">
          <div class="main_2_box_left">
            <div class="main_2_sub">
              <div class="main_2_sub_tit">관광정보</div>
              <div class="main_2_sub_line"></div>
            </div>
            <div class="main_3_sub_con">
              <div class="main_3_sub_txt">
                경상도에서 다양한<br />
                관광지를 만나보세요!
              </div>
            </div>
            <div class="main_shap">경상도에 이렇게 갈 곳이 많다구요😎</div>
          </div>
          <div><img class="main_3_sub_y" src="/img/yellow.png" alt="색연필" /></div>
          <div class="main_2_box_right">
          </div>
				</div>
			</div>
			<div class="main_2">
        <div class="main_2_box">
          <div class="main_2_box_left">
            <div class="main_2_sub">
              <div class="main_2_sub_tit">유저광장</div>
              <div class="main_2_sub_line"></div>
            </div>
            <div class="main_2_sub_con">
              <div class="main_2_sub_txt">
                유저들과 다양한<br />
                재미를 공유해봐요!
              </div>
            </div>
            <div class="main_shap">'가가가가?'같은 경상도식 유머가 있어요🤗</div>
          </div>
          <div><img class="main_sub_y" src="/img/yellow.png" alt="색연필" /></div>
          <div class="main_2_box_right">
          </div>
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