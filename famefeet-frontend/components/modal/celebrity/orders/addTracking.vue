<template>
  <b-modal hide-footer hide-header centered :id="'addtracking' + orderid" header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal">
    <!-- <template #modal-title>comments</template> -->
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Add Tracking Number</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <b-form-group id="input-group-title" class="mb-0 mt-3" label-class="form-label" label-for="input-title">
              <b-form-input type="text" v-model="trackingNumber" id="input-title" class="Famefeet-input-field"
                placeholder="Tracking number">
              </b-form-input>
            </b-form-group>
          </div>
        </div>
      </div>
      <div class="text-center">
        <b-button class="mt-3 py-2 ff-btn1-pink border-0" @click="$bvModal.hide('addtracking' + orderid)">Close</b-button>
        <b-button class="mt-3 py-2 ff-btn1-pink border-0" @click="addTrackingnumber(orderid)">Save</b-button>
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "addTracking",
  props: ["orderid"],

  data() {
    return {
      trackingNumber: null,
    };
  },
  methods: {
    async addTrackingnumber(id) {
      var payload = {
        traking_number: this.trackingNumber,
      };
      var self = this;
      await this.$axios
        .$post("/auth/addTrakingNumber/" + id, payload)
        .then(function (response) {
          self.$bvToast.toast(response.message, {
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
      self.$emit("showtracking");
      self.$bvModal.hide("addtracking" + self.orderid);
      self.trackingNumber = null;
    },
  },
};
</script>

<style></style>
