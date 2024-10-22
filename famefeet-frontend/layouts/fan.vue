<template>
  <div class="app">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KASDHK83"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <FanHeader
      :side-nav-open="opened"
      @sidebarHideShowEvent="sideBarHideShow"
    />
    <div class="wrapper">
      <Sidebar :side-nav="sidebarItems" :sidebarEvent="opened"  @sidebarHideShowEvent="sideBarHideShow" />
      <main class="main w-100" id="content">
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
  name: "fanLayout",
  components: {
    FanHeader,
    Sidebar,
  },
  data() {
    return {
      opened: false,
      sidebarItems: [
        {
          name: "Current Feed",
          url: "/fan/feeds",
          icon: "fi-rr-browser",
        },
        {
          name: "Sock Shop",
          url: "/shop",
          icon: "fi-rr-shopping-cart",
        },
        {
          name: "Buy Content",
          url: "/contents",
          icon: "fi-rr-picture",
        },
        {
          name: "Purchased Content",
          url: "/fan/content/purchased",
          icon: "fi-rr-photo-video",
        },
        {
          name: "Celebrities",
          url: "/fan/celebrities",
          icon: "fi-rr-following",
        },
        {
          name: "Messages",
          url: "/fan/messages",
          icon: "fi-rr-comments",
        },

        {
          name: "My Wallet",
          url: "/fan/wallet",
          icon: "fi-rr-wallet",
        },
        {
          name: "My Subscriptions",
          url: "/fan/subscriptions",
          icon: "fi-rr-users-alt",
        },
        {
          name: "My Sock Orders",
          url: "/fan/orders",
          icon: "fi-rr-ballot",
        },
        {
          name: "My Offers",
          url: "/fan/offers",
          icon: "fi-rr-badge-percent",
        },
        {
          name: "Notifications",
          url: "/fan/notifications",
          icon: "fi-rr-bell",
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
