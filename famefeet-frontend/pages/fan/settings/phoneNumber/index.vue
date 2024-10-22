<template>
  <div class="container-fluid px-0 my-3">
    <div class="d-flex justify-content-center align-items-center">
      <div style="width: 30rem">
        <PhoneNumber />
      </div>
    </div>
  </div>
</template>

<script>
import PhoneNumber from "~/components/fan/settings/phoneNumber";
export default {
  layout: "fanSetting",
  name: "phoneNumber",
  components: { PhoneNumber },

  data() {
    return {};
  },
};
</script>

<style lang="css" scoped></style>
