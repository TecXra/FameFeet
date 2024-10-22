<template>
  <b-modal
    hide-footer
    centered
    header-class="ff-heading-modal2 darken-3"
    content-class="ff-Sign-modal"
    :id="'send-tip' + componentKey"
  >
    <template #modal-title> Add Amount </template>
    <div class="px-5 py-3">
      <b-form @submit.stop.prevent>
        <!-- <label for="ContentType">Amount:</label> -->
        <div class="form-group">
          <!-- <the-mask
            placeholder="Enter Amount"
            v-model="coins"
            class="form-control Famefeet-input-field"
            type="text"
            :mask="['###']"
          /> -->
          <InputPrice v-model="coins"  :isRequired="true" class="mt-2 mb-2"></InputPrice>
        </div>
      </b-form>
    </div>
    <div class="text-center">
      <b-button
        class="ff-blue-button"
        :disabled="!coins || coins < 1 || is_loading"
        @click="sendTip(celeb_id)">
        <b-spinner small class="" v-show="is_loading"></b-spinner>
        Send
        </b-button
      >
    </div>
  </b-modal>
</template>

<script>
import { TheMask } from "vue-the-mask";
import InputPrice from "@/components/common/inputPrice";
export default {
  name: "sendTipCelebrity",
  props: ["celeb_id", "componentKey"],
  components: { TheMask, InputPrice },

  data() {
    return {
      coins: 0.0,
      is_loading: false
    };
  },
  methods: {
    async sendTip(id) {
      this.is_loading = true;
      var payload = {
        coins: parseFloat(this.coins),
        receiver_id: id,
      };
      var self = this;
      await this.$axios
        .post("/auth/sendTip", payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.is_loading = false;
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
          self.is_loading = false;
        });
      self.coins = 0.0;
      self.$bvModal.hide("send-tip" + self.componentKey);
    },
  },
};
</script>

<style>
.input-prepend {
  border-radius: 1.25rem;
  padding: 0.3rem 0.75rem;
  background-color: transparent;
}
</style>
