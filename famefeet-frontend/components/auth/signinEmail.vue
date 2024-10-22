<template>
  <div class="form-section pt-0">
    <div class="login-wrapper">
      <h2 class="login-title font-weight-bold">Sign in</h2>
      <SocialLogin></SocialLogin>
      <!-- <nav class="social-login-links mb-4">
        <a class="social-login-link rounded-pill">
          <img src="~/assets/images/svg/google.svg" alt="google logo" />
          <span>Continue with Google</span>
        </a>
        <br />
        <small class="text-muted font-weight-bold">For Buyers Only!</small>
      </nav> -->
      <div class="text-center">
        <small class="text-muted font-weight-bold">For Buyers Only!</small>
      </div>

      <h6 class="social-login-title mb-md-5 mb-1">OR</h6>

      <form action="#!" v-on:keyup.enter="logInRequest()" @submit.stop.prevent>
        <div class="form-group">
          <label for="email" class="sr-only">email</label>
          <input v-model="email" type="email" name="email" id="email" class="form-control rounded-pill"
            placeholder="mail@website.com" required />
        </div>
        <div class="form-group mb-3">
          <label for="password" class="sr-only">Password</label>
          <input v-model="password" type="password" name="password" id="password" class="form-control rounded-pill"
            placeholder="Password" required />
        </div>
        <!-- <div class="">
          <input
            type="checkbox"          
            v-model="rememberPassword"
          />
          <label class="custom-control-label" for="customCheck1"
            >Remember Me</label
          >
        </div> -->
        <b-form-checkbox id="checkbox-1" v-model="rememberPassword" size="sm" class="mt-1 mb-2" name="checkbox-1"
          value="true">
          Remember Me

        </b-form-checkbox>

        <div class="d-flex justify-content-between align-items-center mb-md-5 mb-1">
          <button id="login" class="btn login-btn rounded-pill" type="button" :disabled="spinner || !email || !password" @click="logInRequest()">
            <b-spinner small class="mr-2" v-show="spinner"></b-spinner>
            <span>Login</span>
          </button>
          <a href @click.prevent="goToPage('/forget-password')" class="ff-alink2">Forgot Password?</a>
        </div>
      </form>
      <p class="login-wrapper-signup-text">
        Need an account?<a class="ml-1 ff-alink2" @click="$bvModal.show('signup-model')">Signup here</a>
      </p>
    </div>
    <Signup></Signup>
  </div>
</template>
<script>
import Signup from "@/components/modal/auth";
import SocialLogin from "@/components/auth/socialLogin";

export default {
  name: "signinEmail",
  props: ["spinner"],
  components: { Signup, SocialLogin },
  data() {
    return {
      email: "",
      password: "",
      rememberPassword: false,
      isActiveSpinner: false,
    };
  },
  mounted() {
    // Check local storage for saved email and password
    const savedEmail = localStorage.getItem("email");
    const savedPassword = localStorage.getItem("password");

    if (savedEmail && savedPassword) {
      this.email = savedEmail;
      this.password = savedPassword;
      this.rememberPassword = true;
    }
  },
  methods: {
    goToPage(page) {
      this.$router.push(page);
    },
    logInRequest() {
      if (this.rememberPassword) {
        localStorage.setItem("email", this.email);
        localStorage.setItem("password", this.password);
      } else {
        localStorage.removeItem("email");
        localStorage.removeItem("password");
      }
      this.$emit("login", this.email, this.password);
    },
  },
};
</script>

<style lang="css" scoped></style>
