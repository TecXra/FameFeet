<template>
  <div class="container-fluid">
    <Loader v-show="isLoadershow"></Loader>
    <Search
      class="mt-3"
      v-show="!isLoadershow"
      @searchQuery="searchQuery"
      @getaAllData="getaAllData"
    ></Search>
    <div class="mt-3" v-show="!isLoadershow">
      <div>
        <b-tabs
          content-class=""
          align="center"
          nav-class="position-relative tabs-nav-link"
          active-nav-item-class="ff-tabs-link"
        >
          <b-tab active title-link-class="ff-tablink-pro" @click="tab = 1">
            <template #title>
              <div
                class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
              >
                <i class="mr-0 mr-md-1 fi fi-rr-users-alt"></i>
                <span class="d-md-inline-block">All Celebrities</span>
              </div>
            </template>
            <div class="">
              <div class="row w-100 m-0 p-0">
                <div class="col-lg-12">
                  <p
                    class="p-3 ff-paragraph4 h3 text-center"
                    v-if="!allCelebrity.length"
                  >
                    No celebrities found.
                  </p>
                  <Celebrities :celebrities="allCelebrity"></Celebrities>
                </div>
              </div>
              <div
                class="row w-100 m-0 p-0"
                v-if="
                  allCelebrityPaginatedData.total >
                  allCelebrityPaginatedData.per_page
                "
              >
                <div class="col-lg-12 product-pagination">
                  <b-pagination
                    pills
                    v-model="allCelebrityPaginatedData.current_page"
                    :total-rows="allCelebrityPaginatedData.total"
                    :per-page="allCelebrityPaginatedData.per_page"
                    align="center"
                    first-number
                    last-number
                    @change="updateCurrentPage"
                  >
                  </b-pagination>
                </div>
              </div>
            </div>
          </b-tab>

          <b-tab
            title-link-class="ff-tablink-pro"
            @click="getFollowingCelebrities(followingcurrent_page, '', '')"
          >
            <template #title>
              <div
                class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
              >
                <i class="mr-0 mr-md-1 fi fi-rr-user-add"></i>
                <span class="d-md-inline-block">Following</span>
              </div>
            </template>

            <div class="">
              <div class="row w-100 m-0 p-0">
                <div class="col-lg-12">
                  <p
                    class="p-3 ff-paragraph4 h3 text-center"
                    v-if="!FollowingCelebrities.length"
                  >
                    You are not follow anyone yet.
                  </p>
                  <Celebrities
                    :celebrities="FollowingCelebrities"
                  ></Celebrities>
                </div>
              </div>
              <div
                class="row w-100 m-0 p-0"
                v-if="
                  followingCelebrityPaginatedData.total >
                  followingCelebrityPaginatedData.per_page
                "
              >
                <div class="col-lg-12 product-pagination">
                  <b-pagination
                    pills
                    v-model="followingCelebrityPaginatedData.current_page"
                    :total-rows="followingCelebrityPaginatedData.total"
                    :per-page="followingCelebrityPaginatedData.per_page"
                    align="center"
                    first-number
                    last-number
                    @change="updateFollowingCurrentPage"
                  >
                  </b-pagination>
                </div>
              </div>
            </div>
          </b-tab>
          <b-tab
            title-link-class="ff-tablink-pro"
            @click="getFollowersCelebrities(Followercurrent_page, '', '')"
          >
            <template #title>
              <div
                class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
              >
                <i class="mr-0 mr-md-1 fi fi-rr-following"></i>
                <span class="d-md-inline-block">Followers</span>
              </div>
            </template>

            <div class="">
              <div class="row w-100 m-0 p-0">
                <div class="col-lg-12">
                  <p
                    class="p-3 ff-paragraph4 h3 text-center"
                    v-if="!FollowerCelebrities.length"
                  >
                    You are not followed by anyone.
                  </p>
                  <Celebrities :celebrities="FollowerCelebrities"></Celebrities>
                </div>
              </div>
              <div
                class="row w-100 m-0 p-0"
                v-if="
                  followerCelebrityPaginatedData.total >
                  followerCelebrityPaginatedData.per_page
                "
              >
                <div class="col-lg-12 product-pagination">
                  <b-pagination
                    pills
                    v-model="followerCelebrityPaginatedData.current_page"
                    :total-rows="followerCelebrityPaginatedData.total"
                    :per-page="followerCelebrityPaginatedData.per_page"
                    align="center"
                    first-number
                    last-number
                    @change="updateFollowerCurrentPage"
                  >
                  </b-pagination>
                </div>
              </div>
            </div>
          </b-tab>
        </b-tabs>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
import Loader from "@/components/common/loader";
import Search from "@/components/common/searchCategories";
import Celebrities from "@/components/fan/celebrities/allCelebrities";
export default {
  name: "celebrities",
  layout: "fan",
  components: { Search, Celebrities, Loader },
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  data() {
    return {
      // all celebrity
      current_page: 1,
      tab: 1,
      allCelebrityPaginatedData: {},
      allCelebrity: [],
      // Following celebrity
      followingcurrent_page: 1,
      FollowingCelebrities: [],
      followingCelebrityPaginatedData: [],
      // Follower celebrity
      Followercurrent_page: 1,
      followerCelebrityPaginatedData: [],
      FollowerCelebrities: [],
      hasPrev: false,
      hasNext: true,
      isLoadershow: true,
      searchText: "",
      searchCategoryId: "",
    };
  },
  mounted() {
    this.getCelebrities(this.current_page, "", "");
  },
  methods: {
    updateCurrentPage(pageNumber) {
      this.current_page = pageNumber;
      this.getCelebrities(pageNumber, "", "");
    },
    updateFollowingCurrentPage(pageNumber) {
      this.followingcurrent_page = pageNumber;
      this.getFollowingCelebrities(pageNumber, "", "");
    },
    updateFollowerCurrentPage(pageNumber) {
      this.Followercurrent_page = pageNumber;
      this.getFollowersCelebrities(pageNumber, "", "");
    },
    searchQuery(e) {
      if (this.tab == 1) {
        this.getCelebrities("", e.text, e.categories);
      }
      if (this.tab == 2) {
        this.getFollowingCelebrities("", e.text, e.categories);
      }
      if (this.tab == 3) {
        this.getFollowersCelebrities("", e.text, e.categories);
      }
    },
    getaAllData(e) {
      if (this.tab == 1) {
        this.getCelebrities(this.current_page, "", "");
      }
      if (this.tab == 2) {
        this.getFollowingCelebrities(this.current_page, "", "");
      }
      if (this.tab == 3) {
        this.getCelebrities(this.current_page, "", "");
      }
    },

    async getCelebrities(pageNumber, text, Categories) {
      this.tab = 1;
      this.isLoadershow = true;
      let self = this;
      await this.$axios
        .get(
          "/getAllCelebrities" +
            "?" +
            "&page=" +
            pageNumber +
            "&search=" +
            text +
            "&categories=" +
            Categories
        )
        .then(function (response) {
          self.current_page = response.data.current_page;
          self.allCelebrityPaginatedData = response.data;
          self.isLoadershow = false;
          self.allCelebrity = response.data.data;
        })
        .catch(function (error) {});
    },

    async getFollowingCelebrities(pageNumber, text, Categories) {
      this.tab = 2;
      this.isLoadershow = true;
      var self = this;
      await this.$axios
        .$get(
          "/auth/getAuthUserFollowing" +
            "?" +
            "&page=" +
            pageNumber +
            "&search=" +
            text +
            "&categories=" +
            Categories
        )
        .then(function (response) {
          console.log(response);
          self.isLoadershow = false;
          self.followingcurrent_page = response.current_page;
          self.followingCelebrityPaginatedData = response;
          self.FollowingCelebrities = response.data;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    async getFollowersCelebrities(pageNumber, text, Categories) {
      this.tab = 3;
      this.isLoadershow = true;
      var self = this;
      await this.$axios
        .$get(
          "/auth/getAuthUserFollower" +
            "?" +
            "&page=" +
            pageNumber +
            "&search=" +
            text +
            "&categories=" +
            Categories
        )
        .then(function (response) {
          self.isLoadershow = false;
          self.Followercurrent_page = response.current_page;
          self.followerCelebrityPaginatedData = response;
          self.FollowerCelebrities = response.data;
        })
        .catch(function (error) {
          console.log(error);
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
  },
};
</script>

<style></style>
