<template>
  <b-modal
    hide-footer
    centered
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
    :id="'subscription' + offersIndex"
  >
    <template #modal-title> Seller Subscription Plan </template>
    <div class="p-5">
      <b-card align="">
        <!-- {{ subscription }} -->
        <ul class="my-5 pl-0">
          <li>
            <i class="fi fi-rr-unlock mr-2"></i>Unlocked all
            <span class="text-info">{{ celebname }}</span>
            content
          </li>
          <li>
            <i class="fi fi-rr-photo-video mr-2"></i>Request custom pictures and
            videos
          </li>
          <li>
            <i class="fi fi-rr-comment-alt mr-2"></i>Send unlimited messages to
            celebrity
          </li>
          <li>
            <i class="fi fi-rr-shopping-cart mr-2"></i>Access to the celebrities
            Socks
          </li>
        </ul>

        <div class="row mx-3 mx-md-5" >
          <div
            class="col-12 ff-plans-card text-center px-5 pt-2"
            :class="{ selectedplan: selected }"
          >
            <input
              type="radio"
              name="basic-plan"
              @change="selectPlan()"
              value="basic"
              id="ff1"
            />
            <label class="checkbox-alias text-center" for="ff1" style="cursor: pointer;">
              <p class="mb-0 ff-paragraph4 text-white">
                ${{ subscription.coins }}/mo
              </p>
              <p class="mb-0 ff-paragraph4 text-white">Billed Monthly</p>
              <span class="" v-if="selected"
                ><i class="fi fi-rr-badge-check text-success"></i
              ></span>
            </label>
          </div>
        </div>
      </b-card>
      <!-- <b-form-checkbox id="checkbox-1" v-model="confirmSubscriptionPlan" size="sm" class="mt-1 mb-2" name="checkbox-1"
          value="true">
            Confirm subscription plan
        </b-form-checkbox> -->
      Your subscription is automatic per month unless you cancel it. See our
      Subscription Policy.
    </div>
    <div class="text-center">
      <b-button
        class="mt-3 ff-btn1-pink border-0"
        @click="getSubscription(subscription.id)"
      >
                    <b-spinner
                      small
                      class="mr-2"
                      v-show="isLoading"
                    ></b-spinner>Purchase</b-button
      >
    </div>
  </b-modal>
</template>

<script>
export default {
  name: "subscriptions",
  props: ["offersIndex", "subscription", "celebname"],

  data() {
    return {
      selected: true,
      isLoading: false,
      confirmSubscriptionPlan:false,
    };
  },
  methods: {
    selectPlan() {
      this.selected = true;
    },
    async getSubscription(id) {
      this.isLoading = true
      event.preventDefault();
      self = this;
      await this.$axios
        .post("/auth/buySubscription/" + id)
        .then(function (response) {
          // console.log(response);
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
            self.isLoading = false;
          }
        });
      self.$emit("followevent");
      self.$bvModal.hide("subscription" + self.offersIndex);
    },
  },
};
</script>

<style>
ul li {
  text-decoration: none;
  list-style: none;
}

.ff-plans-card {
  background: var(--primary);
  box-shadow: rgb(28 27 27 / 45%) 0px 4px 29px -6px;
  border-radius: 18px;
  cursor: pointer;
}

.ff-plans-card:hover {
  background-color: #fff;
  outline: 2px solid var(--primary) !important;
  color: var(--primary);
  transition: all 0.2s ease;
}

.selectedplan {
  background: #fff !important;
  outline: 2px solid var(--primary) !important;
}

.selectedplan p {
  color: var(--primary) !important;
}

.ff-plans-card:hover p {
  color: var(--primary) !important;
}

.ff-plans-card input[type="radio"] {
  display: none;
}
</style>
