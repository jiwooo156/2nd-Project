<template>
	<!-- 헤더 영역 -->
	<div class="header">
        <h1>헤더</h1>
	</div>
    <!-- 메인 영역 -->
    <router-view></router-view>

    <!-- 푸터 영역 -->
    <div class="footer">

    </div>
</template>
<script>
import MainComponent from './MainComponent.vue'
import LoginComponent from './LoginComponent.vue'
import SigninComponent from './SigninComponent.vue'

export default {

    name: 'OpenComponent',
    components: {
		MainComponent,LoginComponent,SigninComponent,
    },
    methods: {

    },
    created() {

    },
}
</script>
