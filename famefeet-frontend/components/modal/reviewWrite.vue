<template>
  <b-modal
    hide-footer
    hide-header
    centered
    :id="'review-write' + orderId + requestType"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <template #modal-title>Review</template>
    <section class="p-3" style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Write Review</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <label>Rate:
              <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
            </label>
            <div class="d-flex justify-content-center pb-3">
              <vue-star-rating
                :border-width="4"
                :star-size="40"
                v-model="rating"
                border-color="#B28137"
                :show-rating="false"
                :rounded-corners="true"
                :star-points="[
                  23, 2, 14, 17, 0, 19, 10, 34, 7, 50, 23, 43, 38, 50, 36, 34,
                  46, 19, 31, 17,
                ]"
              >
              </vue-star-rating>
            </div>
          </div>
          <div class="col-md-12 col-lg-10 col-xl-11">
            <b-form>
              <b-form-group
                id="review-item"
                label="Review:"
                label-class="form-label"
                label-for="input-bio"
              >
                <b-form-textarea
                  rows="4"
                  v-model.trim="$v.comment.$model"
                  id="review-item"
                  class="Famefeet-input-field bg-white scrollbar-none"
                >
                </b-form-textarea>
                <div class="text-small" v-if="!$v.comment.required">
                  <small>Rating field is required.</small>
                </div>
                <!-- <div class="" v-if="!$v.comment.minLength">
                  <small
                    >Review must have at least
                    {{ $v.comment.$params.minLength.min }} letters.</small
                  >
                </div> -->
              </b-form-group>
            </b-form>
          </div>
        </div>
      </div>
      <div class="text-center">
        <b-button
          class="mt-3 ff-btn1-pink border-0 mr-2"
          @click="closeReviewModal('review-write' + orderId + requestType)"
          >Close
        </b-button>
        <b-button
          :disabled="rating == null || is_loading"
          v-if="requestType == 3"
          class="mt-3 ff-btn1-pink border-0"
          @click="placeReviewOffer(orderId)">
          <b-spinner small class="" v-show="is_loading"></b-spinner>
          Submit
        </b-button>
        <b-button
          :disabled="rating == null || is_loading"
          v-else
          class="mt-3 ff-btn1-pink border-0"
          @click="placeReview(orderId)">
          <b-spinner small class="" v-show="is_loading"></b-spinner>
          Submit
          </b-button
        >
      </div>
    </section>
  </b-modal>
</template>
<script>
import { required, minLength } from "vuelidate/lib/validators";
export default {
  name: "reviewWrite",
  props: ["orderId", "requestType"],

  data() {
    return {
      rating: null,
      comment: "",
      is_loading: false
    };
  },
  validations: {
    comment: { required, minLength: minLength(10) },
  },
  methods: {
    async placeReview(orderid) {
      this.is_loading = true;
      if (this.requestType == 1) {
        var payload = {
          rating: this.rating,
          comment: this.comment,
          order_item_id: orderid,
        };
      } else {
        var payload = {
          rating: this.rating,
          comment: this.comment,
          offer_id: orderid,
        };
      }
      var self = this;
      await this.$axios
        .post("/auth/createReview", payload)
        .then(function (response) {
          self.$bvToast.toast("Review sent successfully", {
            title: "Success",
            variant: "success",
            solid: true,
          });
          setTimeout(() => {
            self.is_loading = false;
            self.closeReviewModal("review-write" + orderid + self.requestType);
            self.$emit("getoffers");
          }, 1000);
        })
        .catch(function (error) {
          const object = error.response.data;
          // for (const property in object) {
            self.$bvToast.toast(object.message, {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          // }
           setTimeout(() => {
            self.is_loading = false;
            self.closeReviewModal("review-write" + orderid + self.requestType);
            self.$emit("getoffers");
          }, 1000);
        });
        // setTimeout(function () {
          // This code will run after the delay
        // }, 6000);

    },
    async placeReviewOffer(orderid) {
      var payload = {
        rating: this.rating,
        message: this.comment,
        rated_user_id: orderid,
      };
      var self = this;
      await this.$axios
        .post("/auth/fan/rating", payload)
        .then(function (response) {
          self.$bvToast.toast("Review sent successfully", {
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
        self.closeReviewModal("review-write" + orderid + self.requestType); 

      // self.$bvModal.hide("review-write" + orderid + self.requestType);
    },
    closeReviewModal(modal_id){
      this.rating = null;
      this.comment = "";
      this.$bvModal.hide(modal_id);
      // $bvModal.hide('review-write' + orderId + requestType)
    }
  },
};
</script>

<style>
/* .link-grey { color: #aaa; } .link-grey:hover { color: #00913b; } */
</style>
