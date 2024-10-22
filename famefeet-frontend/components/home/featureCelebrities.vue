<template>
  <div class="bg-white" :class="{ noceleb: !firstTenCelebrities.length }">
    <div v-if="firstTenCelebrities.length">
      <div class="text-center pt-5">
        <h2 class="ff-heading2 mb-4">FEATURED CELEBRITIES</h2>
      </div>
      <!-- {{ filteredItems }} -->
      <div class="px-5" v-if="firstTenCelebrities.length">
        <vue-horizontal responsive class="horizontal" :displacement="0.7">
          <div
            class="ff-horizontal-section"
            v-for="(celebrity, index) in firstTenCelebrities"
            :key="index"
            @click="goToProfile(celebrity.username)"
          >
            <!-- {{ celebrity.username}} -->
            <div
              class="ff-horizintal-image"
              :style="{ background: `url(${celebrity.avatarURL})` }"
            >
              <div class="overlay-mian">
                <!-- <div class="text">{{ celebrity.username }}</div> -->
              </div>
            </div>
            <div class="content text-center">
              <h6 class="mt-2 font-weight-bold">{{ celebrity.username }}</h6>
            </div>
          </div>
        </vue-horizontal>
      </div>
      <div class="text-center pt-3 pb-5">
        <!-- {{ loggedIn }} -->
        <button class="btn ff-btn-blue" @click="goToCelebrity('/celebrities')">
          VIEW ALL CELEBRITY
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import VueHorizontal from "vue-horizontal";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },

  name: "featureCelebrities",
  components: { VueHorizontal },

  data() {
    return {
      firstTenCelebrities: [],
    };
  },
  mounted() {
    this.getAllCelebrities();
  },
  methods: {
    async getAllCelebrities() {
      var self = this;
      await this.$axios
        .$get("/getFirstTenCelebrities")
        .then(function (response) {
          self.isShow = false;
          self.firstTenCelebrities = response;
        })
        .catch(function (error) {
          // const object = error.response.data;
          // for (const property in object) {
          //   self.$bvToast.toast(object[property][0], {
          //     title: "Warning",
          //     variant: "warning",
          //     solid: true,
          //   });
          // }
        });
    },
    goToCelebrity(page) {
      this.$router.push(page);
    },
    goToProfile(username) {
      this.$router.push("/celebrity/" + username);
    },
  },
};
</script>

<style lang="css" scoped>
.noceleb {
  height: 40px;
}
.overlay-mian {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  display: flex;
  border-radius: 20px;
  justify-content: flex-end;
  align-items: flex-end;
  background: linear-gradient(
    345deg,
    #00000080 0,
    #00000060 5%,
    #00000040 20%,
    #00000000 50%
  );
}
.ff-horizintal-image {
  background-position: center !important;
  background-size: cover !important;
  background-repeat: no-repeat !important;
  padding-top: 100%;
  position: relative;
  border-radius: 20px;
}
.ff-horizontal-section {
  width: 100%;
  margin-right: 24px;
  cursor: pointer;
}

@media only screen and (max-width: 600px) {
  .ff-horizontal-section {
    width: calc((100% - (2 * 10px)) / 2) !important;
    padding: 0px 0px;
    width: 100%;
  }
}
@media only screen and (min-width: 600px) {
  .ff-horizontal-section {
    width: calc((100% - (2 * 24px)) / 3) !important;
    padding: 0px 0px;
    width: 100%;
  }
}
@media only screen and (min-width: 768px) {
  .ff-horizontal-section {
    width: calc((100% - (3 * 24px)) / 4) !important;
    padding: 0px 0px;
    width: 100%;
  }
}
@media only screen and (min-width: 1024px) {
  .ff-horizontal-section {
    width: calc((100% - (4 * 24px)) / 5) !important;
    padding: 0px 0px;
    width: 100%;
  }
}
@media (min-width: 1200px) {
  .ff-horizontal-section {
    width: calc((100% - (5 * 24px)) / 6) !important;
    padding: 0px 0px;
    width: 100%;
  }
}
</style>
