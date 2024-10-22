<template>
  <div>
    <b-modal id="refferal" centered header-class="border-0" hide-footer>
      <h3 class="text-center mb-3">Copy Refferal Code</h3>
      <div class="text-center mb-5">
        <button
          class="mt-1 py-2 border-0 rounded-pill ff-btn-pink"
          @click="copyURL(refferal)"
        >
          <Span v-if="copied === false">Copy</Span>
          <span v-else class="">Copied!</span>
        </button>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "refferal",
  props: ["refferal"],

  data() {
    return {
      copied: false,
    };
  },
  methods: {
    handleSuccess() {
      this.copied = true;
    },
    async copyURL(mytext) {
      try {
        await navigator.clipboard.writeText(mytext);
        this.copied = true;
      } catch ($e) {
        alert("Cannot copy");
      }
    },
  },
};
</script>

<style lang="css" scoped></style>
