<template>
  <b-modal
    hide-footer
    centered
    id="login"
    header-class="darken-3 justify-content-end border-0 none p-0"
    content-class="ff-Sign-modal"
  >
    <template #modal-header="{ close }">
      <!-- Emulate built in modal header close button action -->
      <div class="">
        <b-button
          class="float-right mt-1"
          size="lg"
          variant="none"
          @click="close()"
        >
          <i class="fi fi-rr-cross-circle text-info"></i>
        </b-button>
      </div>
    </template>

    <section>
      <div class="mb-3 text-dark">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="card border-0">
              <div class="card-body">
                <div class="login-logo">
                  <img
                    src="~/assets/images/svg/secure_login.svg"
                    alt="Secure login"
                  />
                </div>
                <div class="login-model-conf">
                  <p class="">Please signin or create an account to continue.</p>
                </div>

                <div class="text-center mb-3">
                  <div>
                  <a
                    @click.prevent="goToPage('/signin')"
                    class="w-100 d-block text-decoration-none ff-btn1-pink mr-2"
                    >SignIn</a
                  >

                </div>
                <div class="mt-4">  
                <a
                    @click.prevent="goToPage('/signup')"
                    class="w-100 d-block text-decoration-none ff-btn1-pink"
                    >Create new account</a
                  >
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </b-modal>
</template>
<script>
export default {
  name: "login",

  data() {
    return {};
  },
  methods: {
    goToPage(page) {
      this.$router.push(page);
    },
  },
};
</script>

<style lang="css" scoped>
.login-model-conf {
  font-size: 24px;
  text-align: center;
  font-weight: 500;
  padding: 2rem 0rem;
}
.login-logo {
  display: flex;
  justify-content: center;
}
.login-logo img {
  width: 170px;
}
</style>
