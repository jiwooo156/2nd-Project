<template>
	<div>
		<div class="main">
			<div class="main_1">
				<div class="main_1_box">
          <div class="main_txt">
            <div class="main_txt_up animate__animated animate__lightSpeedInRight">
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
			<div class="main_2">
        <div class="main_2_box">
          <div class="main_box_left"
              data-aos="fade-down"
              data-aos-easing="linear"
              data-aos-duration="1300">
            <div class="main_sub">
              <div class="main_sub_tit">축제정보</div>
              <div class="main_sub_line"></div>
            </div>
            <div class="main_sub_con">
              <div class="main_sub_txt">
                경상도에서 인기있는<br />
                축제를 만나보세요!
              </div>
            </div>
            <div class="main_shap">크리스마스, 우리 함께 즐겨요🎅</div>
            <!-- 반응형 사라질 때 노란색연필 없애기 -->
            <img class="main_sub_y" src="/img/yellow.png" alt="pencil" />
          </div>
          <div class="main_box_right">
            <div class="main_2_news">
              <div class="main_2_news_l">
                <div class="art_plus">
                  <h3 class="article">경상북도</h3>
                  <a href="#" class="plus_icon"><font-awesome-icon :icon="['fas', 'plus']" /></a>
                </div>
                <div class="art_tit">포항 구룡포 선착장에서 열리는 국내 최초의 부두 야시장</div>
                <div class="art_con">해녀조합과 함께하는 해녀 마켓, 전국 최고의 푸드트럭 만...</div>
                <p class="art_date">2023.12.01 - 2023.12.10</p>
              </div>
              <div class="main_2_news_l"><div class="art_plus">
                  <h3 class="article">경상북도</h3>
                  <a href="#" class="plus_icon"><font-awesome-icon :icon="['fas', 'plus']" /></a>
                </div>
                <div class="art_tit">포항 구룡포 선착장에서 열리는 국내 최초의 부두 야시장</div>
                <div class="art_con">해녀조합과 함께하는 해녀 마켓, 전국 최고의 푸드트럭 만...</div>
                <p class="art_date">2023.12.01 - 2023.12.10</p>
              </div>
              <div class="main_2_news_l"><div class="art_plus">
                  <h3 class="article">경상남도</h3>
                  <a href="#" class="plus_icon"><font-awesome-icon :icon="['fas', 'plus']" /></a>
                </div>
                <div class="art_tit">합천 씨파크에서 남녀노소 전 연령대가 다양한 문화를 즐길 수 있는 겨울 축제</div>
                <div class="art_con">실내 난방을 포함, 몸만와서 즐길 수 있는 캠프닉 공간 이...</div>
                <p class="art_date">2023.12.23 - 2024.02.28</p>
              </div>
              <div class="main_2_news_l"><div class="art_plus">
                  <h3 class="article">경상남도</h3>
                  <a href="#" class="plus_icon"><font-awesome-icon :icon="['fas', 'plus']" /></a>
                </div>
                <div class="art_tit">합천 씨파크에서 남녀노소 전 연령대가 다양한 문화를 즐길 수 있는 겨울 축제</div>
                <div class="art_con">실내 난방을 포함, 몸만와서 즐길 수 있는 캠프닉 공간 이...</div>
                <p class="art_date">2023.12.23 - 2024.02.28</p>
              </div>
            </div>
          </div>
				</div>
			</div>
			<div class="main_3">
				<div class="main_3_box">
          <div class="main_box_left"
              data-aos="fade-down"
              data-aos-easing="linear"
              data-aos-duration="1300">
            <div class="main_sub">
              <div class="main_sub_tit">관광정보</div>
              <div class="main_sub_line"></div>
            </div>
            <div class="main_3_sub_con">
              <div class="main_3_sub_txt">
                경상도에서 다양한<br />
                관광지를 만나보세요!
              </div>
            </div>
            <div class="main_shap">경상도에 이렇게 갈 곳이 많다구요😎</div>
            <img class="main_3_sub_y" src="/img/yellow.png" alt="pencil" />
          </div>
          <div class="main_box_right">
          </div>
				</div>
			</div>
			<div class="main_4">
        <div class="main_4_box">
          <div class="main_box_left"
              data-aos="fade-down"
              data-aos-easing="linear"
              data-aos-duration="1300">
            <div class="main_sub">
              <div class="main_sub_tit">유저광장</div>
              <div class="main_sub_line"></div>
            </div>
            <div class="main_sub_con">
              <div class="main_sub_txt">
                유저들과 다양한<br />
                재미를 공유해봐요!
              </div>
            </div>
            <div class="main_shap">'가가가가?'같은 경상도식 유머가 있어요🤗</div>
            <img class="main_sub_y" src="/img/yellow.png" alt="pencil" />
          </div>
          <div class="main_box_right">
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