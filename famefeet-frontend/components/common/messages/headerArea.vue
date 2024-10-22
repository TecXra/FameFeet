<template>
  <div class="">
    <b-navbar toggleable="lg" type="dark" class="topbar justify-content-start">
      <div class="d-lg-none">
        <b-button
          class="mr-3 sideUsersBtn"
          variant="none"
          v-show="sideUsers === true"
          @click="sidebarHideShow(sideUsers)"
          ><i class="fi fi-rr-angle-left"></i
        ></b-button>
        <b-button
          class="mr-3 sideUsersBtn"
          variant="none"
          v-show="sideUsers === false"
          @click="sidebarHideShow()"
          ><i class="fi fi-rr-angle-right"></i
        ></b-button>
      </div>
      <div class="d-flex">
        <b-avatar
          :src="userInfo.avatarURL"
          class="mr-3"
          size="4rem"
          variant="dark"
        ></b-avatar>
        <div class="d-flex flex-column justify-content-center align-self-center">
          <h6 class="mt-2 mb-1">{{ userInfo.userName }}</h6>
          <p class="mb-2" v-if="isUserActive(userInfo.userId)">online</p>
          <p class="mb-2" v-else>offline</p>
        </div>
        <div v-if="message_charges != 0">
          <b-alert class="mb-0" show variant="warning"> ${{ message_charges }} per message will be charged until you buy subscription. </b-alert>
        </div>
      </div>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: "headerArea",
   props: {
    userInfo: {
      type: Object,
      default: () => ({})
    },
    sideUsers:{
      type:Boolean
    }
  },
  data() {
    return {
      message_charges:0
    };
  },
  mounted(){
    this.getCelebrityMessagePrice();
    let self = this;
    this.$nuxt.$on('updateMessagePriceEventCallback', (e) => {
      if(self.userInfo.userId == e.data.userId){
        self.message_charges = e.data.messagePrice;
      }
    });

  },
  methods: {
    sidebarHideShow(opened) {
      opened = !opened;
      this.$emit("sidebarHideShowEvent", opened);
    },
    async getCelebrityMessagePrice(){
      var self = this;
      await this.$axios
        .$get("/getCelebrityMessagePrice?cu_id="+self.userInfo.userId)
        .then(function (response) {
          self.message_charges = response;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        }); 
    },
  },
   watch: {
    userInfo: {
      handler(newVal, oldVal) {
        this.getCelebrityMessagePrice();
      },
      deep: true
    }
  }
};
</script>

<style>
.sideUsersBtn {
  border-radius: 50%;
  color: #000;
}
.sideUsersBtn .fi:before {
  font-weight: bolder !important;
}
</style>
