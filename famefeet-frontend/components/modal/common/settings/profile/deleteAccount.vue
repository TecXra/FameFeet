<template>
  <!-- Account Delete Modal -->
  <b-modal hide-footer centered header-class="ff-heading-modal2" size="md" content-class="ff-Sign-modal"
    id="deleteAccount-modal">
    <template #modal-title> Delete Account </template>
    <p>Deleting your account will remove all your data permanently.</p>
    <div class="text-right mb-3 mt-3 ff-paragraph4">
      <a @click="$bvModal.hide('deleteAccount-modal')" class="ff-blue-button text-uppercase famefeet-link-a">no</a>
      <a @click="deleteUserAccount()" class="ff-blue-button text-uppercase famefeet-link-a">yes</a>
      <!-- <a @click="$bvModal.hide('deleteAccount')" class="ff-btn1-pink text-uppercase">Dismiss</a> -->
    </div>
  </b-modal>
</template>

<script>
export default {
  methods: {
    async deleteUserAccount() {
      var self = this;
      await this.$axios
        .$delete("/remove/user")
        .then((response) => {
          self.$bvToast.toast(response.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          setTimeout(() => {
            this.logout()
      }, 1000);
          
        })
        .catch(function (error) {
          const object = error.response.data;
          for (const property in object) {
            self.$bvToast.toast(object[property][0], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
        });
      self.$bvModal.hide("deleteAccount-modal");
    },
    async logout() {
      await this.$auth.logout();
      localStorage.removeItem("cart_items");
      localStorage.removeItem("address");
      this.goToPage("/");
    },
  },
};
</script>
<style></style>
