<template>
	<div class="app" v-if="!loading">
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KASDHK83"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<HomeHeader />
		<div class="app-body">
			<main class="main">
				<div class="app">
					<nuxt />
				</div>
			</main>
		</div>
    <Login></Login>
	</div>
	<div v-else> <Loader ></Loader></div>
	
</template>
<script>
     import Loader from "@/components/common/loader";

	import HomeHeader from "~/components/headers/home.vue";
	import Login from "@/components/modal/auth/login";

	export default {
		name: "homeLayout",
		components: {
			HomeHeader,
			Login,
			Loader,
		},
		data() {
			return {
				loading: true,
			};
		},
		
		computed: {},
    // Failed to execute 'appendChild' on 'Node'
		created() {
			this.$nextTick(function () {
				this.loading = false;
			});
		},
		// updated(){
		// 	this.$echo.join(`user-status-update`).here((users)=>{
		// 		this.$nuxt.$emit('users-online-status', users);
		// 	})
		// 	.joining((user)=>{
		// 		console.log("user-status-update_all_joining");
		// 		this.handleUserOnlineStatus(user)
		// 	})
		// 	.leaving((user)=>{
		// 		console.log("user-status-update_all_leave");
		// 		this.handleUserOnlineStatus(user,false)
		// 	});
		// 	},
	};
</script>
