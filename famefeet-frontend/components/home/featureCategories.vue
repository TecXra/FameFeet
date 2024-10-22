<template>
  <div class="ff-section-area pt-5">
    <div class="text-center">
      <h2 class="ff-heading2 text-light">FEATURED CATEGORIES</h2>
      <p class="ff-paragraph2 px-3 pb-3 mb-4 p-sm-0">
        Find/Explore easily your preferred content with categories
      </p>
    </div>

    <div
      class="row text-center text-lg-start m-0 px-4 d-flex justify-content-center"
    >
      <div
        class="col-lg-2 col-md-4 col-6"
        v-for="(item, index) in allCategories"
        :key="index"
      >
        <!-- {{ item.text }} -->
        <div class="bg-image-area" @click="gotoPage(item.id)">
          <div class="">
            <div
              class="content-img"
              :style="{ background: `url(${item.filePathUrl})` }"
            ></div>
          </div>
        </div>

        <p class="text-light h5 mt-2 mb-3">{{ item.text }}</p>
      </div>
    </div>
    <div class="text-center pt-3 pb-5">
      <button class="btn ff-btn-pink-pro" @click="goToCategories()">
        VIEW MORE CATEGORIES
      </button>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
    // filteredArray: function () {
    //   return function (e) {
    //     return this.allCategories.filter((item) => item.text.startsWith(e));
    //   };
    // },
  },

  name: "featureCategories",

  data() {
    return {
      allCategories: [],
    };
  },
  mounted() {
    this.getCategoriesHaveImages();
  },
  methods: {
    gotoPage(id) {
      this.$router.push({
        path: "/contents/",
        query: { category: id },
      });
    },
    async getCategoriesHaveImages() {
      var self = this;
      await this.$axios
        .$get("/getCategoriesHaveImages")
        .then(function (response) {
          self.allCategories = response;
          self.isShow = false;
        })
        .catch(function (error) {
          // self.$bvToast.toast(error, {
          //   title: "Warning",
          //   variant: "warning",
          //   solid: true,
          // });
        });
    },

    goToCategories() {
      this.$router.push("/categories");
    },
  },
};
</script>

<style lang="css" scoped>
.ff-btn-pink-pro {
  color: white;
  background-color: var(--primary);
  padding: 14px 44px 14px 44px;
  font-size: 18px;
  font-weight: 700;
  box-shadow: rgb(28 27 27 / 45%) 0px 4px 29px -6px;
  border-radius: 100px;
}
.bg-image-area {
  border-radius: 10px;
  box-shadow: rgb(0 0 0 / 25%) 0px 5px 14px 0px;
  overflow: hidden;
}
.bg-image-area:hover {
  cursor: pointer;
}
.content-img {
  background-position: center !important;
  background-size: cover !important;
  background-repeat: no-repeat !important;
  padding-top: 100%;
  position: relative;
  border-radius: 10px;
  margin: -5px -10px -10px -5px;
}
@media only screen and (max-width: 600px) {
  .ff-btn-pink-pro {
    font-size: 13px;
    padding: 12px 15px;
  }
}
</style>
