<template>
  <div>
    <Loader v-if="isLoadershow"></Loader>

    <div class="container-fluid" v-else>
      <WalletBox @paymentsuccesss="paymentsuccesss" :spend="availablAmount" :remaining="remaining_coins" />
      <b-row class="align-items-end mt-2">
        <b-col md="6" lg="6" xl="3" sm="6">
          <b-form-group id="datepicker-start-date-fan" label="Start Date:" label-class="form-label " class="mb-0">
            <b-form-datepicker v-model="startDate" :date-format-options="{
              year: 'numeric',
              month: 'numeric',
              day: 'numeric',
            }" class="date-picker-hight-fan Famefeet-input-field" placeholder="Start Date">
            </b-form-datepicker>
          </b-form-group>
        </b-col>

        <b-col md="6" lg="6" xl="3" sm="6">
          <b-form-group id="datepicker-end-date-fan" label="End Date:" label-class="form-label " class="mb-0">
            <b-form-datepicker :date-format-options="{
              year: 'numeric',
              month: 'numeric',
              day: 'numeric',
            }" id="datepicker-dateformat2" v-model="endDate" :min="startDate"
              class="date-picker-hight-fan Famefeet-input-field" placeholder="End Date">
            </b-form-datepicker>
          </b-form-group>
        </b-col>
        <b-col md="6" lg="6" xl="3" sm="6">
          <b-form-group label="Status:" class="mb-0">
            <b-form-select class="file-select-type-opt" v-model="selectedOption">
              <option :value="null" disabled>Select Type</option>
              <option value="all">All</option>

              <option v-for="option in type_Options" :key="option.id" :value="option.id">
                {{ option.name }}
              </option>
            </b-form-select>
          </b-form-group>
        </b-col>
        <b-col md="6" lg="6" xl="3" sm="6" class="d-flex align-items-center mt-3 mt-lg-0 justify-content-center">
          <b-button class="btn ff-btn1-pink border-0 search-wallet-celb-fan"
            @click="handleGetFilterData()">Search</b-button>
          <b-button class="ml-3 btn ff-search-clear border-0 search-wallet-celb-fan"
            @click="handleClearData()">Clear</b-button>
        </b-col>
      </b-row>
      <div class="row mb-3 mt-3">
        <div class="col-xl-8">
          <div class="transactions-side">
            <div class="transactions-side-header px-3 py-2">
              <h5 class="mb-0">Transactions History</h5>
            </div>
            <div>
              <div class="transactions-side-table px-3 py-2">
                <!-- {{ paginatedItems }} -->
                <b-table striped hover :items="paginatedItems" :fields="fields" :busy="emptyWallet"
                  head-variant="lighttest" responsive caption-top class="custom-table-fan">
                  <!-- <template #table-caption>Transaction History</template> -->

                  <template #cell(serial)="data">
                    <span>{{ data.item.index }}</span>
                  </template>
                  <template #cell(Date)="data">
                    <span>{{ data.item.created_at | formatDate }}</span>
                  </template>
                  <template #cell(name)="data">
                    <span class="text-center wallet-me-fan text-info"
                      v-if="data.item.celebrity_user.length == 0">(You)</span>
                    <span v-else class="wallet-profile-fan text-info wallet-me-fan" @click="
                      goToProfile(
                        data.item.celebrity_user.id,
                        data.item.celebrity_user.celebrity_id,
                        data.item.celebrity_user.username
                      )
                      ">{{ data.item.celebrity_user.username }}</span>
                  </template>

                  <template #cell(type)="data">
                    <span>{{ data.item.log_type }}</span>
                  </template>
                  <template #cell(Amount)="data">
                    <span>{{ data.item.from_amount | toCurrency }}</span>
                  </template>
                  <!-- <template #table-busy>
                    <div class="text-center transaction-not-found-fan my-2">
                      <strong>No transaction found</strong>
                    </div>
                  </template>
                </b-table> -->
                  <template #table-busy>
                    <div class="text-center my-2">
                      <b-spinner class="align-middle"></b-spinner>
                      <strong>Loading...</strong>
                    </div>
                  </template>
                </b-table>
                <div v-if="paginatedItems.length == 0 && !emptyWallet">
                  <div class="text-center transaction-not-found my-2">
                    <strong>No transaction found</strong>
                  </div>
                </div>
                <b-pagination v-if="items.length > 10" v-model="currentPage" :total-rows="items.length"
                  :per-page="perPage" align="center" size="sm" class="mt-3"></b-pagination>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="topup-side">
            <div class="topup-side-header px-3 py-2">
              <h5 class="mb-0">Topup History</h5>
            </div>
            <div class="topup-side-table">
              <TopupTable :itemsdata="fanTopUps" :busy="topupTableBusy" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loader from "@/components/common/loader";
import WalletBox from "@/components/fan/wallet/walletbox";
import TopupTable from "@/components/fan/wallet/topup";
export default {
  name: "test",
  layout: "fan",
  components: { WalletBox, TopupTable, Loader },

  data() {
    return {
      items: [],
      currentPage: 1,
      perPage: 10, // Number of items to display per page
      fields: ["serial", "Date", "name", "type", "Amount"],
      availablAmount: 0,
      remaining_coins: 0,
      isLoadershow: true,
      walletDetails: null,
      emptyWallet: true,
      selectedOption: null,
      startDate: null,
      endDate: null,
      withdrawalTab: false,
      fanTopUps: [],
      tableLoaderShow: false,
      topupTableBusy: true,
      type_Options: [],
    };
  },
  mounted() {
    this.getWallet();
    this.getFanTopUps();
    this.logTypes();
  },
  methods: {
    async paymentsuccesss() {
      await this.getFanTopUps();
      await this.getWallet();
    },
    async logTypes() {
      var self = this;
      await this.$axios
        .$get("/auth/logTypes")
        .then(function (response) {
          self.type_Options = response;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    async getWallet() {
      this.emptyWallet = true;
      var self = this;
      await this.$axios
        .$get("/auth/getWalletFanSide")
        .then(function (response) {
          if (response == "") {
            self.walletDetails = null;
          } else {
            self.walletDetails = response;
            self.walletDetails.coinlog = self.walletDetails.coinlog.map(
              (item, index) => ({
                ...item,
                index: index + 1,
              })
            );
            self.remaining_coins = self.walletDetails.remaining_coins;
            self.availablAmount = self.walletDetails.total_spent_coins;
            self.items = self.walletDetails.coinlog;
          }
          self.isLoadershow = false;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      self.emptyWallet = false;

      // self.tableLoaderShow = false;
    },
    async handleGetFilterData() {
      this.emptyWallet = true;
      // if (this.selectedOption === "all") {
        // await this.getWallet();
        // return;
      // }
      this.items = [];
      const payload = {
        type: this.selectedOption,
        start_date: this.startDate,
        end_date: this.endDate,
      };

      try {
        const response = await this.$axios.post(
          "/auth/getWalletFanSideFilter",
          payload
        );
        if (Object.keys(response.data).length === 0) {
          this.walletDetails = null;
          this.emptyWallet = true;
        } else if (response.status === 200) {
          this.walletDetails = response.data; // Assign the data property of the response

          // Modify coinlog array with index
          this.walletDetails.coinlog = this.walletDetails.coinlog.map(
            (item, index) => ({
              ...item,
              index: index + 1,
            })
          );
          console.log(this.walletDetails);

          this.remaining_coins = this.walletDetails.remaining_coins;
          this.availablAmount = this.walletDetails.total_spent_coins;
          this.items = this.walletDetails.coinlog;
        } else {
          console.error("Non-OK response:", response.status);
        }
      } catch (error) {
        console.error("An error occurred:", error);
      }

      this.emptyWallet = false;
    },
    handleClearData() {
      this.items = [];
      this.startDate = "";
      this.endDate = "";
      this.getWallet();
    },
    async getFanTopUps() {
      var self = this;
      self.topupTableBusy = true;
      await this.$axios
        .$get("/auth/fanTopUps")
        .then(function (response) {
          self.fanTopUps = response.sort((a,b)=> new Date(b.date) - new Date(a.date));
          self.fanTopUps = self.fanTopUps.map((item, index) => ({
            ...item,
            index: index + 1,
          }));
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      self.topupTableBusy = false;
    },
    goToProfile(userid, celebid, username) {
      this.$router.push({
        path: "/celebrity/" + username,
      });
    },
    handleFilterTransactionsData() { },
    handleClearTransactionsData() { },
  },
  computed: {
    paginatedItems() {
      const startIndex = (this.currentPage - 1) * this.perPage;
      const endIndex = startIndex + this.perPage;
      if (this.items.length) {
        return this.items.slice(startIndex, endIndex);
      } else {
        return [];
      }
    },
  },
};
</script>

<style>
#datepicker-start-date-fan .b-form-btn-label-control.form-control>.form-control {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}

#datepicker-end-date-fan .b-form-btn-label-control.form-control>.form-control {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}

.date-picker-hight-fan {
  height: calc(2.5em + 0.75rem + 2px) !important;
  background-color: #f4f4f4 !important;
  border: 0px solid #ced4da;
  border-radius: 2.25rem;
}

#datepicker-end-date-fan .b-form-btn-label-control.form-control>.form-control {
  padding-top: 0.9rem !important;
}

#datepicker-start-date-fan .b-form-btn-label-control.form-control>.form-control {
  padding-top: 0.9rem !important;
}

.transactions-side-header {
  border-radius: 0.5rem 0.5rem 0rem 0rem;
  background-color: var(--primary);
}

.transactions-side-table {
  background-color: var(--primarylight);
}

.topup-side-table {
  background-color: var(--primarylight);
}

.topup-side-header {
  background-color: var(--primary);
  border-radius: 0.5rem 0.5rem 0rem 0rem;
}

.custom-table-fan {
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.custom-table-fan th {
  /* background-color: var(--primary); */
  border-top: none;
  border-bottom-color: #dee2e6;
  font-weight: bold;
  text-transform: uppercase;
}

.custom-table-fan td {
  border-top-color: #dee2e6;
}

.custom-table-fan tbody tr:hover {
  background-color: #f8f9fa;
}

.wallet-me-fan {
  font-size: 1em !important;
}

.wallet-profile-fan {
  cursor: pointer;
  color: #007bff;
  font-size: 1.2em;
}

.transaction-not-found-fan {
  color: #6c757d;
  font-size: 1.2em;
}

.search-wallet-celb-fan {
  padding-bottom: 0.9rem;
  padding-top: 0.9rem;
}

.thead-lighttest {
  background-color: var(--secondary);
  color: #fff;
  box-shadow: 0px 4px 8px rgba(0.15, 0.15, 0.15, 0.15);
}

.file-select-type-opt {
  height: calc(2.5em + 0.75rem + 2px) !important;
  font-size: 1rem !important;
  font-weight: 400 !important;
  line-height: 1.5 !important;
  padding-left: 0.8rem;
  background-color: #f4f4f4 !important;
  border: 0px solid #ced4da;
  border-radius: 2.25rem;
}
@media only screen and (max-width: 320px) {
  .ff-btn1-pink {
    padding: 5px 15px 5px 15px;
    font-size: 15px;

  }
  .ff-search-clear{
    padding: 5px 15px 5px 15px;
    font-size: 15px;
  }
  .search-wallet-celb-fan {
  padding-bottom: 0.9rem;
  padding-top: 0.9rem;
  width: 100%;
}
}
</style>
