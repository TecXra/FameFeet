<template>
  <div class="app">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KASDHK83"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <CelebrityHeader
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
import CelebrityHeader from "~/components/headers/celebrity.vue";
import Sidebar from "~/components/dashboard/sidebar.vue";

export default {
  middleware: "celebrity",
  name: "celebrityLayout",
  components: {
    CelebrityHeader,
    Sidebar,
  },
  data() {
    return {
      opened: false,
      sidebarItems: [
        {
          name: "My Profile",
          url: "/celebrity/settings/profile",
          icon: "fi-rr-mode-portrait",
        },
        // {
        //   name: "My Phone Number (secure)",
        //   url: "/celebrity/settings/phoneNumber",
        //   icon: "fi-rr-smartphone",
        // },
        {
          name: "Payment Information",
          url: "/celebrity/settings/payment",
          icon: "fi-rr-credit-card",
        },
        {
          name: "My Referrals",
          url: "/celebrity/settings/referrals",
          icon: "fi-rr-user-add",
        },
        {
          name: "My User Reviews",
          url: "/celebrity/settings/reviews",
          icon: "fi-rr-star",
        },
        {
          name: "Edit Password",
          url: "/celebrity/settings/password",
          icon: "fi-rr-password",
        },
        {
          name: "My Blocked Users",
          url: "/celebrity/settings/blockedUsers",
          icon: "fi-rr-ban",
        },
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
