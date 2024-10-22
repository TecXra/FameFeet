<template>
  <div class="container-fluid">
    <Loader v-if="is_Show"></Loader>
    <section class="ptbm pricingPaid mt-3" v-if="!is_Show">
      <div class="container px-0">
        <div class="row">
          <div class="col-12">
            <div class="panel pricingGrid pricingBasic">
              <!-- {{subscription.id}} -->
              <div class="panel-heading ff-variant-pink rounded-top">
                <div class="d-flex justify-content-between">
                  <!-- {{ item.subcribe_user}} -->
                  <h3>My Subscriptions</h3>
                  <!-- <h3>{{ subscription.coins | toCurrency }}</h3> -->
                </div>
              </div>
              <div class="panel-body">
                <!-- <p class="mb-1">Features Include</p> -->
                <div class="ml-4 mb-2">
                  Total Subscriptions:
                  <strong>{{ SubDetails.length }}</strong>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div>
                      <b-table :busy="!SubDetails.length" striped hover head-variant="headvar" class="text-center"
                        :items="SubDetails" :fields="fields" responsive caption-top>
                        <!-- <template #table-caption>Transaction Details</template> -->
                        <template #cell(#)="data">
                          <span v-html="data.index + 1"></span>
                        </template>
                        <template #cell(Celebrity)="data">
                          <div class="go-to-profile d-flex text-left" @click="goToProfile(data.item.username,data.item.account_status)">
                            <b-avatar size="2rem" :src="data.item.avatarURL"></b-avatar>
                            <span class="ml-2">{{ data.item.username }}</span>
                          </div>
                          <!-- <span>{{ data.item.username }}</span> -->
                        </template>
                        <template #cell(cost)="data">
                          <span>{{
                            data.item.subscription.subscribe_user[0].coins
                            | toCurrency
                          }}</span>
                        </template>
                        <template #cell(start_date)="data">
                          <span>{{
                            data.item.subscription.subscribe_user[0]
                              .subscription_start_date | formatDate
                          }}</span>
                        </template>
                        <template #cell(end_date)="data">
                          <span>{{
                            data.item.subscription.subscribe_user[0]
                              .subscription_end_date | formatDate
                          }}</span>
                        </template>
                        <template #cell(recharge_date)="data">
                          <span>{{
                            data.item.subscription.subscribe_user[0]
                              .subscription_end_date | formatDate
                          }}</span>
                        </template>
                        <template #cell(Status)="data">
                          <span v-if="data.item.subscription.subscribe_user[0].status ==
                            1
                            ">Enable</span>
                          <span v-else>Disabled</span>
                        </template>
                        <template #cell(action)="data">
                          <button class="btn ff-btn1-pink py-1 px-2">
                            <span class="" v-if="data.item.subscription.subscribe_user[0]
                                .status == 1
                              " @click="
                                     deleteSubscriptionReq(
                                      data.item.subscription.subscribe_user[0].id,
                                      data.item.subscription.subscribe_user[0]
                                      .status
                                          )
                                     ">Unsubscribe</span>
                                     <!-- d-none d-md-block -->
                               <span class="" v-if="data.item.subscription.subscribe_user[0]
                                  .status == 0
                                 " @click="
                                  deleteSubscriptionReq(
                                   data.item.subscription.subscribe_user[0].id,
                                   data.item.subscription.subscribe_user[0]
                                   .status
                                    )
                                  ">Subscribe</span>
                          </button>
                        </template>
                        <template #table-busy>
                          <div class="text-center transaction-not-found my-2">
                            <strong>No subscription found</strong>
                          </div>
                        </template>
                      </b-table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <b-modal hide-footer centered header-class="ff-heading-modal" size="md" content-class="ff-Sign-modal"
      id="Subscriptions-modal">
      <template #modal-title>
        {{ sub_status === 1 ? 'Disable Subscriptions' : 'Enable Subscriptions' }}
      </template>

      <p v-if="sub_status == 1">
        Are you sure you want to disable this subscription?
      </p>
      <p v-if="sub_status == 0">
        Are you sure you want to enable this subscription?
      </p>
      <div class="text-center mb-3 mt-3 ff-paragraph4">
        <a @click="disableSubscription(sub_id, sub_status)"
          class="ff-btn1-pink px-3 py-2 text-uppercase famefeet-link-a">Yes</a>
        <a @click="$bvModal.hide('Subscriptions-modal')"
          class="ff-btn1-pink px-3 py-2 text-uppercase famefeet-link-a">No</a>
      </div>
    </b-modal>
  </div>
</template>
<script>
import Loader from "@/components/common/loader";
export default {
  layout: "fan",
  name: "subscriptions",
  components: { Loader },

  data() {
    return {
      sub_status: null,
      sub_id: null,
      fields: [
        "#",
        "Celebrity",
        "Cost",
        "start_date",
        "end_date",
        "recharge_date",
        "Status",
        "action",
      ],
      SubDetails: [],
      is_Show: true,
    };
  },
  mounted() {
    this.getSubscriptionDetails();
  },
  methods: {
    deleteSubscriptionReq(id, status) {
      this.sub_status = status;
      this.sub_id = id;
      this.$bvModal.show("Subscriptions-modal");
    },
    async disableSubscription(id, status) {
      if (status == 1) {
        var payload = {
          status: 0,
        };
      } else {
        var payload = {
          status: 1,
        };
      }
      var self = this;
      await this.$axios
        .post("/auth/changeStatusOfSubscriptionFanSide/" + id, payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
        })
        .catch(function (error) {
          const object = error.response.data;
          for (const property in object) {
            self.$bvToast.toast(object[property][0], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
        });
      self.getSubscriptionDetails();
      self.$bvModal.hide("Subscriptions-modal");
    },
    async getSubscriptionDetails() {
      var self = this;
      await this.$axios
        .$get("/auth/getAuthUserBuySubscriptions")
        .then(function (response) {
          self.is_Show = false;
          self.SubDetails = response.sort((a,b)=> new Date(a.subscription.subscribe_user[0].subscription_end_date) - new Date(b.subscription.subscribe_user[0].subscription_end_date));
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
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

<style></style>
