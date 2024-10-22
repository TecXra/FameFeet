<template>
  <b-modal
    hide-footer
    hide-header
    centered
    id="refund"
    header-class="ff-heading-modal darken-3"
    size="lg"
    content-class="ff-Sign-modal"
  >
    <template #modal-title>Review</template>
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Fame Feet LLC Refund Policy</h4>
      <div class="mt-4">
        <ol class="">
          <li>All Fame Feet LLC worn sock sales are final.</li>
          <li>The buyer recognizes they shall not be entitled to return.</li>
          <li>
            The buyer will not be able to return any used product that they
            purchased or get their money back.
          </li>
          <li>We do not offer any money-back guarantees.</li>
<!--          <li>-->
<!--            Fame Feet LLC will only refund the buyer If they did not receive-->
<!--            their purchase, or what they ordered.-->
<!--          </li>-->
        </ol>
      </div>
      <div class="text-center">
        <b-button
          class="mt-1 mb-3 ff-btn1-pink border-0 mr-2"
          @click="$bvModal.hide('refund')"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>
<script>
export default {
  name: "refundPolicy",
  props: ["orderId", "requestType"],

  data() {
    return {};
  },
};
</script>

<style></style>
