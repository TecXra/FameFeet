<template>
  <b-modal
    hide-footer
    hide-header
    centered
    :id="'remove-item' + id"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <section style="border-radius: 12px">
      <!-- <h4 class="pt-3 pl-2">Error</h4> -->
      <div class="my-3 text-dark">
        <h5 class="font-weight-bold">Remove your previous items</h5>
        <!-- <P class=""
          >You still have products from another celebrity. Shall we start over
          with a fresh cart?</P
        > -->
        <P class=""
          >You already have product in your cart. Shall we start over with a
          fresh cart?</P
        >
      </div>
      <div class="text-center">
        <b-button
          class="mt-1 ff-btn1-pink border-0 py-1"
          @click="$bvModal.hide('remove-item' + id)"
          >No</b-button
        >
        <b-button class="mt-1 ff-blue-button py-1" @click="removeItems()"
          >Remove</b-button
        >
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "removeItem",
  props: ["id"],

  data() {
    return {};
  },
  methods: {
    removeItems() {
      this.$emit("addNewItems");
      this.$bvModal.hide("remove-item" + this.id);
    },
  },
};
</script>

<style>
/* .link-grey { color: #aaa; } .link-grey:hover { color: #00913b; } */
</style>
