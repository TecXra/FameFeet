<template>
  <b-modal
    hide-footer
    hide-header
    centered
    body-class="px-5 pt-4 pb-4"
    content-class="ff-Sign-modal"
    :id="'userReport' + offersIndex"
  >
    <div class="text-center mb-3 heading-pink">
      <h3>Report User</h3>
    </div>
    <form action="#!">
      <b-form-group
        id="input-group-2"
        label="Message:"
        label-class="form-label"
        label-for="input-description"
      >
      <div class="report_user">
        <b-form-textarea
          rows="4"
          id="input-description"
          v-model.trim="$v.message.$model"
          required
          placeholder="Write your messege here..."
          class="Famefeet-input-field scrollbar-none"
        ></b-form-textarea>
      </div>
        <div class="text-small" v-if="!$v.message.required">
          <small>Field is required</small>
        </div>
        <div class="" v-if="!$v.message.minLength">
          <small
            >Report must have at least
            {{ $v.message.$params.minLength.min }} letters.</small
          >
        </div>
      </b-form-group>
    </form>

    <div class="text-center">
      <button class="btn ff-search-clear px-3" @click="hideModal()">
        Close
      </button>

      <b-button
        class="ff-btn1-pink border-0"
        @click="reportUser(offersIndex, userid)"
        :disabled="!$v.message.minLength || !$v.message.required || isLoading">
        <b-spinner small class="mr-2" v-show="isLoading"></b-spinner> Send</b-button
      >
    </div>
  </b-modal>
</template>

<script>
import { required, minLength } from "vuelidate/lib/validators";
export default {
  name: "report",
  props: ["offersIndex", "userid"],

  data() {
    return {
      message: "",
      isLoading:false,
    };
  },
  validations: {
    message: { required, minLength: minLength(15) },
  },
  methods: {
    hideModal() {
      this.$bvModal.hide("userReport" + this.offersIndex);
    },
    async reportUser(index, userid) {
      this.isLoading = true
      if (userid != null) {
        var payload = {
          reported_user_id: userid,
          message: this.message,
        };
      } else {
        var payload = {
          reported_user_id: index,
          message: this.message,
        };
      }

      var self = this;
      await this.$axios
        .post("/auth/reportUser", payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.isLoading = false;
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
          self.isLoading = false;
        });
      self.hideModal();
      self.message = "";
    },
  },
};
</script>

<style lang="css" scoped>
.heading-pink {
  color: var(--primary);
}
.ff-search-clear {
  color: white;
  background-color: var(--secondary);
  padding: 10px 30px 10px 30px;
  font-size: 16px;
  font-weight: 500;
  box-shadow: rgb(28 27 27 / 45%) 0px 4px 29px -6px;
  border-radius: 100px;
}
.ff-search-clear:hover {
  cursor: pointer;
  background-color: transparent;
  outline: 2px solid var(--secondary);
  color: var(--secondary) !important;
}
.report_user{
  border-radius: 1.25rem;
  overflow: hidden;

}
</style>
