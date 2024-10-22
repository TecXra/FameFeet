<template>
  <!-- Account Delete Modal -->
  <b-modal
    hide-footer
    @close="goToPage('/signin')"
    centered
    header-class="ff-heading-modal2"
    size="md"
    content-class="ff-Sign-modal"
    id="accountdeactive"
    no-close-on-esc
    no-close-on-backdrop
  >
    <template #modal-title> Alert </template>
    <p>
      Your account has been deactivated. If you have any questions or concerns,
      please contact our support team at
      <a class="" href="mailto:hello@famefeet.com">hello@famefeet.com</a>
      Thank you for using FameFeet.
    </p>
    <div class="text-center mb-3 mt-3 ff-paragraph4">
      <a
        @click="goToPage('/signin')"
        class="ff-blue-button famefeet-link-a px-4"
        >Got it</a
      >
      <!-- <a @click="$bvModal.hide('deleteAccount')" class="ff-btn1-pink text-uppercase">Dismiss</a> -->
    </div>
  </b-modal>
</template>

<script>
export default {
  methods: {
    goToPage(page) {
      this.$bvModal.hide("accountdeactive");
      this.$router.push(page);
    },
  },
};
</script>
<style></style>
