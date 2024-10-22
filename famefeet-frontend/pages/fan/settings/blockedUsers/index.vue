<template>
  <div>
    <div class="container my-3">
      <div class="d-flex justify-content-center align-items-center">
        <div style="" class="Form-card w-100">
          <div class="card-header py-4 ff-variant-blue border-0">
            <h3 class="text-light mb-0">Banned Users</h3>
          </div>
          <div class="card pb-3 pt-3 px-3">
            <!-- <h5>No Users found</h5> -->
            <div class="row">
              <div
                class="col-12 p-3 d-flex justify-content-center"
                v-if="!blockedUsers.length"
              >
                <h6 class="">No Record Found</h6>
              </div>
              <div
                class="col-12 col-sm-4 col-lg-3 col-xl-2"
                v-for="(user, index) in blockedUsers"
                :key="index"
              >
                <div class="card p-3 h-100">
                  <!-- <div><button class="float-right btn px-0 py-0"><i class="fi fi-rr-cross-circle"></i></button></div> -->
                  <div class="d-flex justify-content-center align-items-center">
                    <b-avatar
                      :src="user.avatarURL"
                      size="5rem"
                      class=""
                    ></b-avatar>
                  </div>
                  <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mb-0 mt-2 font-weight-bold w-100 text-center">
                      {{ user.username }}
                    </h6>
                  </div>
                  <div class="text-center mt-2">
                    <button
                      class="btn ff-variant-blue text-light rounded-pill btn-sm"
                      @click="unblockedUser(user.id)"
                    >
                      Unbanned
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "blockedUsers",
  layout: "fanSetting",

  data() {
    return {
      blockedUsers: [],
    };
  },
  mounted() {
    this.getblockedusers();
  },
  methods: {
    async getblockedusers() {
      var self = this;
      await this.$axios
        .$get("/auth/getBlockUser")
        .then(function (response) {
          self.blockedUsers = response["Block From"];
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    async unblockedUser(id) {
      var payload = {
        banned_user_id: id,
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
            self.$bvToast.toast(object[property][0], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
        });
      self.getblockedusers();
    },
  },
};
</script>

<style lang="css" scoped></style>
