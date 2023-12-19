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
              뭐냐구요?<br />일단, 와보면 알아요!
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
              <ul v-for="info in this.besthitsinfoList" :key="info" class="main_2_news_l">
                <ul class="art_plus">
                  <li class="article">{{ info.ns_flg }}</li>
                  <li><a href="#" class="plus_icon"><font-awesome-icon :icon="['fas', 'plus']" /></a></li>
                </ul>
                <ul>
                  <li class="art_tit">{{ info.title }}</li>
                  <li class="art_con">{{ info.content }}</li>
                  <li class="art_date">{{ info.start_at }} ~ {{ info.end_at }}</li>
                </ul>
              </ul>
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
            <ul class="main_hot3">
              <li v-for="info in this.fixedinfoList" :key="info">
                <a href="#" target="관광">
                  <div class="main_hot3_img">
                    <img :src="info.img1">
                  </div>
                  <div class="main_hot3_txt">
                    <span><font-awesome-icon :icon="['fas', 'circle',]" :class="'icon_cir_'+info.id"/> {{ info.title }}</span>
                    <p>{{ info.content }}</p>
                  </div>
                </a>
              </li>
            </ul>
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
          <div class="main_gg"><img src="/img/com.png" alt="gaga"></div>
          <div class="main_box_right">
            <div class="main_4_menu">
              <a href="#">자유<br>게시판<font-awesome-icon :icon="['fas', 'comments']" /></a>
              <a href="#">질문<br>게시판<font-awesome-icon :icon="['fas', 'leaf']" /></a>
              <a href="#">정보<br>게시판<font-awesome-icon :icon="['fas', 'file-pen']" /></a>
              <a href="#">건의<br>게시판<font-awesome-icon :icon="['fas', 'triangle-exclamation']" /></a>
            </div>
          </div>
				</div>
			</div>
    </div>
	</div>
	<div class="main_topBtn"></div>
</template>

<script>
export default {
  name: 'MainComponent',
  data() {
    return {
      besthitsinfoList: [],
      fixedinfoList: [],
    };
  },
  created() {
    this.getMain()
  },
  methods: {
    // 메인에 나타날 데이터 불러오기
    getMain(){
			const URL = '/main/info'
			axios.get(URL)
			.then(res => {
        console.log("댄");
				this.besthitsinfoList = res.data.hits
				this.fixedinfoList = res.data.fixed
			})
			.catch(err => {
        console.log("캐치");
				alert("데이터 에러 발생")
			})
		},
  },
  
}
</script>

<style lang="scss" scoped></style>