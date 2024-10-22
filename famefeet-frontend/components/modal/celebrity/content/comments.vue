<template>
  <b-modal
    hide-footer
    hide-header
    centered
    :id="'postid' + postid"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <template #modal-title>comments</template>
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Comments</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="text-center mt-3" v-if="!Imagescomments.length">
              There are no comments yet.
            </div>
            <div class="card mb-3 card-container" v-for="(item, index) in Imagescomments" :key="index">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <b-avatar :src="item.user.avatarURL" v-if="item.user != null"></b-avatar>
                  <div class="w-100">
                    <div
                      class="d-flex justify-content-between align-items-center username_time_container"
                    >
                      <h6 class="ml-2 fw-bold mb-0" style="color: var(--primary)" v-if="item.user != null">
                        {{ item.user.username }}
                      </h6>
                      <p class="mb-0 small time_container">
                        {{ item.created_at | moment("from", true) }} ago
                      </p>
                    </div>
                    <div class="ml-2">
                      <!-- {{item}} -->
                      <span class="text-dark mt-2">{{ item.comment }}</span>
                    </div>
                    <!-- 										
									<div class="d-flex justify-content-between align-items-center">
										<p class="small mb-0 mt-2" style="color: #aaa;">
											<a href="#!" class="link-grey">Remove</a> •
											<a href="#!" class="link-grey">Reply</a> •
											<a href="#!" class="link-grey">Translate</a>
										</p>
										<div class="d-flex flex-row">
											<i class="fas fa-star text-warning mr-2"></i>
											<i class="far fa-check-circle" style="color: #aaa;"></i>
										</div>
									</div> -->
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
          @click="$bvModal.hide('postid' + postid)"
          >Close</b-button
        >
      </div>
    </section>
  </b-modal>
</template>
<script>
export default {
  name: "comments",
  props: ["postid", "Imagescomments"],

  data() {
    return {};
  },
  mounted() {
    this.Imagescomments.sort((a,b)=> new Date(b.created_at) - new Date(a.created_at))
  },
};
</script>

<style>
.card-container{
  border-radius: 40px;
}
@media (max-width: 450px) {
  .card-container {
    border-radius: 10px !important;
  }
}

@media (max-width: 360px) {
  .username_time_container {
    display: block !important;
  }
  .time_container{
    text-align: end;
    margin-top: 3px;
  }
}



</style>
