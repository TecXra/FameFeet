<template>
  <b-navbar toggleable="lg" class="ff-Navbar-Mian py-0">
    <b-button
      class="sidebar-toggler"
      v-show="sideNavOpen"
      @click="sidebarHideShow(sideNavOpen)"
      ><i class="fas fa fa-chevron-right"></i>
    </b-button>
    <b-button
      class="sidebar-toggler"
      v-show="!sideNavOpen"
      @click="sidebarHideShow(sideNavOpen)"
      ><i class="fas fa fa-chevron-left"></i>
    </b-button>

    <b-navbar-brand href="/" class="py-0">
      <FamefeetLogo></FamefeetLogo>
    </b-navbar-brand>

    <b-navbar-toggle
      target="nav-collapse"
      class="border-light ff-navbar-toggle"
    >
      <template #default="{ expanded }">
        <b-badge
          variant="danger"
          class="notification-badge"
          v-if="msgCounter || notifications"
          >{{ String(msgCounter + notifications) }}</b-badge
        >
        <i v-if="expanded" class="fas fa fa-chevron-up text-light"></i>
        <i v-else class="fas fa fa-bars text-light"></i>
      </template>
    </b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <!-- Left aligned nav items -->
      <b-navbar-nav>
        <b-nav-item
          :class="{ active: isLinkActive('/celebrity/content') }"
          class="navbar-Mian-Item px-1 text-uppercase"
          @click="goToDashboard('/celebrity/content')"
          v-if="loggedIn"
        >
          My Dashboard
        </b-nav-item>
        <b-nav-item
          class="navbar-Mian-Item px-1 text-uppercase"
          @click="goToPage('/contact')"
          >CONTACT
        </b-nav-item>
        <b-nav-item
          class="navbar-Mian-Item px-1 text-uppercase"
          @click="goToPage('/faq')"
        >
          FAQ
        </b-nav-item>
        <b-nav-item
          class="navbar-Mian-Item px-1 text-uppercase d-block d-lg-none"
          @click.prevent="logout()"
          v-if="loggedIn"
        >
          SIGN OUT
        </b-nav-item>
      </b-navbar-nav>
      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto" v-if="loggedIn">
        <div class="d-flex ml-2 ml-lg-0">
          <b-nav-item class="mr-3 mr-lg-0" v-if="msgCounter > 0">
            <div class="" @click="goToPage('/celebrity/messages')">
              <b-avatar
                badge-offset="-0.2em"
                :badge="String(msgCounter)"
                class="cart-avatar"
                badge-variant="dark"
              >
                <b-icon icon="envelope" class="" aria-hidden="true"></b-icon>
              </b-avatar>
            </div>
          </b-nav-item>
          <b-nav-item class="mr-3 mr-lg-0" v-else>
            <div class="" @click="goToPage('/celebrity/messages')">
              <b-avatar
                badge-offset="-0.2em"
                class="cart-avatar"
                badge-variant="dark"
              >
                <b-icon icon="envelope" class="" aria-hidden="true"></b-icon>
              </b-avatar>
            </div>
          </b-nav-item>

          <b-nav-item class="" v-if="notifications > 0">
            <div class="" @click="goToPage('/celebrity/notifications')">
              <b-avatar
                badge-offset="-0.2em"
                :badge="String(notifications)"
                class="cart-avatar"
                badge-variant="dark"
              >
                <b-icon icon="bell" class="" aria-hidden="true"></b-icon>
              </b-avatar>
            </div>
          </b-nav-item>
          <b-nav-item class="" v-else>
            <div class="" @click="goToPage('/celebrity/notifications')">
              <b-avatar
                badge-offset="-0.2em"
                class="cart-avatar"
                badge-variant="dark"
              >
                <b-icon icon="bell" class="" aria-hidden="true"></b-icon>
              </b-avatar>
            </div>
          </b-nav-item>
        </div>

        <b-nav-item-dropdown right no-caret class="d-none d-lg-block">
          <template #button-content>
            <b-avatar
              class="my-0 py-0 navbar-dropdown-avatar"
              :src="user.avatarURL"
            ></b-avatar>
          </template>
          <router-link class="dropdown-item" to="/celebrity/settings/profile"
            >Profile</router-link
          >
          <b-dropdown-item @click.prevent="logout()">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>

      <b-navbar-nav class="ml-auto" v-else>
        <b-nav-item
          class="navbar-Mian-Item px-1"
          href
          @click="goToPage('/signin')"
          >SIGN IN</b-nav-item
        >
        <b-nav-item
          class="ff-Navbar-signup px-1"
          @click="$bvModal.show('signup-model')"
          >SIGN UP</b-nav-item
        >
      </b-navbar-nav>
    </b-collapse>
    <Signup></Signup>
  </b-navbar>
</template>
<script>
import FamefeetLogo from "@/components/common/logo";
import Signup from "@/components/modal/auth";
import { initializeEcho } from '../../plugins/laravel-echo';

import { mapState } from "vuex";
export default {
  components: { FamefeetLogo, Signup },
  name: "celebrityHeader",
  props: {
    sideNavOpen: {
      type: Boolean,
      required: true,
    },
  },
  data: function () {
    return {
      cart_items: [],
      notifications: null,
      msgCounter: 0,
      allChatUsers: [],
      echo:null,

    };
  },
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
   async mounted() {
    if (this.$auth.loggedIn == true) {
    this.echo = await initializeEcho(localStorage.getItem('auth._token.local'));
    this.msgNotify();
    this.subNotification();
    this.follownotify();
    this.changeOrderStatus();
    this.unfollownotify();
    this.buySubscription();
    this.placeOrder();
    this.sendOffer();
    this.sendTip();
    this.uploadOffer();
    this.sharepost();
    this.buycontent();
    this.addTracking();
    this.cancelOffer();
    this.buyCustomOffer();
    this.sendCustomOffer();
    this.sendComment();
    this.likeContent();
    this.CelebrityRate();
    this.FanRate();
    this.userStatusUpdate();  
    this.getUnreadMessagesCount();
    this.getAllNotifications();
    }
    // End Notifications
    
    // Update Message Counter
    this.$nuxt.$on("updateMsgCount", (e) => {
      this.getUnreadMessagesCount();
    });
    // Notification Read
    this.$nuxt.$on("notificationRead", (e) => {
      this.notifications = null;
    });
  },
  methods: {
    async getUnreadMessagesCount() {
      var self = this;
      await this.$axios
        .$get("/auth/getUnreadMessagesCount")
        .then(function (response) {
          self.msgCounter = response;
        })
        .catch(function (error) {});
    },
    isLinkActive(href) {
      return this.$route.path === href;
    },
    sidebarHideShow(opened) {
      this.$emit("sidebarHideShowEvent", !opened);
    },
    goToDashboard() {
      if (this.user.user_type == 1) {
        this.goToPage("/celebrity/content");
      }
      if (this.user.user_type == 2) {
        this.goToPage("/fan/celebrities");
      }
    },
    goToPage(page) {
      this.$router.push(page);
    },
    async logout() {
      await this.$auth.logout();
      localStorage.removeItem("cart_items");
      localStorage.removeItem("address");
      window.location.href = "/";

    },
    async getAllNotifications() {
      var self = this;
      await this.$axios
        .$get("/auth/unReadNotificationCount")
        .then(function (response) {
          self.notifications = response;
        })
        .catch(function (error) {});
    },
    // Notifications Brodcasting
    buyCustomOffer() {
      this.echo.channel(`buy-custom-offer.${this.$auth.user.id}`).listen(
        ".BuyCustomOffer",
        (e) => {
          this.notifications++;
        }
      );
    },
    sendCustomOffer() {
      this.echo.channel(`celebrity-send-offer.${this.$auth.user.id}`).listen(
        ".CelebritySendOffer",
        (e) => {
          this.notifications++;
        }
      );
    },
    addTracking() {
      this.echo.channel(`add-tracking-number.${this.$auth.user.id}`).listen(
        ".AddTrackingNumber",
        (e) => {
          this.notifications++;
        }
      );
    },
    cancelOffer() {
      this.echo.channel(`cancel-offer.${this.$auth.user.id}`).listen(
        ".CancelOffer",
        (e) => {
          this.notifications++;
        }
      );
    },
    msgNotify() {
      this.echo.channel(`messages.${this.$auth.user.id}`).listen(
        ".UserMessageEvent",
        (e) => {
          this.$nuxt.$emit("userMessageEventCallback",e);
          this.msgCounter++;
        }
      );
      // console.log(this.msgCounter);
    },
    subNotification() {
      this.echo.channel(`edit-subscription.${this.$auth.user.id}`).listen(
        ".EditSubscription",
        (e) => {
          this.notifications++;
        }
      );
    },
    follownotify() {
      this.echo.channel(`follow-user.${this.$auth.user.id}`).listen(
        ".FollowUser",
        (e) => {
          this.notifications++;
        }
      );
    },
    unfollownotify() {
      this.echo.channel(`unfollow-user.${this.$auth.user.id}`).listen(
        ".UnFollowUser",
        (e) => {
          this.notifications++;
        }
      );
    },
    changeOrderStatus() {
      // alert(this.$auth.user.id);
      this.echo.channel(`change-order-status.${this.$auth.user.id}`).listen(
        ".ChangeOrdderStatus",
        (e) => {
          this.notifications++;
        }
      );
    },
    buySubscription() {
      this.echo.channel(`buy-subscription.${this.$auth.user.id}`).listen(
        ".BuySubscription",
        (e) => {
          this.notifications++;
        }
      );
    },
    userStatusUpdate() {
      this.echo.join(`user-status-update`).here((users)=>{
        this.$store.dispatch('users/storeActiveUsers', users);
      })
      .joining((user)=>{
        this.$store.dispatch('users/storeActiveUser', user);
      })
      .leaving((user)=>{
        this.$store.dispatch('users/removeActiveUser', user);
      });
    },
    placeOrder() {
      this.echo.channel(`place-order.${this.$auth.user.id}`).listen(
        ".PlaceOrder",
        (e) => {
          this.notifications++;
        }
      );
    },
    sendOffer() {
      this.echo.channel(`send-offer.${this.$auth.user.id}`).listen(
        ".SendOffer",
        (e) => {
          this.notifications++;
        }
      );
    },
    sendTip() {
      this.echo.channel(`send-tip.${this.$auth.user.id}`).listen(
        ".SendTip",
        (e) => {
          this.notifications++;
        }
      );
    },
    sharepost() {
      this.echo.channel(`share-post.${this.$auth.user.id}`).listen(
        ".SharePost",
        (e) => {
          this.notifications++;
        }
      );
    },
    buycontent() {
      this.echo.channel(`buy-content.${this.$auth.user.id}`).listen(
        ".BuyContent",
        (e) => {
          this.notifications++;
        }
      );
    },
    uploadOffer() {
      this.echo.channel(`upload-offer.${this.$auth.user.id}`).listen(
        ".UploadOffer",
        (e) => {
          this.notifications++;
        }
      );
    },
    sendComment() {
      this.echo.channel(`send-comment.${this.$auth.user.id}`).listen(
        ".SendComment",
        (e) => {
          this.notifications++;
        }
      );
    },
    likeContent() {
      this.echo.channel(`like-content.${this.$auth.user.id}`).listen(
        ".LikeContent",
        (e) => {
          this.notifications++;
        }
      );
    },
    CelebrityRate() {
      this.echo.channel(`celebrity-rate.${this.$auth.user.id}`).listen(
        ".CelebrityRate",
        (e) => {
          this.notifications++;
        }
      );
    },
    FanRate() {
      this.echo.channel(`fan-rate.${this.$auth.user.id}`).listen(
        ".FanRate",
        (e) => {
          this.notifications++;
        }
      );
    }
  },
};
</script>
<style lang="css" scoped>
.cart-avatar:hover {
  transform: scale(1.05);
}

.cart-avatar {
  background-color: var(--secondary) !important;
  transition: all 0.3s;
}
.notification-badge {
  position: absolute;
  top: 0;
  right: 0;
  top: -10px;
  right: -10px;
  padding: 0.3em;
  border-radius: 20px;
  padding-right: 7px !important;
  padding-left: 7px !important;
  padding-top: 5px !important;
}
.ff-navbar-toggle {
  position: relative;
}
</style>
