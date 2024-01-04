<template>
    <div class="spinner-div" v-if="$store.state.loading">
        <span class="loader"></span>
    </div>
    <HeaderComponent></HeaderComponent>
    <!-- 메인 영역 -->
    <router-view></router-view>
    <!-- 푸터 영역 -->
    <FooterComponent></FooterComponent>
</template>
<script>
import MainComponent from './MainComponent.vue'
import AdminComponent from './AdminComponent.vue'
import LoginComponent from './LoginComponent.vue'
import SigninComponent from './SigninComponent.vue'
import UserComponent from './UserComponent.vue'
import RegionComponent from './RegionComponent.vue'
import HeaderComponent from './HeaderComponent.vue'
import AuthComponent from './AuthComponent.vue'
import UserChk from './UserChk.vue'
import ErrorComponent from './ErrorComponent.vue'
import FooterComponent from './FooterComponent.vue'
import DetailComponent from './DetailComponent.vue'
export default {

    name: 'OpenComponent',
    components: {
        MainComponent,LoginComponent,SigninComponent,UserComponent,UserChk,RegionComponent,HeaderComponent,RegionComponent,AuthComponent,ErrorComponent,FooterComponent,DetailComponent,AdminComponent
    },
    methods: {
        localStoragechk(){
            let boo = localStorage.getItem('nick') ?  true : false;
            if(boo){
                this.$store.commit('setLocalFlg', boo);
                this.$store.commit('setNowUser', localStorage.getItem('nick'));
            }
        },
        loginchk(){
            const URL = '/loginchk'
            axios.get(URL)
            .then(res => {
                if(res.data.code !== "0"){
                    localStorage.clear();
                    this.$store.commit('setLocalFlg', false);
                }
            })
            .catch(err => {
                localStorage.clear();
            });
        }
    },
    beforeCreate() {
        console.log('비포크리에이트');
    },
    created() {
        console.log('크리에이트');
        this.loginchk();
        this.localStoragechk();
        this.$store.commit('setLoading',true);
    },
    created() {
        console.log('크리에이트');
        this.loginchk();
        this.localStoragechk();
        this.$store.commit('setLoading',true);
    },
    updated(){
        console.log('업데이트');
        this.localStoragechk();
    },
    mounted(){
        this.$store.commit('setLoading',false);
    },
}
</script>
