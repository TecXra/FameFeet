<template>
  <div>
    <b-modal
      hide-footer
      visible
      no-close-on-backdrop
      no-close-on-esc
      hide-header
      centered
      id="signup-model"
      header-class="ff-heading-modal darken-3"
      content-class="ff-Sign-modal"
    >
      <section>
        <h4 class="pt-2 pl-2">Choose an Account</h4>
        <hr />
        <div class="my-3 text-dark">
          <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-11">
              <div class="card border-0">
                <div class="card-body">
                  <div class="mb-3 text-center">
                    <p>View/Buy feet pictures, feet videos, worn socks</p>
                    <a
                      @click.prevent="goToPage('/signup/fan')"
                      class="text-decoration-none ff-btn1-pink text-uppercase"
                      >SignUp Fan/Buyer</a
                    >
                  </div>
                  <h4 class="line-devider">Or</h4>
                  <div class="text-center mb-3">
                    <p>Sell feet pictures, feet videos, worn socks</p>
                    <a
                      @click.prevent="goToPage('/signup/celebrity')"
                      class="text-decoration-none ff-btn1-pink text-uppercase"
                      >SignUp Celebrity</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </b-modal>
  </div>
</template>

<script>
import Signup from "@/components/modal/auth";
export default {
  name: "signup",
  layout: "auth",
  components: {
    Signup,
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {
    goToPage(page) {
      this.$router.push(page);
    },
  },
};
</script>
<style>
.line-devider {
  display: flex;
  flex-direction: row;
}

.line-devider:before,
.line-devider:after {
  content: "";
  flex: 1 1;
  border-bottom: 1px solid;
  margin: auto;
}

.line-devider:before {
  margin-right: 10px;
}

.line-devider:after {
  margin-left: 10px;
}
</style>
