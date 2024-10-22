<template>
  <b-modal
    hide-footer
    hide-header
    size="lg"
    centered
    id="card-info"
    content-class="payment-card-model"
  >
    <div class="mx-auto payment-model">
      <div class="card border-0">
        <div class="row justify-content-center">
          <h3 class="mb-2">Credit Card Checkout</h3>
        </div>
        <!-- <p class="error-text" v-if="showError">
          Please add amount to your account before proceeding with this
          transaction.
        </p> -->
        <div class="row">
          <div class="col-sm-6 border-line pb-3">
            <div class="form-group">
              <p class="text-muted text-sm mb-0">Name on the card</p>
              <input
                type="text"
                name="name"
                v-model="card.card_holder_name"
                placeholder="Name"
                size="15"
                :disabled="!is_new"
              />
            </div>
            <div class="form-group">
              <p class="text-muted text-sm mb-0">Card Number</p>
              <div class="row px-3">
                <the-mask
                  placeholder="0000 0000 0000 0000"
                  type="text"
                  :mask="['#### #### #### ####']"
                  v-model="card.card_number"
                  :disabled="!is_new"
                />
                <p class="mb-0 ml-3">/</p>
                <i class="ml-1 card-icon" :class="cardBrandClass"></i>
                <!-- <img class="image ml-1" src="https://i.imgur.com/WIAP9Ku.jpg" /> -->
              </div>
            </div>
            <div class="form-group">
              <p class="text-muted text-sm mb-0">Expiry date</p>
              <the-mask
                placeholder="MM/YY"
                v-model="card.date"
                type="text"
                class="payment-date"
                :mask="['##/##']"
                :disabled="!is_new"
              />
            </div>
            <div class="form-group">
              <p class="text-muted text-sm mb-0">CVV/CVC</p>
              <input
                type="password"
                name="cvv"
                v-model="card.cvc"
                placeholder="000"
                size="1"
                minlength="3"
                maxlength="3"
                :disabled="!is_new"
                @input="onInput"
              />
            </div>
            <!-- <div class="form-group mb-0">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input id="chk1" type="checkbox" name="chk" class="custom-control-input" checked>
                                <label for="chk1" class="custom-control-label text-muted text-sm">save my card
                                    for future payment</label>
                            </div>
                        </div> -->
          </div>
          <div
            class="col-sm-6 text-sm-center justify-content-center align-self-center"
          >
            <div class="ml-3">
              <form class="pb-3 px-">
                <div
                  class="d-flex flex-row pb-3"
                  v-for="(item, index) in userCardInfo.user_card_details"
                  :key="index"
                >
                  <!-- {{ item }} -->
                  <div class="d-flex align-items-center mr-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="radioNoLabel"
                      id="radioNoLabel1"
                      @input="selectCard(index)"
                      v-model="card_id"
                      :value="item.id"
                      aria-label="..."
                      checked
                    />
                  </div>
                  <!-- {{ item.customer_payment_profile_id }} -->
                  <div class="rounded border w-100">
                    <div class="d-flex justify-content-end pr-3">
                      <b-dropdown
                        variant="bg-white"
                        menu-class="dropdown-style"
                        toggle-class="p-0"
                        no-caret
                      >
                        <template #button-content>
                          <b-icon icon="three-dots"></b-icon>
                        </template>

                        <b-dropdown-item
                          @click="
                            deleteCardRequest(item.customer_payment_profile_id)
                          "
                          >Delete</b-dropdown-item
                        >
                      </b-dropdown>
                    </div>
                    <div class="d-flex align-items-center px-3 pb-4">
                      <p class="mb-0">
                        <i
                          class="fa fa-cc-visa text-primary pr-2 fa-lg"
                          aria-hidden="true"
                        ></i
                        >Debit Card
                      </p>
                      <div class="ml-auto">***{{ item.card_number }}</div>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            <small class="text-sm text-muted">Payment amount</small>
            <div class="row px-3 justify-content-sm-center">
              <h2 class="">
                <span class="text-md font-weight-bold mr-2">$</span
                ><span class="">{{ enterdamount }}</span>
              </h2>
            </div>
            <!-- {{ card.date.length }} -->
            <b-button
              v-if="is_new"
              :disabled="
                !card.card_holder_name ||
                !card.cvc ||
                !card.date ||
                !card.card_number
              "
              class="btn ff-btn1-pink text-center mt-4 border-0"
              @click="processpayment()"
            >
              <b-spinner small class="mr-1" v-show="isActiveSpinner">
              </b-spinner>
              Pay
            </b-button>
            <b-button
              v-else
              class="btn ff-btn1-pink text-center mt-4 border-0"
              @click="processpayment()"
            >
              <b-spinner small class="mr-1" v-show="isActiveSpinner">
              </b-spinner
              ><span>Pay</span>
            </b-button>
          </div>
        </div>
      </div>
    </div>
    <b-modal
      hide-footer
      hide-header
      centered
      body-class="px-5 pt-4 pb-4"
      content-class="ff-Sign-modal"
      ref="cardDelete"
    >
      Are you sure you want to delete this card?
      <div class="text-right mt-3">
        <b-button class="mt-3 ff-btn1-pink border-0 mr-2" @click="hideModal()"
          >No</b-button
        >
        <b-button
          class="mt-3 ff-btn1-pink border-0"
          @click="cardDelete(payment_pro_id)"
        >
          <b-spinner small class="mr-1" v-show="activeSpinner"> </b-spinner
          ><span>Yes</span></b-button
        >
      </div>
    </b-modal>
  </b-modal>
</template>

<script>
import { TheMask } from "vue-the-mask";
import creditCardType from "credit-card-type";
export default {
  computed: {
    cardType() {
      const cardType = creditCardType(this.card.card_number)[0];

      return cardType ? cardType.type : "";
    },
    cardBrandClass() {
      return this.getBrandClass(this.cardType);
    },
  },
  name: "cardInfo",
  components: { TheMask },
  props: ["enterdamount", "showError"],

  data() {
    return {
      payment_pro_id: null,
      isActiveSpinner: false,
      activeSpinner: false,
      card_id: null,
      card_option_select: false,
      card: {
        card_holder_name: "",
        cvc: "",
        date: null,
        amount: null,
        card_number: null,
      },
      is_new: true,
      selected_card_id: null,
      userCardInfo: {},
    };
  },
  mounted() {
    this.getCardInfo();
  },
  methods: {
    getBrandClass: function (brand) {
      console.log(brand);
      let icon = "";
      brand = brand || "unknown";
      let cardBrandToClass = {
        visa: "fa fa-cc-visa",
        mastercard: "fa fa-cc-mastercard",
        "american-express": "fa fa-cc-amex",
        discover: "fa fa-cc-discover",
        "diners-club": "fa fa-cc-diners-club",
        jcb: "fa fa-cc-jcb",
        unknown: "fa fa-credit-card",
      };
      if (cardBrandToClass[brand]) {
        icon = cardBrandToClass[brand];
      }
      return icon;
    },

    onInput(event) {
      const cvcNumber = event.target.value.replace(/\D/g, "");
      this.card.cvc = cvcNumber;
    },
    deleteCardRequest(id) {
      this.$refs["cardDelete"].show();
      this.payment_pro_id = id;
    },
    async cardDelete(id) {
      this.activeSpinner = true;
      var self = this;
      await this.$axios
        .$delete("/auth/deleteUserCardDetails/" + id)
        .then(function (response) {
          self.$bvToast.toast(response.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.$refs["cardDelete"].hide();
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      self.getCardInfo();
      self.activeSpinner = false;
    },
    hideModal() {
      this.$refs["cardDelete"].hide();
    },
    selectCard(index) {
      this.card.card_holder_name = "";
      this.card.card_number = "";
      this.card.date = "";
      this.card.cvc = "";
      this.card_option_select = true;
      this.is_new = false;
      this.selected_card_id =
        this.userCardInfo.user_card_details[index].customer_payment_profile_id;
    },
    async getCardInfo(id) {
      var self = this;
      await this.$axios
        .$get("/auth/getAuthUserUsedCards")
        .then(function (response) {
          self.userCardInfo = response;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    async processpayment(index) {
      this.isActiveSpinner = true;
      // this.userOfferAccept = 'reject';
      if (this.is_new == true) {
        var payload = {
          amount: this.enterdamount,
          card_holder_name: this.card.card_holder_name,
          cvc: this.card.cvc,
          month: this.card.date.substring(0, 2),
          year: 20 + this.card.date.substring(2, 4),
          card_number: this.card.card_number,
        };
      } else {
        var payload = {
          customer_payment_profile_id: this.selected_card_id,
          amount: this.enterdamount,
        };
      }

      var self = this;
      await this.$axios
        .post("/auth/chargeFromCreditCardAndCustomerProfile",payload)
        .then(function (response) {
          if (self.showError != true) {
            self.$bvToast.toast(response.data.message, {
              title: "Success",
              variant: "success",
              solid: true,
            });
          }
          self.$bvModal.hide("card-info");
          self.$emit("paymentSuccess");
          self.getCardInfo();
          self.card = {
            card_holder_name: "",
            cvc: null,
            date: null,
            card_number: null,
          };
        })
        .catch(function (error) {
          const object = error.response.data;
          self.$bvToast.toast(object.message, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      // self.$emit("getupdatedOffers", offerId);
      self.isActiveSpinner = false;
    },
  },
};
</script>

<style>
.error-text {
  color: red;
  font-weight: bold;
}

#card-info___BV_modal_body_ {
  padding: 0 !important;
  background: transparent !important;
}

.payment-date {
  width: 100px;
}

.payment-model .card {
  padding: 30px 25px 35px 30px;
  border-radius: 30px;
  box-shadow: rgb(0 0 0 / 25%) 0px 5px 14px 0px;
}

.payment-model .border-line {
  border-right: 1px solid #bdbdbd;
}

.payment-model .text-sm {
  font-size: 13px;
}

.payment-model .text-md {
  font-size: 18px;
}

.payment-model .image {
  width: 60px;
  height: 30px;
}

.payment-model ::placeholder {
  color: grey;
  opacity: 1;
}

.payment-model :-ms-input-placeholder {
  color: grey;
}

.payment-model ::-ms-input-placeholder {
  color: grey;
}

.payment-model input {
  padding: 2px 0px;
  border: none;
  border-bottom: 1px solid lightgrey;
  margin-bottom: 5px;
  margin-top: 2px;
  box-sizing: border-box;
  color: #000;
  font-size: 16px;
  letter-spacing: 1px;
  font-weight: 500;
}

.payment-model input:focus {
  -moz-box-shadow: none !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
  border-bottom: 1px solid var(--primary);
  outline-width: 0;
}

.payment-model .btn-red {
  background-color: var(--primary);
  color: #fff;
  padding: 8px 25px;
  border-radius: 50px;
  font-size: 18px;
  letter-spacing: 2px;
  border: 2px solid #fff;
}
.payment-model .card-icon {
  font-size: 24px;
}

.payment-model .btn-red:hover {
  box-shadow: 0 0 0 2px var(--primary);
}

.payment-model .btn-red:focus {
  box-shadow: 0 0 0 2px var(--primary) !important;
}

.payment-model
  .custom-checkbox
  .custom-control-input:checked
  ~ .custom-control-label::before {
  background-color: var(--primary);
}

.payment-card-model {
  background-color: transparent;
  border: 0;
}

@media screen and (max-width: 575px) {
  .payment-model .border-line {
    border-right: none;
    /* border-bottom: 1px solid #eeeeee; */
  }
  /* .payment-model .card {
    padding: 30px 25px 35px 30px;
    border-radius: 30px;
    box-shadow: rgb(0 0 0 / 25%) 0px 5px 14px 0px;
  } */
}
</style>
