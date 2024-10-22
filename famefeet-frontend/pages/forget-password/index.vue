<template>
  <ForgotPassword></ForgotPassword>
</template>
<script>
import ForgotPassword from "@/components/auth/forgotPassword.vue";
export default {
  // the 'guest' value will  make global auth middleware protect come here when user is logged in.
  auth: "guest",
  middleware: "guest",
  name: "forget-password",
  layout: "auth",

  components: { ForgotPassword },
  data() {
    return {};
  },
  computed: {},
  mounted() {},
  methods: {},
};
</script>
