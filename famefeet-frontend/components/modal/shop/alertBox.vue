<template>
  <b-modal
    hide-footer
    hide-header
    centered
    :id="'alertbox' + id"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <section style="border-radius: 12px">
      <!-- <h4 class="pt-3 pl-2">Error</h4> -->
      <div class="my-3 text-dark">
        <h5 class="font-weight-bold">Unable to add item</h5>
        <P class="">Sorry, we do not have enough of that item available.</P>
      </div>
      <div class="text-center">
        <b-button
          class="ff-btn1-pink border-0 py-2 px-3"
          @click="$bvModal.hide('alertbox' + id)"
          >OK</b-button
        >
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "alertBox",
  props: ["id"],

  data() {
    return {};
  },
};
</script>

<style>
/* .link-grey { color: #aaa; } .link-grey:hover { color: #00913b; } */
</style>
