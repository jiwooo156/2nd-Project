<template>
    <HeaderComponent></HeaderComponent>
    <!-- 메인 영역 -->
    <router-view></router-view>

    <!-- 푸터 영역 -->
    <div class="footer"  v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'">

    </div>
</template>
<script>
import MainComponent from './MainComponent.vue'
import LoginComponent from './LoginComponent.vue'
import SigninComponent from './SigninComponent.vue'
import UserComponent from './UserComponent.vue'
import RegionComponent from './RegionComponent.vue'
import HeaderComponent from './HeaderComponent.vue'
import AuthComponent from './AuthComponent.vue'
import UserChk from './UserChk.vue'
import ErrorComponent from './ErrorComponent.vue'
export default {

    name: 'OpenComponent',
    components: {
        MainComponent,LoginComponent,SigninComponent,UserComponent,UserChk,RegionComponent,HeaderComponent,RegionComponent,AuthComponent,ErrorComponent
    },
    methods: {

        localStoragechk(){
            let boo = localStorage.getItem('nick') ?  true : false;
            if(boo){
                this.$store.commit('setLocalFlg', boo);
                this.$store.commit('setNowUser', localStorage.getItem('nick'));
            }
        }
    },
    created() {
        this.localStoragechk()
    },
    updated(){
        this.localStoragechk()
    },
    data() {
        return {

        }
    }, 
}
</script>
