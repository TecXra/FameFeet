<template>
  <b-modal
    hide-footer
    hide-header
    centered
    :id="'buyerdetail' + orderid"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <section class="pt-3 pb-3" style="background-color: #f7f6f6; border-radius: 12px">
      <!-- {{ user.user_type == 2 }} -->
      <h4 class="pt-3 pl-2" v-if="user.user_type == 2">Sold by</h4>
      <h4 v-else class="pl-2">Buyer Details</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <div class="w-100">
                    <div class="" v-if="user.user_type == 2">
                      <!-- {{ buyerinfo }} -->
                      <GoToProfile
                        :size="'3rem'"
                        :username="buyerinfo.user.username"
                        :userid="buyerinfo.user_id"
                        :celebid="buyerinfo.id"
                        :avatarURL="buyerinfo.user.avatarURL"
                        :accountstatus="buyerinfo.user.account_status"
                        :type="'celeb'"
                      ></GoToProfile>
                    </div>
                    <div class="" v-else>
                     
                      <GoToProfile
                        :size="'3rem'"
                        :username="buyerinfo.username"
                        :userid="buyerinfo.id"
                        :celebid="null"
                        :avatarURL="buyerinfo.avatarURL"
                        :account_status="buyerinfo.account_status"
                        :type="'fan'"
                      ></GoToProfile>
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
          class="mt-3 ff-btn1-pink border-0"
          @click="$bvModal.hide('buyerdetail' + orderid)"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>
<script>
import { mapState } from "vuex";
import GoToProfile from "@/components/common/goToProfile";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  name: "buyerDetails",
  props: ["orderid", "buyerinfo"],
  components: { GoToProfile },

  data() {
    return {};
  },
};
</script>

<style></style>
