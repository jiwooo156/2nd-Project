<template>
	<div>
		<div class="main">
			<div class="main_1">
				<div class="main_1_box">
          <div class="main_txt">
            <div class="main_txt_up animate__animated animate__lightSpeedInRight">놀러오세요! 경상도, 좋아요!<br></div>
            <div class="main_txt_down">블루베리스무디 맛있어요.<br>이의이승이뭐냐구요?<br>일단, 와보면 알아요!</div>
          </div>
					<!-- 날씨는 반응형 태블릿 때 사라짐 -->
					<div class="main_wea">
            <div class="main_wea_up"></div>
						<div class="main_wea_down">
              <div class="main_wea_icon">{{ this.description }}</div>
              <div class="main_wea_degree"></div>
            </div>
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
              <div class="main_sub_txt">경상도에서 인기있는<br>축제를 만나보세요!</div>
            </div>
            <div class="main_shap">크리스마스, 우리 함께 즐겨요🎅</div>
            <img class="main_sub_y" src="/img/yellow.png" alt="pencil" />
          </div>
          <div class="main_box_right">
            <div class="main_2_news">
              <ul v-for="info in this.besthitsinfoList" :key="info" class="main_2_news_l">
                <ul class="art_plus">
                  <li class="article">{{ info.ns_flg }}</li>
                  <li><routerLink :to="'/detail?id='+info.id" class="plus_icon"><font-awesome-icon :icon="['fas', 'plus']" /></routerLink></li>
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
              <div class="main_3_sub_txt">경상도에서 다양한<br>관광지를 만나보세요!
              </div>
            </div>
            <div class="main_shap">경상도에 이렇게 갈 곳이 많다구요😎</div>
            <img class="main_3_sub_y" src="/img/yellow.png" alt="pencil" />
          </div>
            <div class="main_box_right">
              <ul class="main_hot3">
                <li>
                  <router-link to="/detail?id=10">
                    <div class="main_hot3_img">
                      <img src="/img/topic_1.png" />
                    </div>
                    <div class="main_hot3_txt">
                      <span><font-awesome-icon :icon="['fas', 'circle']" class="icon_cir_1"/> 근대역사문화거리</span>
                      <p>100여년 전의 역사가 공존하는<br>특별하고 소중한 시간 여행</p>
                    </div>
                  </router-link>
                </li>
                <li>
                  <router-link to="/detail?id=30">
                    <div class="main_hot3_img">
                      <img src="/img/topic_2.png">
                    </div>
                    <div class="main_hot3_txt">
                      <span><font-awesome-icon :icon="['fas', 'circle']" class="icon_cir_2"/> 댕댕이와 경상도여행</span>
                      <p>전용시설에서 반려동물과<br>사계절 뛰어놀 수 있는 특별한 곳</p>
                    </div>
                  </router-link>
                </li>
                <li>
                  <router-link to="/detail?id=50">
                    <div class="main_hot3_img">
                      <img src="/img/topic_3.png">
                    </div>
                    <div class="main_hot3_txt">
                      <span><font-awesome-icon :icon="['fas', 'circle']" class="icon_cir_3"/> 낮 보다 아름다운 밤</span>
                      <p>다양한 야간관광 특화도시!<br>경상도의 아름다운 야경</p>
                    </div>
                  </router-link>
                </li>
              </ul>
            </div>
          <!-- 계행 넣기 전 for문으로 데이터 불러와서 사용 했을 때
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
            </div> -->
				</div>
			</div>

      <!-- 4차 때 기능 넣을 거임 -->
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
                유저들과 다양한<br/>
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
      // statesName: [],
      cities: [],
      description: '',
    };
  },
  created() {
    // 로컬스토리지에 저장된 정보있는지 확인
		let boo = localStorage.getItem('nick') ?  true : false;
		this.$store.commit('setLocalFlg', boo);
    // 화면에 나타날 데이터
    this.getMain();
    this.getWeather();
  },
  methods: {    
    // 화면에 나타날 데이터 불러오기
    getMain(){
      const URL = '/main/info';
      axios.get(URL)
      .then(res => {
        this.besthitsinfoList = res.data.hits;
        this.fixedinfoList = res.data.fixe;
      })
      .catch(err => {
        console.log("캐치");
        alert("데이터 에러 발생");
      })
    },
    getWeather() {
        // 초기화
        if (this.cityRanLoop) {
            clearInterval(this.cityRanLoop);
        }
        let cities = ['대구', '포항', '경주', '구미', '부산', '울산', '창원', '김해', '밀양'];      
        let i = 0; // 도시 인덱스를 유지할 변수 추가
        const cityRan = () => {
            let city = cities[i];
            i = i + 1;
            if(i === cities.length){
                i = 0;
            }
            console.log(city);
            fetch('https://goweather.herokuapp.com/weather/' + city)
            .then((response) => response.json())
            .then((data) => {
              console.log('test');
              this.description = '';
              if(data.description === 'Sunny') {
                this.description = '☀';
              } else if (data.description === 'Clear') {
                this.description = '🌤';
              } else if (data.description === 'Partly cloudy') {
                this.description = '☁'; 
              } else if (data.description === 'Patchy rain possible' || data.description === 'rain' || data.description === 'Light drizzle') {
                this.description = '🌧'; 
              } 
              document.querySelector('.main_wea_up').innerHTML = city;
              // document.querySelector('.main_wea_icon').innerHTML = data['description'],
              document.querySelector('.main_wea_degree').innerHTML = data['temperature'];
              console.log(data.description);
              // console.log(data.temperature);
            })
            .catch((error) => {
              console.log('에러에러');
            });
        };
        // 최초 한 번 호출
        cityRan();
        // 10초마다 반복 실행
        this.cityRanLoop = setInterval(cityRan, 5000);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>