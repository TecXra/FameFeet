<template>
  <b-modal
    hide-footer
    centered
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
    :id="'content-buy-' + feedtype + itemId"
  >
    <template #modal-title> Payment Option </template>
    <div>
      <div
        id="user-pro-link"
        class="d-flex flex-start align-items-center"
        @click="goToProfile(celebid, userid)"
      >
        <b-avatar :src="urlavatar"></b-avatar>
        <div class="w-100">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="ml-2 fw-bold mb-0" style="color: var(--primary)">
              {{ username }}
            </h6>
          </div>
        </div>
      </div>
    </div>
    <hr />
    <div>
      <div>
        <h3 class="wallet-item-name">{{ name | sentenceCase }}</h3>
        <p class="wallet-item-text mb-1">
          Description:
          <span class="text-muted">{{
            description | sentenceCase
          }}</span>
        </p>
        <!-- <p class="wallet-item-text mb-1">
          Price: <span class="text-muted">{{ price | toCurrency }}</span>
        </p> -->
        <!-- <p class="wallet-item-text mb-1">
          Processing Fees: <span class="text-muted">{{ 0 | toCurrency }}</span>
        </p> -->
        <!-- <p class="wallet-item-text mb-1">
          Total: <span class="text-muted">{{ price | toCurrency }}</span>
        </p> -->
        <p class="wallet-item-text mb-1" v-if="contentType == '5'">
          Quantity:
          <span class="text-muted">
            Content contains {{ Quantity }} <span v-if="Quantity == 1">  image </span> <span v-else> images </span>
          </span>
        </p>
        <p class="wallet-item-text mb-1" v-else>
          Quantity:
          <span class="text-muted">
            Content contains {{ Quantity }} <span v-if="Quantity == 1">  video </span> <span v-else> videos </span>
          </span>
        </p>
      </div>
    </div>
    <small class="mt-4 d-flex justify-content-center"
      >Content will be clear and visible after purchase.</small
    >

    <hr class="mt-1 mb-3" />

    <div class="px-2 py-2">
      <div class="text-center mb-4">
        <!-- <img
          class="wallet-img"
          src="~/static/images/png/wallet.png"
          alt="wallet"
        /> -->
        <p class="wallet-card-text mb-2" v-if="paymnetForOffer == 'pending'">
          Offer Price
        </p>
        <p class="wallet-card-text mb-2" v-else>Content Price</p>

        <!-- <div v-if="isActiveSpinner">
          <b-spinner class="mr-1"></b-spinner>
        </div> -->
        <div>
          <!-- <p class="amount mb-1" v-if="walletDetails == null">
            {{ 0 | toCurrency }}
          </p> -->
          <p class="amount mb-1">
            <!-- {{ walletDetails.available_coins }} -->
            {{ price | toCurrency }}
          </p>
        </div>
      </div>

      <div class="text-center" v-if="paymnetForOffer == 'pending'">
        <b-button
          class="ff-pink-outline border-0 wallet-card"
          variant="none"
          @click="buyOffer(itemId, feedtype)"
          :disabled="isActiveSpinnerOffer"
          ><b-spinner small class="" v-show="isActiveSpinnerOffer"></b-spinner>Buy Offer
        </b-button>
      </div>
      <div class="text-center" v-else>
        <b-button
          class="ff-pink-outline border-0 wallet-card"
          variant="none"
          @click="buyContent(itemId, feedtype)"
          :disabled="isActiveSpinner"
          > <b-spinner small class="" v-show="isActiveSpinner"></b-spinner>Buy Content
        </b-button>
        <!-- <b-button class="ff-pink-outline border-0 wallet-card1">Card</b-button> -->
      </div>
      <!-- <div class="mt-4">
        <span class="text-muted"
          >Making a payment through card will include additional processing
          fees.</span
        >
      </div> -->
    </div>
    <CardInfo
      @paymentSuccess="paymentSuccess"
      :enterdamount="price"
      :showError="true"
    ></CardInfo>
    <!-- {{ paymnetForOffer }} -->
  </b-modal>
</template>

<script>
import CardInfo from "@/components/modal/wallet/cardInfo";

export default {
  components: { CardInfo },

  name: "buy",
  props: [
    "name",
    "description",
    "price",
    "Quantity",
    "contentType",
    "itemId",
    "userid",
    "celebid",
    "username",
    "urlavatar",
    "feedtype",
    "paymnetForOffer",
  ],

  data() {
    return {
      isActiveSpinner: false,
      isActiveSpinnerOffer:false,
      walletDetails: null,
    };
  },
  methods: {
    buyContent(id, type) {
      this.getWallet();
    },
    paymentSuccess() {
      this.getWallet();
    },

    async getWallet() {
      console.log('buy content');
      var self = this;
      self.isActiveSpinner = true;
      await this.$axios
        .$get("/auth/getWalletFanSide")
        .then(function (response) {
          console.log(response);
          if (response == "" || response.remaining_coins < self.price) {
            self.$bvModal.show("card-info");
            self.isActiveSpinner = false;
          } else {
            self.proceedOrder(self.itemId, self.feedtype);
          }
          // if (response == "") {
          //   self.walletDetails = null;
          // } else {
          //   self.walletDetails = response;
          //   self.items = self.walletDetails[0].coinlog;
          //   self.emptyWallet = false;
          // }
          // self.isLoadershow = false;
        })
        .catch(function (error) {});
    },
    async proceedOrder(id, type) {
      var self = this;
      // alert("hi");
      await this.$axios
        .get("/auth/buyPostContent/" + id)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
        })
        .catch(function (error) {
          const object = error.response.data;
          for (const property in object) {
            self.$bvToast.toast(object[property], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
        });
      self.$bvModal.hide("content-buy-" + type + id);
      self.$nuxt.$emit("getcontent");
      self.isActiveSpinner = false;

      // alert("hi2");
    },
    async buyOffer(id, type) {
      var self = this;
      self.isActiveSpinnerOffer = true;
      await this.$axios
        .get("/auth/buyCelebritySendOffer/" + id)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.isActiveSpinnerOffer = false;
        })
        .catch(function (error) {
          console.log('error');
          const object = error.response.data;

          console.log(object);
          // console.log(error.data);
          // console.log(error.data.message);
          self.$bvToast.toast(object.message, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
        self.$bvModal.hide("content-buy-" + type + id);
        self.isActiveSpinnerOffer = false;
        setTimeout(function () {
        self.$nuxt.$emit("getcontent");
         }, 6000);
     
    },

    goToProfile(userid, celebid) {
      // alert(celebid)
      if (this.$store.state.auth.user.user_type == "1") {
        this.$router.push({
          path: "/celebrity/fans/" + userid,
          query: { id: userid, userid: celebid },
        });
      } else {
        this.$router.push({
          path: "/fan/celebrities/" + userid,
          query: { id: userid, userid: celebid },
        });
      }
    },
  },
};
</script>

<style>
.amount {
  font-size: 30px;
  font-weight: 700;
}

.wallet-card {
  padding-left: 2rem !important;
  padding-right: 2rem !important;
}

.wallet-card-text {
  font-size: 20px;
  font-weight: 500;
}

.wallet-item-text {
  font-size: 16px;
  font-weight: 500;
  line-height: 30px;
  color: var(--primary);
}

.wallet-item-name {
  font-size: 26px;
  font-weight: 500;
  line-height: 30px;
  color: var(--primary);
}

.wallet-card1 {
  padding-left: 2.3rem !important;
  padding-right: 2.3rem !important;
}

.wallet-img {
  width: 50px;
  margin-bottom: 5px;
}

#user-pro-link:hover {
  cursor: pointer;
}
</style>
