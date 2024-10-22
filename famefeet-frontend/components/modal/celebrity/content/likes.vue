<template>
  <b-modal
    hide-footer
    hide-header
    centered
    :id="'likes_postid' + postid"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <template #modal-title> Likes </template>
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Likes</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="text-center mt-3" v-if="!Imageslikes.length">
              There are no likes yet.
            </div>
            <div class="card mb-3 rounded-pill" v-for="(item, index) in Imageslikes" :key="index">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <b-avatar :src="item.user.avatarURL" v-if="item.user != null">
                    <template #badge>
                      <b-icon icon="heart-fill" class="d-flex justify-content-center align-self-center" style="margin-top: 1px"></b-icon>
                    </template>
                  </b-avatar>
                  <div class="w-100">
                    <div class="d-flex justify-content-between">
                      <h6 class="ml-2 fw-bold mb-0" style="color: var(--primary)" v-if="item.user != null">
                        {{ item.user.username }}
                      </h6>
                      <p class="mb-0 small">
                        {{ item.created_at | moment("from", true) }} ago
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="pb-3 text-center">
        <b-button
          class="mt-1 mb-3 ff-btn1-pink border-0"
          @click="$bvModal.hide('likes_postid' + postid)"
          >Close</b-button
        >
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "likes",
  props: ["postid", "Imageslikes"],

  data() {
    return {};
  },
  mounted() {
    this.Imageslikes.sort((a,b)=> new Date(b.created_at) - new Date(a.created_at))
  },
};
</script>

<style lang="css" scoped></style>