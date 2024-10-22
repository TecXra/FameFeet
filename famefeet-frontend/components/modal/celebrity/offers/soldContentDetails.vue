<template>
  <b-modal
    hide-footer
    hide-header
    centered
    responsive
    :id="'soldcontentdetail' + orderid"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <section class="pt-3 pb-3" style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pl-2">Offer Details</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <div class="w-100">
                    <div>
                      <div
                        class="position-relative order-details-content mb-4"
                        v-if="orderinfo.content_type == 5"
                      >
                        <Lightbox
                          :cells="1"
                          css=""
                          :items="getPostImages(orderinfo.media)"
                        >
                        </Lightbox>
                      </div>

                      <div class="row">
                        <div class="col-12">
                          <div v-if="orderinfo.content_type == 6">
                            <div
                              v-for="(item, index) in orderinfo.media"
                              :key="index"
                            >
                              <a class="d-block text-decoration-none">
                                <video
                                  width="100%"
                                  height="250"
                                  controls
                                  preload="metadata"
                                >
                                  <source :src="item.AppURL + '#t=2'" type="video/mp4">
                                  <source :src="item.AppURL" type="video/mp4" />
                                </video>
                              </a>
                            </div>
                          </div>
                          <div class="">
                            <span class="content-title">{{
                              orderinfo.title
                            }}</span>
                            <p class="content-discription">
                              {{ orderinfo.description }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center">
        <b-button
          class="ff-btn1-pink border-0"
          @click="$bvModal.hide('soldcontentdetail' + orderid)"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>

<script>
import Lightbox from "~/components/fan/feeds/lightbox";
export default {
  computed: {
    getPostImages: function () {
      var vm = this;
      return function (arry) {
        let postImages = [];
        for (let i = 0; i < arry.length; i++) {
          postImages.push(arry[i].AppURL);
        }
        return postImages;
      };
    },
  },

  name: "soldContentDetails",
  props: ["orderid", "orderinfo"],
  components: { Lightbox },

  data() {
    return {};
  },
  methods: {},
};
</script>

<style>
.order-details-content .lb .lb-grid {
  height: 22vh;
}
</style>
