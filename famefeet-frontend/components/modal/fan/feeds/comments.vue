<template>
  <div class="comments-section" v-show="postid === showComment">
    <b-row
      class=""
      v-for="comment in comments.slice().reverse()"
      :key="comment.id"
    >
      <!-- {{comment.id}} -->
      <b-col>
        <div class="d-flex justify-content-start align-items-center pl-3">
          
          <b-avatar class="mr-2" size="md" v-if="comment.user != null" :src="comment.user.avatarURL"></b-avatar>
          <div class="">
            <p class="mb-0 ff-feed-user-comment" v-if="comment.user != null">{{ comment.user.username }}</p>
            <small class="ff-feed-time-comment" v-if="comment.user != null">
              <span>{{ comment.user.created_at | formatDate }}</span>
            </small>
          </div>
        </div>
        <div class="col-lg-12 ml-3">
          <p class="px-5">
            <small>{{ comment.comment }}</small>
          </p>
        </div>
      </b-col>
    </b-row>
  </div>
</template>
<script>
export default {
  name: "comments",
  props: ["comments", "showComment", "postid"],

  data() {
    return {};
  },
  methods: {},
};
</script>

<style>
.comments-section {
  height: 160px !important;
  overflow-y: auto;
  overflow-x: hidden;
}
</style>
