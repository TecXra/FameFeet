<template>
  <!-- <div class="container">
    <button @click="fanLogin">Fan Login</button>
    <button @click="celebrityLogin">Celebrity Login</button>
  </div> -->
  <SigninEmail @login="login" :spinner="isActiveSpinner"></SigninEmail>
</template>

<script>
import SigninEmail from "@/components/auth/signinEmail.vue";
export default {
  name: "signin",
  layout: "auth",
  components: {
    SigninEmail,
  },
  data() {
    return {
      isActiveSpinner: false,
    };
  },
  methods: {
    // fanLogin() {
    //   this.login("fan@famefeet.com", "secret12");
    // },
    // celebrityLogin() {
    //   this.login("celebrity@famefeet.com", "secret12");
    // },
    async login(email, password) {
      this.isActiveSpinner = true;
      self = this;
      try {
        await this.$auth.loginWith("local", {
          data: {
            email: email,
            password: password,
          },
        });
        self.$router.push("/");
      } catch (e) {
        const object = e.response.data;
        for (const property in object) {
          self.$bvToast.toast(object[property][0], {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        }
      }
      self.isActiveSpinner = false;
    },
  },
};
</script>
