<template>
  <b-modal
    hide-footer
    hide-header
    centered
    responsive
    size="md"
    :id="'shippingInfo' + orderid"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Shipping Information</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <div class="w-100">
                    <div></div>
                    <b-table :items="items" stacked> </b-table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center pb-3">
        <b-button
          class="mt-1 mb-3 ff-btn1-pink border-0"
          @click="$bvModal.hide('shippingInfo' + orderid)"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "shippingInfo",
  props: ["orderid", "orderdetails"],

  data() {
    return {
      items: [
        {
          Name: this.orderdetails.name,
          // Mobile: this.orderdetails.mobile_number,
          Address1: this.orderdetails.address_line_one,
          Address2: this.orderdetails.address_line_two,
          City: this.orderdetails.city,
          State: this.orderdetails.state,
          ZipCode: this.orderdetails.zipcode,
          Country: this.orderdetails.country,
        },
      ],
    };
  },
  // mounted(){
  // 	if (orderinfo != null) {
  // 	console.log(this.orderinfo.media)

  // 	}
  // },
  methods: {},
};
</script>

<style></style>
