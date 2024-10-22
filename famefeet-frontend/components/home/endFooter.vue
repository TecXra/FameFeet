<template>
  <div id="end-footer" class="text-center p-4">
    Copyright © {{ year }} |
    <a class="text-reset footer-link fw-bold" href="/">Famefeet.com</a>
  </div>
</template>

<script>
export default {
  name: "topFooter",
  data() {
    return {
      year: null,
    };
  },
  mounted() {
    this.year = new Date().getFullYear();
  },
};
</script>

<style lang="css" scoped>
#end-footer {
  background-color: var(--primary);
  color: white;
}
.footer-link:hover {
  color: var(--secondary) !important;
  cursor: pointer;
  /* text-decoration: none; */
}
</style>
