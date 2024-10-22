<template>
  <b-modal
    no-close-on-backdrop
    no-close-on-esc
    hide-footer
    hide-header
    centered
    size="lg"
    content-class="ff-Sign-modal"
    id="success-order"
  >
    <div class="container success-mod-screen">
      <div class="row d-flex cart align-items-center justify-content-center">
        <div class="col-md-12">
          <div class="">
            <div class="row">
              <div class="col-md-12 p-5">
                <div class="text-center order-details">
                  <div
                    class="d-flex justify-content-center mb-4 flex-column align-items-center"
                  >
                    <span class="check1"><i class="fa fa-check"></i></span>
                    <h3 class="font-weight-bold">Thank you for your order!</h3>
                    <small class="mt-2">
                      The order Confirmation email with details of your order
                      has been sent to your email address.</small
                    >
                    <!-- <a href="#"
										class="text-decoration-none invoice-link">View Invoice</a> -->
                  </div>
                  <div class="d-inline-block">
                    <div class="rounded-pill success-heading px-3 py-2">
                      YOUR ORDER IS PENDING
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 text-center">
                <hr />
                <button
                  @click="goToOrders()"
                  class="btn ff-btn1-pink border-0 px-3 py-2"
                >
                  Go to your Order
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </b-modal>
</template>

<script>
export default {
  //   computed: {
  //     sumCompletedOrders: function () {
  //       return function (arry) {
  //         var sum = arry.reduce((acc, item) => acc + parseInt(item.price), 0);
  //         return sum;
  //       };
  //     },
  //   },
  name: "success",

  data() {
    return {};
  },
  mounted() {},
  methods: {
    goToOrders() {
      this.$router.push("/fan/orders");
    },
  },
};
</script>

<style>
.success-mod-screen {
  background-color: #fff;
  font-family: "Poppins", sans-serif;
  font-weight: 300;
}
.success-heading {
  background-color: #f1f1ec;
  font-weight: 500;
}
.text-heading {
  font-size: 16px;
}

.success-heading i {
  color: var(--primary);
  font-size: 20px;
}
.check1 {
  display: flex;
  background-color: var(--primary);
  color: #fff;
  font-size: 17px;
  width: 60px;
  height: 60px;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  margin-bottom: 10px;
}
.check1 i {
  font-size: 30px;
}
.success-heading {
  background-color: #f1f1ec;
  font-weight: 700;
}
</style>
