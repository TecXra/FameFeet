<template>
  <b-modal
    hide-footer
    hide-header
    centered
    id="sub-policy"
    header-class="ff-heading-modal darken-3"
    size="lg"
    content-class="ff-Sign-modal"
  >
    <template #modal-title>Review</template>
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Fame Feet LLC Subscription Policy</h4>
      <div class="mt-4">
        <ol class="">
          <li style="margin-bottom: 20px;">
            When buying a monthly subscription from a seller, it allows the
            buyer to access all their locked content on Fame Feet LLC. It also
            allows the subscriber the ability to message the seller.
            Subscriptions will automatically be charged monthly. If the buyer
            opts out of a subscription, they will be charged for the rest of the
            monthly term.
          </li>
          <li>Non-subscribers can purchase any locked content.</li>
        </ol>
      </div>
      <div class="text-center">
        <b-button
          class="mt-1 mb-3 ff-btn1-pink border-0 mr-2"
          @click="$bvModal.hide('sub-policy')"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "subscriptionPolicy",
  props: ["orderId", "requestType"],

  data() {
    return {};
  },
};
</script>

<style></style>
