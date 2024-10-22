<template>
  <div class="container-fluid">
    <div class="mt-3">
      <b-tabs
        content-class=""
        align="center"
        nav-class="tabs-nav-link"
        active-nav-item-class="ff-tabs-link"
      >
        <!-- Orders -->
        <b-tab active title-link-class="ff-tablink-pro">
          <template #title>
            <div
              class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
            >
              <i class="mr-0 mr-md-1 fi fi-rr-badge-percent"></i>
              <span class="d-md-inline-block">My Offers</span>
            </div>
          </template>
          <Loader v-if="ishow"></Loader>
          <div v-else>
            <div v-if="allOffers.length == 0" class="text-center">
              <p class="p-3 ff-paragraph4 h3">
                Once you send a request they will be shown here for you to track
                them.
              </p>
            </div>
            <div class="row mx-0 mt-3">
              <div
                class="col-xl-3 col-lg-4 col-12 col-sm-6 col-md-6 px-1 mb-3"
                v-for="(item, index) in allOffers"
                :key="index"
              >
                <CustomOrder
                  :rejectedOffers="item"
                  @getoffersfan="getoffersfan"
                />
              </div>
            </div>
          </div>
        </b-tab>
        <!-- Celebrity Offers -->
        <b-tab
          title-link-class="ff-tablink-pro"
          @click="getCelebOfferContent()"
        >
          <template #title>
            <div
              class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
            >
              <i class="mr-0 mr-md-1 fi fi-rr-badge-percent"></i>
              <span class="d-md-inline-block">Celebrities Offers</span>
            </div>
          </template>
          <Loader v-if="ishow"></Loader>
          <div v-else>
            <div v-if="!celebrityOfferContent" class="text-center">
              <p class="p-3 ff-paragraph4 h3">
                You don't have any offers right now.
              </p>
            </div>
            <div class="row">
              <div
                class="col-xl-3 col-lg-4 col-12 col-sm-6 col-md-6 mt-2"
                v-for="(content, index) in celebrityOfferContent"
                :key="index"
              >
                <OfferVideos
                  :item="content"
                  v-if="content.content_type == '6'"
                ></OfferVideos>
                <OfferImages
                  :item="content"
                  v-if="content.content_type == '5'"
                ></OfferImages>
              </div>
            </div>
          </div>
        </b-tab>
        <!-- Purchased Content -->
        <b-tab
          @click="getOffersOfFanForReview()"
          title-link-class="ff-tablink-pro"
        >
          <template #title>
            <div
              class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
            >
              <i class="mr-0 mr-md-1 fi fi-rr-star"></i>
              <span class="d-md-inline-block">Offer Reviews</span>
            </div>
          </template>
          <Loader v-if="ishow"></Loader>
          <div v-else>
            <div v-if="offersReviewOrderItems.length==0" class="text-center">
              <p class="p-3 ff-paragraph4 h3">
                Once your offer request is accepted, you can leave a review!
              </p>
            </div>
            <div class="pb-3" v-if="offersReviewOrderItems.length">
              <h2 class="ml-5 my-3">History</h2>
            </div>
            <div class="container">
              <div
                class="card p-2 mb-3"
                v-for="(item, index) in offersReviewOrderItems"
                :key="index"
              >
                <div class="row">
                  <!-- {{ item }} -->
                  <div class="col-12">
                    <div class="px-3">
                      <div class="d-flex justify-content-between offerReview">
                        <vue-star-rating
                          :border-width="4"
                          :star-size="20"
                          :rating="item.rating"
                          :read-only="true"
                          border-color="#B28137"
                          :show-rating="false"
                          :rounded-corners="true"
                          :star-points="[
                            23, 2, 14, 17, 0, 19, 10, 34, 7, 50, 23, 43, 38, 50,
                            36, 34, 46, 19, 31, 17,
                          ]"
                        >
                        </vue-star-rating>
                        <span> {{ item.created_at | formatDate }}</span>
                      </div>
                      <p class="mb-0 ml-1 mt-3">
                        Sold by
                        <a
                          class="ff-alink3 font-weight-bolder"
                          @click="goToProfile(item.sold_by,item.account_status)"
                          >{{ item.sold_by }}</a
                        >
                      </p>
                      <p class="mt-2 mb-1 ml-1">{{ item.comment }}</p>
                    </div>
                  </div>
                  <!-- <div class="col-6">
                  <div class="d-flex flex-column pl-3 pt-3">
                    <p class="mb-0 famefeet-heading-text">
                      {{ item.title }}
                    </p>

                    <p class="mb-1">{{ item.description }}</p>
                    <p>
                      Sold by <a href="">{{ item.sold_by }}</a>
                    </p>
                  </div>
                </div> -->
                  <!-- <div class="col-6">
                  <p class="pt-3">{{ item.comment }}</p>
                  <vue-star-rating
                    :border-width="4"
                    :star-size="20"
                    :rating="item.rating"
                    :read-only="true"
                    border-color="#B28137"
                    :show-rating="false"
                    :rounded-corners="true"
                    :star-points="[
                      23, 2, 14, 17, 0, 19, 10, 34, 7, 50, 23, 43, 38, 50, 36,
                      34, 46, 19, 31, 17,
                    ]"
                  >
                  </vue-star-rating>
                </div> -->
                </div>
              </div>
            </div>
          </div>
        </b-tab>
      </b-tabs>
    </div>
  </div>
</template>

<script>
import OfferVideos from "@/components/fan/offers/videos";
import OfferImages from "@/components/fan/offers/pictures";
import CustomOrder from "@/components/fan/orders/customOrder";
import Loader from "@/components/common/loader";
export default {
  name: "offers",
  layout: "fan",

  components: {
    Loader,
    OfferVideos,
    OfferImages,
    CustomOrder,
  },

  data() {
    return {
      rating: 4,
      allOffers: [],
      ishow: true,
      postsOfCelebrity: [],
      postsOfCelebrityImages: [],
      purchasePostAndOfferContent: [],
      offersReviewOrderItems: [],
      celebrityOfferContent: [],
      celebrityOfferVideos: [],
      celebrityOfferImages: [],
    };
  },
  mounted() {
    this.getOffersOfFan();
    // this.getPurchasedContent();
    // this.getOffersOfFanForReview();
    this.$nuxt.$on("getcontent", (e) => {
      this.getCelebOfferContent();
    });
  },
  methods: {
    getoffersfan() {
      // alert();
      this.getOffersOfFan();
    },
    async getOffersOfFanForReview() {
      this.ishow = true;
      var self = this;
      await this.$axios
        .$get("/auth/getAuthUserOffersReview")
        .then(function (response) {
          self.ishow = false;
          // console.log(response);
          self.offersReviewOrderItems = response.sort((a,b)=> new Date(b.created_at) - new Date(a.created_at));
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      self.ishow = false;
    },
    // show(index) {
    // 	for (var i = 0; i < this.ffContent.length; i++) {
    // 		if (i == index) {
    // 			this.$viewerApi({
    // 				images: this.ffContent[i].images,
    // 			})
    // 		}
    // 	}
    // },
    // write review
    reviewCelebItems(id, offerid) {
      if (id != null) {
        this.$root.$emit("bv::show::modal", "review-write" + id + 1);
      } else {
        this.$root.$emit("bv::show::modal", "review-write" + offerid + 2);
      }
      // alert(item_id)
    },
    // Get All offers
    async getOffersOfFan() {
      this.ishow = true;
      // this.isBusy = true;
      var self = this;
      await this.$axios
        .$get("/auth/getOffersOfFan")
        .then(function (response) {
          self.ishow = false;
          self.allOffers = response.sort((a,b)=> new Date(b.created_at) - new Date(a.created_at));
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    async getCelebOfferContent() {
      this.ishow = true;
      this.celebrityOfferContent = [];
      var self = this;
      await this.$axios
        .$get("/auth/getSharedPosts")
        .then(function (response) {
          response.celebrity_send_offers.map((a) => {
            self.celebrityOfferContent.push(a);
          });
          response.share_posts.map((a) => {
            self.celebrityOfferContent.push(a);
          });
          // self.celebrityOfferContent = response;
          let tempobject1 = self.celebrityOfferContent.filter((items) => {
            if (items.content_type == "6") {
              return items;
            }
          });
          let tempobject2 = self.celebrityOfferContent.filter((items) => {
            if (items.content_type == "5") {
              return items;
            }
          });
          self.celebrityOfferVideos = tempobject1.sort((a,b)=> new Date(b.created_at) - new Date(a.created_at));
          self.celebrityOfferImages = tempobject2.sort((a,b)=> new Date(b.created_at) - new Date(a.created_at));
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      self.ishow = false;
    },
    goToProfile(username,account_status) {
    
      if(account_status == 4){
          this.$bvToast.toast("This account has been deleted!", {
         title: "Warning",
         variant: "warning",
         solid: true,
        });
        }else{
          this.$router.push({
            path: "/celebrity/" + username,
      });
        }
    },
  },
};
</script>

<style>
.famefeet-heading-text {
  color: var(--primary);
  font-size: 19px;
  font-weight: 500;
}

.famefeet-pragraph-text {
  color: grey;
}
@media (max-width: 370px) {
  .offerReview{
    display: block !important;

  }
  .vue-star-rating{
    margin-bottom: 3px;
  }

}
</style>
