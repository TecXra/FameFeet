<template>
  <div class="app-body">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KASDHK83"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <main class="main">
      <div class="row w-100 m-0">
        <div class="col-lg-5 p-0">
          <IntroSection></IntroSection>
        </div>
        <div class="col-lg-7 p-0">
          <nuxt />
        </div>
      </div>
    </main>
  </div>
</template>
<script>
import IntroSection from "~/components/auth/sideIntro";
export default {
  // the 'guest' value will  make global auth middleware protect come here when user is logged in.
  auth: "guest",
  middleware: "guest",
  name: "auth",
  components: { IntroSection },
  data() {
    return {
      loading: true,
    };
  },

  computed: {},
};
</script>
