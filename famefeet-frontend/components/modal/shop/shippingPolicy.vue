<template>
  <b-modal
    hide-footer
    hide-header
    centered
    id="shipping-policy"
    header-class="ff-heading-modal darken-3"
    size="lg"
    content-class="ff-Sign-modal"
  >
    <template #modal-title>Review</template>
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Fame Feet LLC Shipping Policy</h4>
      <div class="mt-4">
        <ol class="">
          <li>
            Fame Feet LLC allows shipments within the United States and its
            territories.
          </li>
          <li>
            All Fame Feet LLC orders are shipped using USPS First-Class Mail.
          </li>
          <li>This shipping method will typically take 1-5 business days.</li>
          <li>
            Please allow <b>24-48 hours</b> handling time between when an order
            is placed and when it gets shipped.
          </li>
          <li>We will not ship to P.O. boxes.</li>
        </ol>
      </div>
      <div class="text-center">
        <b-button
          class="mt-1 mb-3 ff-btn1-pink border-0 mr-2"
          @click="$bvModal.hide('shipping-policy')"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "shippingPolicy",
  props: ["orderId", "requestType"],

  data() {
    return {};
  },
};
</script>

<style></style>
