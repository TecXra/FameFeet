<template>
  <div class="container-fluid mt-3 px-0">
    <!-- <Loader v-show="isLoadershow"></Loader> -->
    <div class="px-2">
      <Search @searchQuery="searchQuery" @getaAllData="getaAllData" />
    </div>
    <!-- v-show="!isLoadershow" -->

    <div class="">
      <div class="mt-3 px-2">
        <b-tabs
          content-class=""
          align="center"
          nav-class="position-relative tabs-nav-link"
          active-nav-item-class="ff-tabs-link"
        >
          <b-tab
            active
            title-link-class="ff-tablink-pro"
            @click="loadAllFeedsData(page, perPage, '')"
          >
            <template #title>
              <div
                class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
              >
                <i class="mr-0 mr-md-1 fi fi-rr-search-alt"></i>
                <span class="d-md-inline-block">Explore</span>
              </div>
            </template>
            <Loader v-show="isLoading"></Loader>
            <ExploreFeed
              :allCelebPosts="allCelebrityPosts"
              @getpost="getpost"
              :searchtext="searchQue"
              :feedtype="'all'"
            />
            <div v-if="isAPILoaderShow" class="d-flex justify-content-center mb-3">
              <b-spinner  label="Spinning"></b-spinner>
            </div>
            <div
              class="row d-flex justify-content-center"
              v-if="!allCelebrityPosts.length && !isLoading"
            >
              <div class="col-lg-6 col-md-8">
                <p class="p-3 ff-paragraph4 h3 text-center">
                  No feeds available.
                </p>
              </div>
            </div>
            <div
              class="row d-flex justify-content-center"
              v-else-if="explore_feeds_end"
            >
              <!-- <div class="col-lg-6 col-md-8">
                <EndFeed></EndFeed>
              </div> -->
              <p class="p-3 ff-paragraph4 h3 text-center">
                  No More Content To Show
                </p>
            </div>
          </b-tab>

          <b-tab
            title-link-class="ff-tablink-pro"
            @click="loadSubscribedFeedsData(subPage, perPage, '')"
          >
            <template #title>
              <div
                class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
              >
                <i class="mr-0 mr-md-1 fi fi-rr-users-alt"></i>
                <span class="d-md-inline-block">Subscribed</span>
              </div>
            </template>
            <p
              class="p-3 ff-paragraph4 h3 text-center"
              v-if="!subscribedCelebrityPosts.length && !isLoadingSubscribed"
            >
              You are not subscribed to any Celebrity. Once you subscribe to
              Celebrities, their most recent content will appear here.
            </p>
            <Loader v-show="isLoadingSubscribed"></Loader>

            <SubscriptionFeed
              :allCelebPosts="subscribedCelebrityPosts"
              :searchtext="searchQue"
              @getpost="getpost"
              :feedtype="'subscription'"
            ></SubscriptionFeed>
          </b-tab>

          <b-tab
            title-link-class="ff-tablink-pro"
            @click="loadFollowingFeedsData(followPage, '', '')"
          >
            <template #title>
              <div
                class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
              >
                <i class="mr-0 mr-md-1 fi fi-rr-following"></i>
                <span class="d-md-inline-block">Following</span>
              </div>
            </template>
            <div>
              <p
                class="p-3 ff-paragraph4 h3 text-center"
                v-if="!followCelebrityPosts.length && !isLoadingFollow"
              >
                You are not following to any Celebrity. Once you following to
                Celebrities, their most recent content will appear here.
              </p>
              <Loader v-show="isLoadingFollow"></Loader>

              <FollowingFeed
                :allCelebPosts="followCelebrityPosts"
                :searchtext="searchQue"
                @getpost="getpost"
                :feedtype="'follow'"
              >
              </FollowingFeed>
            </div>
          </b-tab>
        </b-tabs>
      </div>
    </div>
    <div ref="scrollTrigger"></div>
  </div>
</template>
<script>
import Search from "@/components/common/search";
import Loader from "@/components/fan/feeds/loader";
import EndFeed from "~/components/fan/feeds/endFeeds";
import ExploreFeed from "~/components/fan/feeds/feedPost";
import SubscriptionFeed from "~/components/fan/feeds/feedPost";
import FollowingFeed from "~/components/fan/feeds/feedPost";
export default {
  layout: "fan",
  name: "feeds",
  components: {
    EndFeed,
    Loader,
    Search,
    ExploreFeed,
    SubscriptionFeed,
    FollowingFeed,
  },
  props: ["searchQue"],

  data() {
    return {
      isLoading: false,
      isLoadingFollow: false,
      isLoadingSubscribed: false,
      tab: 1,
      page: 1,
      followPage: 1,
      subPage: 1,
      perPage: 10,
      isLoadershow: true,
      allCelebrityPosts: [],
      followCelebrityPosts: [],
      subscribedCelebrityPosts: [],
      explore_feeds_end: false,
      has_new_posts:false,
      isAPILoaderShow:false,
    };
  },

  created() {
    this.loadAllFeedsData(this.page, this.perPage, "");
    this.tab = 1;
  },

  methods: {
    getpost() {
      if (this.tab == 1) {
        // this.isLoadershow = true;
        this.allCelebrityPosts = [];
        this.loadAllFeedsData(1, "", "");
      }
      if (this.tab == 2) {
        // this.isLoadershow = true;
        this.subscribedCelebrityPosts = [];
        this.loadSubscribedFeedsData(1, "", "");
        // alert();
      }
      if (this.tab == 3) {
        // this.isLoadershow = true;
        this.followCelebrityPosts = [];
        this.loadFollowingFeedsData(1, "", "");
      }
    },

    async loadAllFeedsData(page, perPage, text) {
      this.isLoading = true;
      this.tab = 1;
      this.followPage = 1;
      this.subPage = 1;
      this.followCelebrityPosts = [];
      this.subscribedCelebrityPosts = [];
      var self = this;
      await this.$axios
        .$get(
          `/auth/getFeedsList?page=${page}&perPage=${perPage}&search=${text}`
        )
        .then(function (response) {
          const data = response.data;
          self.isAPILoaderShow = false;
          self.allCelebrityPosts.push(...data);
          if(data.length > 0){
            self.has_new_posts = true 
          }else{
            self.has_new_posts = false 

          }
          self.page++;
          const explore_feeds_data = response;
          console.log(explore_feeds_data.to);
          if (explore_feeds_data.to == null) {
            self.explore_feeds_end = true;
          }
        })
        .catch(function () {});
      self.isLoading = false;
    },
    async loadSubscribedFeedsData(page, perPage, text) {
      this.isLoadingSubscribed = true;
      this.followPage = 1;
      this.page = 1;
      this.followCelebrityPosts = [];
      this.allCelebrityPosts = [];
      this.tab = 2;
      var self = this;
      await this.$axios
        .$get(
          `/auth/getSubscribedCelebrityPosts?page=${page}&perPage=${perPage}&search=${text}`
        )
        .then(function (response) {
          const data = response.data;
          if(data.length > 0){
            self.has_new_posts = true 
          }else{
            self.has_new_posts = false 

          }
          self.isLoadershow = false;
          self.isAPILoaderShow = false;
          self.subscribedCelebrityPosts.push(...data);
          self.subPage++;
        })
        .catch(function () {});
      this.isLoadingSubscribed = false;
    },
    async loadFollowingFeedsData(page, perPage, text) {
      this.isLoadingFollow = true;
      this.page = 1;
      this.subPage = 1;
      this.allCelebrityPosts = [];
      this.subscribedCelebrityPosts = [];
      this.tab = 3;
      var self = this;
      await this.$axios
        .$get(
          `/auth/getPostsOfFollowingCelebrity?page=${page}&perPage=${perPage}&search=${text}`
        )
        .then(function (response) {
          const data = response.data;
          if(data.length > 0){
            self.has_new_posts = true 
          }else{
            self.has_new_posts = false 

          }
          self.isLoadershow = false;
          self.isAPILoaderShow = false;
          self.followCelebrityPosts.push(...data);
          self.followPage++;
        })
        .catch(function () {});
      this.isLoadingFollow = false;
    },
    async onScroll() {
      const el = this.$refs.scrollTrigger;
      if (!el) {
        return;
      }
      const { top } = el.getBoundingClientRect();
      const { innerHeight } = window;
      if (Math.floor(top) <= innerHeight) {
        if (this.tab == 1) {
         if(this.has_new_posts){
          self.isAPILoaderShow = true;
           this.loadAllFeedsData(this.page, this.perPage, "");
         }
        }
        if (this.tab == 2) {
          if(this.has_new_posts){
            self.isAPILoaderShow = true;
          this.loadSubscribedFeedsData(this.subPage, this.perPage, "");
          }
        }
        if (this.tab == 3) {
          if(this.has_new_posts){
            self.isAPILoaderShow = true;
          this.loadFollowingFeedsData(this.followPage, this.perPage, "");
          }
        }
      }
    },
    searchQuery(e) {
      if (this.tab == 1) {
        this.allCelebrityPosts = [];
        this.loadAllFeedsData(1, "", e.text);
      }
      if (this.tab == 2) {
        this.subscribedCelebrityPosts = [];
        this.loadSubscribedFeedsData(1, "", e.text);
      }
      if (this.tab == 3) {
        this.followCelebrityPosts = [];
        this.loadFollowingFeedsData(1, "", e.text);
      }
    },
    getaAllData(e) {
      if (this.tab == 1) {
        this.allCelebrityPosts = [];
        this.loadAllFeedsData(1, "", "");
      }
      if (this.tab == 2) {
        this.subscribedCelebrityPosts = [];
        this.loadSubscribedFeedsData(1, "", "");
      }
      if (this.tab == 3) {
        this.followCelebrityPosts = [];
        this.loadFollowingFeedsData(1, "", "");
      }
    },
  },
  mounted() {
    this.$nuxt.$on("getcontent", (e) => {
      this.getpost();
      // alert("hi3");
    });

    var grandparentElement =
      document.querySelector(".tabs").parentElement.parentElement.parentElement
        .parentElement;
    grandparentElement.addEventListener("scroll", () => {
      this.onScroll();
    });
  },
  destroyed() {
    var grandparentElement =
      document.querySelector(".tabs").parentElement.parentElement.parentElement
        .parentElement;
    grandparentElement.removeEventListener("scroll", () => {
      this.onScroll();
    });
  },
};
</script>

<style>
@media only screen and (max-width: 768px) {
  .tabs-link-name .fi {
    font-size: 12px;
  }
  .tabs-link-name span {
    font-size: 10px;
  }
  .ff-tablink-pro {
    padding: 4px 15px 2px 15px !important;
  }
}
</style>
