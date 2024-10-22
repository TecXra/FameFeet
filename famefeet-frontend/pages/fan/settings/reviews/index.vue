<template>
  <div class="container-fluid">
    <MyReviews />
  </div>
</template>

<script>
import MyReviews from "~/components/fan/settings/reviews";
export default {
  layout: "fanSetting",
  name: "reviews",
  components: { MyReviews },

  data() {
    return {};
  },
};
</script>

<style lang="css" scoped></style>
