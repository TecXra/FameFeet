<template>
  <div class="app">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KASDHK83"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <CelebrityHeader
      :side-nav-open="opened"
      @sidebarHideShowEvent="sideBarHideShow"
    />

    <div class="wrapper">
      <Sidebar :side-nav="sidebarItems" :sidebarEvent="opened"  @sidebarHideShowEvent="sideBarHideShow" />
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
          name: "My Content",
          url: "/celebrity/content",
          icon: "fi-rr-picture",
        },
        {
          name: "My Sock Shop",
          url: "/celebrity/shop",
          icon: "fi-rr-shopping-cart",
        },
        {
          name: "My Orders",
          url: "/celebrity/orders",
          icon: "fi-rr-ballot",
        },
        {
          name: "My Offers",
          url: "/celebrity/offers",
          icon: "fi-rr-badge-percent",
        },

        {
          name: "My Wallet",
          url: "/celebrity/wallet",
          icon: "fi-rr-wallet",
        },
        {
          name: "My Subscription Service",
          url: "/celebrity/subscriptions",
          icon: "fi-rr-users-alt",
        },

        {
          name: "Famefeet Users",
          url: "/celebrity/fans",
          icon: "fi-rr-following",
        },

        {
          name: "Messages",
          url: "/celebrity/messages",
          icon: "fi-rr-comments",
        },
        {
          name: "Notifications",
          url: "/celebrity/notifications",
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
