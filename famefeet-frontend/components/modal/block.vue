<template>
  <div>
    <b-modal
      hide-footer
      hide-header
      centered
      body-class="px-5 pt-4 pb-4"
      content-class="ff-Sign-modal"
      :id="'userblock' + offersIndex"
    >
    Are you sure you want to {{ blockStatus ? ' unblock' : 'block' }} this user?
      <div class="text-right d-flex mt-3 float-right">
        <b-button
          class="mt-3 ff-btn1-pink border-0 mr-2"
          @click="hideModal(offersIndex)"
          >No</b-button
        >
        <b-button
          class="mt-3 ff-btn1-pink border-0"
          @click="blockUser(offersIndex, user.user_type)"
          >Yes</b-button
        >
      </div>
    </b-modal>
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },

  name: "block",
  props: ["offersIndex","blockStatus"],

  data() {
    return {};
  },
  methods: {
    hideModal(index) {
      this.$bvModal.hide("userblock" + index);
    },
    async blockUser(index, usertype) {
      var payload = {
        banned_user_id: index,
      };
      var self = this;
      await this.$axios
        .post("/auth/blockOrUnblockUser", payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
        })
        .catch(function (error) {
          const object = error.response.data;
          for (const property in object) {
            self.$bvToast.toast(object[property], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
        });
      self.$bvModal.hide("userblock" + index);
      setTimeout(async () => {
      if (usertype == 1) {
        await self.$router.push("/celebrity/fans");
      } else {
        await self.$router.push("/fan/celebrities");
      }
    }, 6000);
    },
  },
};
</script>

<style lang="css" scoped></style>
