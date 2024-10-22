<template>
  <b-modal hide-footer hide-header centered size="lg" body-class="p-0" content-class="ff-Sign-modal" id="withdraw">
    <div class="px-5 py-4">
      <div class="mb-3 heading-pink">
        <div class="withdraw-message-fi mr-2 d-inline-block mb-2">
          <i class="fi fi-rr-wallet"></i>
        </div>
        <h3>Send a withdrawal request</h3>
        <p class="text-muted">
          Please enter withdrawal amount and click the submit request button.
        </p>
      </div>
      <div class="row m-0">
        <div class="col-md-6">
          <div>
            <p class="text-muted mb-2">Current Balance</p>
            <p class="font-weight-bold mb-0">
              {{ availableAmount | toCurrency }}
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <div>
            <p class="text-muted mb-2">Selected Payment Method</p>
            <p class="font-weight-bold mb-0">Bank</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row mx-0 pb-4 draw-row">
      <div class="col-12 px-0">
        <div class="px-5 py-4">
          <div class="form-group">
            <label for="">Amount</label>
            <the-mask placeholder="Enter Amount" v-model="amount" class="form-control Famefeet-input-field mb-2"
              type="text" :mask="['###']" />
            <span class="">Minimum withdraw amount is $30</span>
          </div>
          <div class="pb-4">
            <button class="btn ff-search-clear px-3 float-left" @click="hideModal()">
              Cancel
            </button>
            <b-button class="ff-btn1-pink border-0 px-3 float-right" :disabled="isDisabled || isLoadSpinner"
              @click="withdrawaAmount(selectedAccountId)">
              <b-spinner small class="mr-1" v-show="isLoadSpinner"></b-spinner>
              Submit
            </b-button>
          </div>
        </div>
      </div>
    </div>
  </b-modal>
</template>

<script>
import { TheMask } from "vue-the-mask";

export default {
  name: "withdraw",
  components: { TheMask },
  props: ["availableAmount", "selectedAccountId"],

  data() {
    return {
      amount: null,
      isLoadSpinner :false,
    };
  },

  computed: {
    isDisabled() {
      return this.amount === null || this.amount === "" || this.amount < 30;
    },
  },
  methods: {
    hideModal() {
      this.$bvModal.hide("withdraw");
    },

    async withdrawaAmount(id) {

      if (id === null) {
        this.$bvToast.toast("Please enter your bank account details first.", {
          title: "Warning",
          variant: "warning",
          solid: true,
        });
        return
      }
      this.isLoadSpinner = true;
      var payload = {
        amount: parseInt(this.amount),
      };
      var self = this;
      await this.$axios
        .post("/auth/amountWithdarwRequest/" + id, payload)
        .then(function (response) {
          self.$emit("getUpdatedAmount");
          self.amount = "";
          self.$bvModal.hide("withdraw");
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
        })
        .catch(function (error) {
          self.$bvToast.toast(error.response.data.message, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
        self.isLoadSpinner = false;
    },
  },
};
</script>

<style lang="css" scoped>
.withdraw-message-fi {
  border-radius: 100%;
  /* border: 1px solid #000; */
  background-color: rgba(0, 0, 0, 0.5);
}

.withdraw-message-fi .fi {
  border-radius: 100%;
  /* padding: 6px 12px 0px 12px; */
  font-size: 1.5rem;
  font-weight: 700;
  padding: 13px;
  color: aliceblue;
}

.withdraw-message-fi .fi::before {
  line-height: 2;
}

.draw-row {
  background-color: #e3e3e4;
  border-radius: 0px 0px 23px 23px;
}
</style>
