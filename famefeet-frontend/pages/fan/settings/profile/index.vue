<template>
  <div class="container-fluid px-0">
    <ProfileUpdate />
  </div>
</template>

<script>
import ProfileUpdate from "~/components/fan/settings/profile";
export default {
  layout: "fanSetting",
  name: "profile",
  components: { ProfileUpdate },

  data() {
    return {};
  },
};
</script>

<style></style>
