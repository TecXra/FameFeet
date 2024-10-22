<template>
  <b-modal
    hide-footer
    hide-header
    centered
    body-class="px-5 pt-4 pb-4"
    content-class="ff-Sign-modal"
    :id="'userDelete' + offersIndex"
  >
    Are you sure you want to delete this user?
    <div class="text-right mt-3">
      <b-button
        class="mt-3 ff-btn1-pink border-0 mr-2"
        @click="hideModal(offersIndex)"
        >No</b-button
      >
      <b-button class="mt-3 ff-btn1-pink border-0">Yes</b-button>
    </div>
  </b-modal>
</template>
<script>
export default {
  name: "delete",
  props: ["offersIndex"],

  data() {
    return {};
  },
  methods: {
    hideModal(index) {
      this.$bvModal.hide("userDelete" + index);
    },
  },
};
</script>

<style lang="css" scoped></style>
