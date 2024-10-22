<template>
  <b-navbar toggleable="lg" class="ff-Navbar-Mian py-1 py-md-0">
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
          v-if="msgCounter || notifications || totalQty()"
          >{{ String(msgCounter + notifications + totalQty()) }}</b-badge
        >
        <i v-if="expanded" class="fas fa fa-chevron-up text-light"></i>
        <i v-else class="fas fa fa-bars text-light"></i>
      </template>
    </b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <!-- Left aligned nav items -->
      <b-navbar-nav>
        <b-nav-item
          class="navbar-Mian-Item px-1 text-uppercase"
          @click="goToDashboard()"
          v-if="loggedIn"
        >
          My Dashboard
        </b-nav-item>
        <!-- <b-nav-item
          class="navbar-Mian-Item px-1 text-uppercase"
          @click="goToPage('/signin')"
          v-else
        >
          My Dashboard
        </b-nav-item> -->
        <b-nav-item
          :class="{ active: isLinkActive(item.url) }"
          v-for="(item, index) in navbarItems"
          :key="index"
          class="navbar-Mian-Item px-1 text-uppercase"
          @click="goToPage(item.url)"
        >
          {{ item.name }}
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
        <!-- Notification Bell -->
        <div class="d-flex ml-2 ml-lg-0">
          <b-nav-item class="mr-3 mr-lg-0" v-if="msgCounter > 0">
            <div class="" @click="goToMessages('/fan/messages')">
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
            <div class="" @click="goToMessages('/fan/messages')">
              <b-avatar
                badge-offset="-0.2em"
                class="cart-avatar"
                badge-variant="dark"
              >
                <b-icon icon="envelope" class="" aria-hidden="true"></b-icon>
              </b-avatar>
            </div>
          </b-nav-item>

          <b-nav-item class="mr-3 mr-lg-0" v-if="notifications > 0">
            <div class="" @click="goToNotifications('/fan/notifications')">
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
          <b-nav-item class="mr-3 mr-lg-0" v-else>
            <div class="" @click="goToNotifications('/fan/notifications')">
              <b-avatar
                badge-offset="-0.2em"
                class="cart-avatar"
                badge-variant="dark"
              >
                <b-icon icon="bell" class="" aria-hidden="true"></b-icon>
              </b-avatar>
            </div>
          </b-nav-item>

          <b-nav-item class="" v-show="totalQty() > 0 && user.user_type == '2'">
            <div class="" @click="goToPage('/shop/cart')">
              <b-avatar
                badge-offset="-0.2em"
                :badge="String(totalQty())"
                class="cart-avatar"
                badge-variant="dark"
              >
                <b-icon icon="cart-4" class="" aria-hidden="true"></b-icon>
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
          <router-link
            v-if="user.user_type == '2'"
            class="dropdown-item"
            to="/fan/settings/profile"
            >Profile</router-link
          >
          <router-link
            v-else
            class="dropdown-item"
            to="/celebrity/settings/profile"
            >Profile
          </router-link>
          <b-dropdown-item @click.prevent="logout()">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto" v-else>
        <b-nav-item class="navbar-Mian-Item px-1" @click="goToPage('/signin')"
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
import { mapState } from "vuex";
import { initializeEcho } from '../../plugins/laravel-echo';

export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  components: { FamefeetLogo, Signup },
  name: "homeHeader",

  data: function () {
    return {
      navbarItems: [
        {
          name: "Celebrities",
          url: "/celebrities",
        },
        {
          name: "Content",
          url: "/contents",
        },
        {
          name: "Shop",
          url: "/shop",
        },
        {
          name: "Categories",
          url: "/categories",
        },
      ],
      cart_items: [],
      notifications: null,
      msgCounter: 0,
      allChatUsers: [],
      echo:null,
    };
  },
  async mounted() {
    if (this.$auth.loggedIn == true) {
      this.echo = await initializeEcho(localStorage.getItem('auth._token.local'));
      this.msgNotify();
      this.subNotification();
          this.updateMessagePrice();

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
      this.userStatusUpdate();  
      this.getAllNotifications();

    }

    // Notifications Brodcasting End

    // Cart Items
    this.cart_items = JSON.parse(localStorage.getItem("cart_items") || "[]");
    this.$nuxt.$on("busyitemsarry", (e) => {
      this.cart_items = e;
    });
    // Update Message Counter
    this.$nuxt.$on("updateMsgCount", (e) => {
      this.getUnreadMessagesCount();
    });
    // Notification Read
    this.$nuxt.$on("notificationRead", (e) => {
      this.notifications = null;
    });
  },
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
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
          this.msgCounter++;
        }
      );
    },
    subNotification() {
      this.echo.channel(`edit-subscription.${this.$auth.user.id}`).listen(
        ".EditSubscription",
        (e) => {
          this.notifications++;
        }
      );
    },
     updateMessagePrice() {
      this.echo.channel(`update-message-price`).listen(
        ".UpdateMessagePrice",
        (e) => {
          this.$nuxt.$emit("updateMessagePriceEventCallback",e);
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
          // this.notifications.push(e);
        }
      );
    },
    // End Notifications
    totalQty: function () {
      var sum = 0;
      for (let i = 0; i < this.cart_items.length; i++) {
        this.cart_items[i].items.forEach(function (item) {
          sum += parseInt(item.selected_quantity);
        });
      }
      return sum;
    },
    isLinkActive(href) {
      return this.$route.path === href;
    },
    goToDashboard() {
      if (this.user.user_type == 1) {
        // alert();
        this.goToPage("/celebrity/content");
      }
      if (this.user.user_type == 2) {
        this.goToPage("/fan/feeds");
      }
    },
    goToMessages() {
      if (this.user.user_type == 1) {
        this.goToPage("/celebrity/messages");
      }
      if (this.user.user_type == 2) {
        this.goToPage("/fan/messages");
      }
    },
    goToPage(page) {
      this.$router.push(page);
    },
    goToNotifications() {
      if (this.user.user_type == 1) {
        this.goToPage("/celebrity/notifications");
      }
      if (this.user.user_type == 2) {
        this.goToPage("/fan/notifications");
      }
    },
    async logout() {
      await this.$auth.logout();
      localStorage.removeItem("cart_items");
      localStorage.removeItem("address");
      // this.goToPage("/");
      window.location.href = "/";
    },
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
