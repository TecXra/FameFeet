<template>
  <b-modal
    hide-footer
    centered
    header-class="ff-heading-modal"
    size="md"
    content-class="ff-Sign-modal"
    id="information"
  >
    <template #modal-title>
      <i class="fi fi-rr-info" style="font-size: 2.2rem; line-height: 0%"></i>
      <!-- <font-awesome-icon class="text-light" style="font-size: 2.2rem;" icon="info-circle" /> -->
    </template>
    <p>{{ textInfo }}</p>
    <div class="text-center mb-3 mt-3 ff-paragraph4">
      <a
        @click="$bvModal.hide('information')"
        class="ff-btn1-pink text-uppercase"
        >Close</a
      >
    </div>
  </b-modal>
</template>
<script>
export default {
  name: "delete",
  props: ["textInfo"],

  data() {
    return {};
  },
  methods: {
    // hideModal(index){
    // 	this.$bvModal.hide('userDelete' + index)
    // }
  },
};
</script>

<style lang="css" scoped></style>
