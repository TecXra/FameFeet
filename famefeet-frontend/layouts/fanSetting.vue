<template>
  <div class="app">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KASDHK83"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <FanHeader
      :side-nav-open="opened"
      @sidebarHideShowEvent="sideBarHideShow"
    />
    <div class="wrapper">
      <Sidebar
        :side-nav="sidebarItems"
        :sidebarEvent="opened"
        :settingSide="true"
        @sidebarHideShowEvent="sideBarHideShow"
      />
      <main class="main w-100">
        <nuxt />
      </main>
    </div>
  </div>
</template>
<script>
import FanHeader from "~/components/headers/fan.vue";
import Sidebar from "~/components/dashboard/sidebar.vue";

export default {
  middleware: "fan",
  name: "fanSetting",
  components: {
    FanHeader,
    Sidebar,
  },
  data() {
    return {
      opened: false,
      sidebarItems: [
        {
          name: "My Profile",
          url: "/fan/settings/profile",
          icon: "fi-rr-mode-portrait",
        },
        // {
        //   name: "My Phone Number (secure)",
        //   url: "/fan/settings/phoneNumber",
        //   icon: "fi-rr-smartphone",
        // },
        // {
        //   name: "My Reviews",
        //   url: "/fan/settings/reviews",
        //   icon: "fi-rr-star",
        // },
        {
          name: "Edit Password",
          url: "/fan/settings/password",
          icon: "fi-rr-password",
        },
        // {
        //   name: "My Blocked Users",
        //   url: "/fan/settings/blockedUsers",
        //   icon: "fi-rr-ban",
        // },
      ],
    };
  },
  methods: {
    sideBarHideShow(event) {
      // alert(event)
      this.opened = event;
    },
  },
  computed: {},
};
</script>
<style lang="css" scoped>
.main {
  height: calc(100vh - 68px);
  overflow: auto;
  overflow-x: hidden;
}
</style>
