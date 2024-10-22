<template>
  <nav class="social-login-links mb-2">
    <a
      class="social-login-link rounded-pill"
      @click="signInWithGoogle('google')"
    >
      <img src="~/assets/images/svg/google.svg" alt="Google logo" />
      <span>Continue with Google</span>
    </a>

    <!-- <small class="text-muted font-weight-bold">For Buyers Only!</small> -->
  </nav>
</template>

<script>
export default {
  methods: {
    signInWithGoogle(provider) {
      // Call the Laravel API route to initiate the Google Sign-In flow
      let url = `${process.env.BACKEND_HOST}/api/login/${provider}`;
      // // Redirect the user to the Google Sign-In page
      window.location.href = url;
    },
  },
};
</script>
