<template>
  <b-modal
    hide-footer
    hide-header
    centered
    responsive
    size="lg"
    :id="'socksorderdetail' + orderid"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <section class="pt-3 pb-3" style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pl-2">Order Details</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <div class="w-100">
                    <div></div>
                    <b-table-simple responsive>
                      <b-thead>
                        <b-tr>
                          <b-th>Picture</b-th>

                          <b-th sticky-column>Title</b-th>
                          <b-th>Discription</b-th>
                          <!-- <b-th
                            v-if="user.user_type != 1 && status == 'complete'"
                            >Review</b-th
                          > -->
                        </b-tr>
                      </b-thead>
                      <b-tbody>
                        <b-tr v-for="(item, index) in orderinfo" :key="index">
                          <b-td>
                            <div
                              @click="show(index, item.shop.media, item.id)"
                              class="bg-image"
                              :style="{
                                background: `url(${item.shop.media[0].AppURL})`,
                              }"
                            ></div>

                            <!-- <div
                              class="position-relative celebrity-Store-item mb-4 w-100"
                            >
                              <lightbox
                                :cells="1"
                                css=""
                                :items="getPostImages(item.shop.media)"
                              >
                              </lightbox>
                            </div> -->
                          </b-td>
                          <!-- {{ item }} -->
                          <b-td sticky-column>{{ item.item_name }}</b-td>
                          <b-td>{{ item.item_description }}</b-td>
                          <!-- {{ item }} -->
                          <!-- <b-td v-if="user.user_type == 2">
                            <button
                              class="btn ff-btn1-pink rounded-pill px-4 py-1"
                              @click="reviewCelebItems(item.id)"
                              v-if="item.status == 0"
                              disabled
                            >
                              Reviewed
                            </button>
                            <button
                              class="btn ff-btn1-pink rounded-pill px-4 py-1"
                              @click="reviewCelebItems(item.id)"
                              v-if="status == 'complete' && item.status == 1"
                            >
                              Review
                            </button>
                            <ReviewWrite
                              :orderId="item.id"
                              :requestType="1"
                              @getoffers="getoffers"
                            ></ReviewWrite
                          ></b-td> -->
                        </b-tr>
                      </b-tbody>
                    </b-table-simple>
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
          @click="$bvModal.hide('socksorderdetail' + orderid)"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>

<script>
import ReviewWrite from "@/components/modal/reviewWrite";
import { mapState } from "vuex";
import "viewerjs/dist/viewer.css";
import VueViewer from "v-viewer";

import Vue from "vue";
Vue.use(VueViewer);
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
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
  components: { ReviewWrite },
  name: "socksOrderDetails",
  props: ["orderid", "orderinfo", "status"],

  data() {
    return {
      fields: ["#", "title", "discription"],
    };
  },
  // mounted(){
  // 	if (orderinfo != null) {
  // 	console.log(this.orderinfo.media)

  // 	}
  // },
  methods: {
    getoffers() {
      this.$emit("orderReview");
      // alert("first");
    },
    reviewCelebItems(id) {
      this.$root.$emit("bv::show::modal", "review-write" + id + 1);
    },
    show(index, img) {
      for (var i = 0; i < this.orderinfo.length; i++) {
        if (i == index) {
          this.$viewerApi({
            images: this.getPostImages(img),
          });
        }
      }
    },
  },
};
</script>

<style></style>
