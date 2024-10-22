<template>
  <div>
    <div class="container-fluid">
      <div class="d-flex justify-content-center align-items-center mt-3">
        <div style="width: 30rem" class="card Form-card">
          <ResetPassword />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ResetPassword from "~/components/fan/settings/resetPassword";
export default {
  layout: "fanSetting",
  name: "password",
  components: { ResetPassword },

  data() {
    return {};
  },
};
</script>

<style></style>
