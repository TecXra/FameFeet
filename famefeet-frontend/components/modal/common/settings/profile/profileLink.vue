<template>
  <div>
    <b-modal id="profile-link" centered header-class="border-0" hide-footer>
      <h3 class="text-center mb-3">Copy Profile Link</h3>
      <!-- {{ user.id }} -->
      <div class="text-center mb-5">
        <button
          class="mt-1 py-2 border-0 rounded-pill ff-btn-pink"
          @click="copyURL()"
        >
          <Span v-if="copied === false">Copy</Span>
          <span v-else class="">Copied!</span>
        </button>

        <!-- <button
          class="mt-1 py-2 border-0 rounded-pill ff-btn-pink"
          v-else
          @click="copyURL()"
        >
          <Span v-if="copied === false">Copy</Span>
          <span v-else class="">Copied!</span>
        </button> -->
      </div>
    </b-modal>
  </div>
</template>
<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  name: "profileLink",
  props: ["refferal"],

  data() {
    return {
      copied: false,
      baseUrl: null,
    };
  },
  mounted() {
    this.baseUrl = window.location.origin;
  },
  methods: {
    handleSuccess() {
      this.copied = true;
    },
    async copyURL() {
      var mylink = this.baseUrl + "/celebrity/" + this.user.username;
      try {
        await navigator.clipboard.writeText(mylink);
        this.copied = true;
      } catch ($e) {
        alert("Cannot copy");
      }
    },
  },
};
</script>

<style></style>
