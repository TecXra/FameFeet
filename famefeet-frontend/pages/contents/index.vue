<template>
  <div class="mt-3">
    <BuyContent @resposeapi="isLoader = false"></BuyContent>
  </div>
</template>
<script>
import BuyContent from "@/components/content/buy";

export default {
  layout: "home",
  name: "contents",
  middleware: "public",
  components: { BuyContent },

  data() {
    return {};
  },

  methods: {},
};
</script>

<style lang="css" scoped></style>
