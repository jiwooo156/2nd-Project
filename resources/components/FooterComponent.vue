<template>
	<div class="footer"  v-if="$route.fullPath != '/login'&&$route.fullPath != '/signin'&&$route.fullPath != '/authemail'&&$route.fullPath != '/error'">
    
	</div>
</template>
<script>
export default {
	name: 'FooterComponent',
	props: {

	},
	
	components: {

	},

	data() {
		return {
			setting: '',
		}
	},

	created() {

	},

	mounted() {

	},

	methods: {

	}
}
</script>