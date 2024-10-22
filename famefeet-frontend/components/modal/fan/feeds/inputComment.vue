<template>
  <b-form>
    <b-form-group id="input-group-1">
      <div class="d-flex">
        <b-avatar :src="user.avatarURL" class="mr-2"></b-avatar>
        <b-form-input
          id="input-comment"
          class="rounded-pill"
          v-model="fanComment"
          type="text"
          placeholder="Add Comment..."
        ></b-form-input>
        <button
          class="btn ff-likebtn"
          :disabled="fanComment.length <= 0 || isActiveSpinner == true"
          @click="postComment(postId, postIndex)"
        >
        <b-spinner v-if="isActiveSpinner"
                small
                class="mr-1"
                v-show="isActiveSpinner"
              ></b-spinner>
          <i v-else class="fas fa fa-paper-plane"></i>
        </button>
      </div>
    </b-form-group>
  </b-form>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  name: "inputComment",
  props: ["postIndex", "postId"],

  data() {
    return {
      fanComment: "",
      isActiveSpinner: false,
    };
  },
  methods: {
    async postComment(id, index) {
      this.isActiveSpinner = true;
      // console.log(index)
      event.preventDefault();
      var post_id = id;
      var post_index = index;
      var temp_comment = {
        index: post_index,
        comment: this.fanComment,
        id: 55,
        parent_id: null,
        post_id: post_id,
        user_id: this.$auth.user.fan.id,
        user: {
          avatar: this.$auth.user.avatar,
          avatarURL: this.$auth.user.avatarURL,
          created_at: new Date(),
          id: 2,
          user_type: this.$auth.user.id,
          user_type_name: "Fan",
          username: this.$auth.user.username,
        },
      };
      this.$emit("tempComment", temp_comment);
      var temp_object = {
        comment: this.fanComment,
      };
      var self = this;
      this.fanComment;
      await self.$axios
        .post("/auth/comment/" + post_id, temp_object)
        .then(function (response) {})
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      self.fanComment = "";
      self.isActiveSpinner = false;
    },
  },
};
</script>

<style lang="css" scoped></style>
