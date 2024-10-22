<template>
  <div class="">
    <Loader v-if="isLoader"></Loader>

    <div class="container-fluid mt-3" v-show="isLoader != true">
      <Content
        :allContentPostsImages="allContentPostsImages"
        :allContentPostsVideos="allContentPostsVideos"
      />
    </div>
  </div>
</template>
<script>
import Loader from "@/components/common/loader";
import Content from "@/components/fan/purchased/contents";
export default {
  layout: "fan",
  name: "purchasedContent",
  components: { Content, Loader },

  data() {
    return {
      isLoader: true,
      allContentPostsImages: [],
      allContentPostsVideos: [],
    };
  },

  mounted() {
    this.getPurchasedContent();
  },
  methods: {
    // Get All Posts
    async getPurchasedContent() {
      // this.isBusy = true;
      var self = this;
      await this.$axios
        .$get("/auth/getPurchasePostAndOfferContent")
        .then(function (response) {
          self.isLoader = false;
          let arry = response.Posts;
          let offerarry = response.Offers;
          let celebofferarry = response.celebrity_send_offer;

          // let celebrityoffer = response.celebrity_send_offer;
          let allPostArry = [];
          for (let index = 0; index < arry.length; index++) {
            var posts = arry[index].post;
            if(posts != null)
            {
              allPostArry.push(posts);
            }
          }

          for (let index = 0; index < celebofferarry.length; index++) {
            var celeboffer = celebofferarry[index];
            allPostArry.push(celeboffer);
          }

          for (let index = 0; index < offerarry.length; index++) {
            var offerposts = offerarry[index];
            allPostArry.push(offerposts);
          }

        allPostArry.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));

          ///////////////////////
          let temp = allPostArry.filter((items) => {
            if (items.content_type == "6") {
              return items;
            }
          });
          let temp2 = allPostArry.filter((items) => {
            if (items.content_type == "5") {
              return items;
            }
          });
          self.allContentPostsVideos = temp;
          self.allContentPostsImages = temp2;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            variant: "warning",
            solid: true,
          });
        });
    },
  },
};
</script>

<style lang="css" scoped></style>
