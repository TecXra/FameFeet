<template>
  <div class="ff-Footer-area mt-5">
    <div>
      <footer class="text-center text-lg-left ff-footer-content">
        <section class="pt-3">
          <div class="container text-center text-md-left mt-5">
            <div class="row mt-3">
              <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                <h6 class="footer-heading">FameFeet</h6>
                <hr
                  class="footer-hr accent-2 mb-3 mt-0 d-inline-block mx-auto"
                />
                <p>
                  Fame Feet allows you to buy/sell feet pictures, feet videos,
                  worn socks from famous people. Experience the fun from our
                  verified users in a secure environment.
                </p>
              </div>

              <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="footer-heading">Company Links</h6>
                <hr
                  class="footer-hr accent-2 mb-3 mt-0 d-inline-block mx-auto"
                />
                <!-- <p>
									<a href="/#how-it-works" class="text-reset footer-link">How it works</a>
								</p> -->
                <p>
                  <a
                    @click="goToPage('/contact')"
                    class="text-reset footer-link"
                    >Contact</a
                  >
                </p>
                <p>
                  <a @click="goToPage('/faq')" class="text-reset footer-link"
                    >FAQS</a
                  >
                </p>
              </div>

              <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="footer-heading">Useful links</h6>
                <hr
                  class="footer-hr accent-2 mb-3 mt-0 d-inline-block mx-auto"
                />
                <!-- <p>
									<a href="/plans" class="text-reset footer-link">Pricing</a>
								</p> -->
                <p>
                  <a @click="shipping()" class="text-reset footer-link"
                    >Shipping Policy</a
                  >
                </p>
                <p>
                  <a @click="refund()" class="text-reset footer-link"
                    >Refund Policy</a
                  >
                </p>
                <p>
                  <a @click="subscription()" class="text-reset footer-link"
                    >Subscription Policy</a
                  >
                </p>
                <p>
                  <a @click="goToPage('/terms')" class="text-reset footer-link"
                    >Terms & Conditions
                  </a>
                </p>
                <p>
                  <a
                    @click="goToPage('/privacy')"
                    class="text-reset footer-link"
                    >Privacy Policy</a
                  >
                </p>
              </div>

              <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="footer-heading">Contact</h6>
                <hr
                  class="footer-hr accent-2 mb-3 mt-0 d-inline-block mx-auto"
                />
                <div
                  class="d-flex justify-content-center justify-content-md-start"
                >
                  <p class="d-flex justify-content-center">
                    <b-icon
                      class="ff-icon rounded-circle p-1 mr-2"
                      icon="house-fill"
                    ></b-icon>
                    136 Kingsland Road
                    <br />
                    #1075
                    <br />
                    Clifton, New Jersey 07014
                  </p>
                </div>
                <div
                  class="d-flex justify-content-center justify-content-md-start"
                >
                  <p class="d-flex justify-content-center">
                    <b-icon
                      class="ff-icon rounded-circle p-1 mr-2"
                      icon="envelope-fill"
                    ></b-icon>
                    <!-- <a href="">Send email</a> -->
                    <a
                      class="text-reset footer-link"
                      href="mailto:support@famefeet.com"
                      >support@famefeet.com</a
                    >
                  </p>
                </div>
                <div
                  class="d-flex justify-content-center justify-content-md-start"
                >
                  <p class="d-flex justify-content-center">
                    <b-icon
                      class="ff-icon rounded-circle p-1 mr-2"
                      icon="phone-fill"
                    ></b-icon>
                    <a
                      class="text-reset footer-link"
                      href="tel:+1-(646)-493-0473"
                      >+1-(646)-493-0473</a
                    >
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <EndFooter style="background-color: rgba(0, 0, 0, 0.05)"></EndFooter>
        <RefundPolicy></RefundPolicy>
        <ShippingPolicy></ShippingPolicy>
        <SubscriptionPolicy></SubscriptionPolicy>
      </footer>
    </div>
  </div>
</template>

<script>
import RefundPolicy from "@/components/modal/home/refundPolicy";
import SubscriptionPolicy from "@/components/modal/home/subscriptionPolicy";
import ShippingPolicy from "@/components/modal/shop/shippingPolicy";
import EndFooter from "@/components/home/endFooter.vue";
export default {
  name: "topFooter",
  components: { EndFooter, SubscriptionPolicy, ShippingPolicy, RefundPolicy },
  data() {
    return {
      year: null,
    };
  },
  mounted() {
    this.year = new Date().getFullYear();
  },
  methods: {
    refund() {
      this.$bvModal.show("refund");
    },
    shipping() {
      this.$bvModal.show("shipping-policy");
    },
    subscription() {
      this.$bvModal.show("sub-policy");
    },
    goToPage(page) {
      this.$router.push(page);
    },
  },
};
</script>

<style lang="css" scoped>
.ff-Footer-area {
  position: relative;
  background-color: var(--primary);
}

.ff-footer-content {
  font-family: "Poppins", sans-serif;
  color: white;
}

.footer-heading {
  font-weight: 700;
  font-size: 18px;
  text-transform: uppercase;
}

.ff-icon {
  background-color: #fff;
  color: var(--secondary);
  width: 24px !important;
  height: 24px !important;
}

.footer-link:hover {
  color: var(--secondary) !important;
  cursor: pointer;
  /* text-decoration: none; */
}

.footer-hr {
  width: 60px;
  background-color: var(--secondary);
  height: 2px;
}
</style>
