<template>
  <!-- Address Model -->
  <b-modal
    id="address-modal"
    hide-footer
    hide-header
    centered
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
    size="lg"
    @show="callAPIS()"
  >
    <h5 class="pt-2 pl-2">My Delivery Address</h5>
    <hr />
    <div class="row" v-if="!add_new_address">
      <div class="p-5 w-100" v-if="!get_address.length">
        <h4 class="text-center">No shipping address found.</h4>
      </div>
      <div
        class="col-12 col-md-6"
        v-for="(address, index) in get_address"
        :key="index"
      >
        <!-- @click="selectDefultAddress(address.id)" -->
        <div
          class="card multi-address-card mb-3"
          :class="{ selectedcard: address.selected_address == 1 }"
        >
          <div class="card-body">
            <div>
              <div class="d-flex justify-content-between align-items-center">
                <span class="">{{ address.name }}</span>
                <b-dropdown
                  variant="bg-white"
                  menu-class="dropdown-style"
                  toggle-class="p-0"
                  no-caret
                >
                  <template #button-content>
                    <b-icon icon="three-dots"></b-icon>
                  </template>
                  <b-dropdown-item @click="editSaveAddress(address.id, index)"
                    >Edit Address</b-dropdown-item
                  >
                  <b-dropdown-item @click="selectDefultAddress(address.id)"
                    >Set Default</b-dropdown-item
                  >

                  <b-dropdown-item v-if="get_address.length > 1 && address.selected_address !== 1" @click="deleteAddress(address.id)"
                    >Delete Address</b-dropdown-item
                  >
                </b-dropdown>
              </div>
              <div class="">
                <span class=""
                  >{{ address.countryCode }} {{ address.mobile }}</span
                >
              </div>
              <div class="">
                <small class=""
                  >{{ address.address_line_one }},
                  {{ address.address_line_two }},
                </small>
                <br />
                <small class="">
                  {{ address.city }}, {{ address.state }},
                  {{ address.zipcode }}, {{ address.country }}
                </small>
                <br />
              </div>
              <!-- <p class="mb-0">
                    <span class="text-muted">ALL (ITEM(S))</span>
                  </p> -->
            </div>
            <!-- <p class="card-text">
              Some quick example text to build on the card title and make up the
              bulk of the card's content.
            </p> -->
          </div>
        </div>
      </div>
    </div>

    <b-form-row class="mt-4" v-if="add_new_address">
      <div class="col-12 mb-2">
        <h6>Contact</h6>
      </div>
    </b-form-row>
    <b-form-row v-if="add_new_address">
      <div class="col-md-6">
        <b-form-group id="input-group-2" label-for="input-2">
          <b-form-input
            id="name"
            class="Famefeet-input-field"
            placeholder="Enter name *"
            required
            v-model="tempAddress.name"
          >
          </b-form-input>
        </b-form-group>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-3 col-lg-2 pr-0 shipping-country">
            <vue-country-code
              @onSelect="onSelect"
              disabled
              class=""
              defaultCountry="us"
              :preferredCountries="['vn', 'us', 'gb']"
            >
            </vue-country-code>
          </div>
          <div class="col-9 col-lg-10">
            <div class="form-group">
              <the-mask
                id="mobile"
                placeholder="Phone Number *"
                class="shipping-mobile"
                type="text"
                v-model="tempAddress.mobile"
                :mask="[selectedContryDialCode + ' (###) ###-####']"
              />
            </div>
          </div>
        </div>
      </div>
    </b-form-row>
    <b-form-row v-if="add_new_address">
      <div class="col-12 mb-2">
        <h6>Address</h6>
      </div>
    </b-form-row>
    <b-form-row v-if="add_new_address">
      <div class="col-md-6">
        <b-form-input
          id="address-line-one"
          required
          class="Famefeet-input-field"
          placeholder="Street, house/apartment/unit *"
          v-model="tempAddress.address_line_1"
        >
        </b-form-input>
      </div>
      <div class="col-md-6 mt-3 mt-md-0">
        <b-form-input
          id="address-line-two"
          class="Famefeet-input-field"
          placeholder="Apt, Suite, Unit, etc. (Optional)"
          v-model="tempAddress.address_line_2"
        >
        </b-form-input>
      </div>
    </b-form-row>
    <b-form-row class="mt-3" v-if="add_new_address">
      <div class="col-6 mt-md-0 col-md-3">
        <b-form-input
          id="city"
          class="Famefeet-input-field"
          placeholder="City *"
          v-model="tempAddress.city"
        >
        </b-form-input>
      </div>
      <div class="col-6 col-md-3">
        <div>
          <!-- <b-form-input
            class="Famefeet-input-field"
            placeholder="State/Province/Region"
            v-model="tempAddress.state"
          ></b-form-input> -->
          <b-form-group id="state-name">
            <b-form-select
              v-model="tempAddress.state"
              class="Famefeet-input-field"
              id="state-name"
              :options="state_Options"
              value-field="text"
            >
            </b-form-select>
          </b-form-group>
        </div>
      </div>
      <div class="col-6 mt-md-0 col-md-3">
        <the-mask
          id="zipcode"
          placeholder="Zip Code *"
          class="shipping-mobile"
          type="text"
          v-model="tempAddress.zipCode"
          :mask="['#####']"
        />
        <span v-if="tempAddress.zipCode ? tempAddress.zipCode.length !== 5 : false" class="text-danger">Zip code must be 5 digits</span>
      </div>
      <div class="col-6 col-md-3">
        <b-form-input
          id="country"
          disabled
          class="Famefeet-input-field"
          placeholder="Country *"
          v-model="tempAddress.country"
        >
        </b-form-input>
      </div>
    </b-form-row>
    <hr />
    <div class="d-flex justify-content-between align-items-center">
      <a class="ff-alink3" @click="addUpdateAdress()" v-if="!add_new_address"
        ><i class="fa fa-plus mr-1"></i> Add new Address</a
      >
      <a class="ff-alink3 d-flex align-items-baseline" @click="backbtn()" v-else
        ><i class="fa fa-arrow-left mr-1"></i>Back
        <span class="d-none d-sm-block ml-1">to Address</span></a
      >
      <div>
        <b-button
          class="ff-btn1-pink px-3 py-2 border-0"
          @click="$bvModal.hide('address-modal')"
          >Close</b-button
        >
        <b-button
          class="ff-btn1-pink px-3 py-2 border-0"
          @click="saveAddress()"
          v-if="!updateAddress && add_new_address != false"
          :disabled="
            !tempAddress.name ||
            !tempAddress.countryCode ||
            !tempAddress.mobile ||
            !tempAddress.address_line_1 ||
            !tempAddress.country ||
            tempAddress.zipCode.length !== 5 ||
            !tempAddress.city ||
            !tempAddress.state || 
            is_loading">
            <b-spinner small class="" v-show="is_loading"></b-spinner>
            Confirm
            </b-button
        >
        <b-button
          class="ff-btn1-pink px-3 py-2 border-0"
          @click="updateAddressEve(selected_id)"
          v-if="updateAddress"
          :disabled="
            !tempAddress.name ||
            !tempAddress.countryCode ||
            !tempAddress.mobile ||
            !tempAddress.address_line_1 ||
            !tempAddress.country ||
            tempAddress.zipCode.length !== 5 ||
            !tempAddress.city ||
            !tempAddress.state || 
            is_loading ">
            <b-spinner small class="" v-show="is_loading"></b-spinner>
            Update
            </b-button
        >
      </div>
    </div>
  </b-modal>
</template>
<script>
import { TheMask } from "vue-the-mask";
export default {
  components: { TheMask },

  data() {
    return {
      state_Options: [],
      get_address: [],
      add_new_address: false,
      isActive: true,
      is_loading: false,
      selectedContryDialCode: null,
      updateAddress: false,
      selected_id: null,
      tempAddress: {
        name: "",
        countryCode: "",
        mobile: "",
        address_line_1: "",
        address_line_2: "",
        country: "",
        zipCode: "",
        state: "",
        city: "",
      },
    };
  },
  mounted() {},

  methods: {
    callAPIS() {
      this.getAddresss();
      this.getStateList();
    },
    async getStateList() {
      var self = this;
      await this.$axios
        .get("/getAllStates")
        .then(function (response) {
          self.state_Options = response.data;
          self.tempAddress.state = self.state_Options[0].text;
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
    },
    onSelect({ name, iso2, dialCode }) {
      this.selectedContryDialCode = dialCode;
      this.tempAddress.countryCode = dialCode;
      this.tempAddress.country = name;
    },
    // saveAddress() {
    //   localStorage.setItem("address", JSON.stringify(this.tempAddress));
    //   this.$bvModal.hide("address-modal");
    //   this.$emit("updatedata");
    // },
    addUpdateAdress() {
      this.add_new_address = !this.add_new_address;
    },
    // editSaveAddress(id) {
    //   alert();
    // },
    // selectDefultAddress(id) {
    //   this.get_address[index].selected_address = true;
    //   // alert(index);
    // },
    removeAddress(id) {
      // this.get_address[index].selected_address = true;
      alert(id);
    },   
    backbtn() {
      this.updateAddress = false;
      this.add_new_address = false;
      this.tempAddress = {
        name: "",
        countryCode: "",
        mobile: "",
        address_line_1: "",
        address_line_2: "",
        country: "",
        zipCode: "",
        state: "",
        city: "",
      };
    },
    async saveAddress() {
      this.is_loading = true;
      var payload = {
        // selected_address: true,
        name: this.tempAddress.name,
        country_code: this.tempAddress.countryCode,
        mobile: this.tempAddress.mobile,
        address_line_one: this.tempAddress.address_line_1,
        address_line_two: this.tempAddress.address_line_2,
        country: this.tempAddress.country,
        zipcode: this.tempAddress.zipCode,
        state: this.tempAddress.state,
        city: this.tempAddress.city,
      };
      var self = this;
      await this.$axios
        .post("/auth/user/saveAddress", payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.$emit("changeAddress");
          self.is_loading = false;
        })
        .catch(function (error) {
          const object = error.response.data;
          for (const property in object) {
            self.$bvToast.toast(object[property], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
          self.is_loading = false;
        });
      self.getAddresss();
      self.tempAddress = {
        name: "",
        countryCode: "",
        mobile: "",
        address_line_1: "",
        address_line_2: "",
        country: "",
        zipCode: "",
        state: "",
        city: "",
      };
      self.updateAddress = false;
      self.add_new_address = false;
    },
    editSaveAddress(id, index) {
      this.add_new_address = true;
      this.tempAddress.name = this.get_address[index].name;
      this.tempAddress.countryCode = this.get_address[index].country_code;
      this.tempAddress.mobile = this.get_address[index].mobile;
      this.tempAddress.address_line_1 =
        this.get_address[index].address_line_one;
      this.tempAddress.address_line_2 =
        this.get_address[index].address_line_two;
      this.tempAddress.country = this.get_address[index].country;
      this.tempAddress.zipCode = this.get_address[index].zipcode;
      this.tempAddress.state = this.get_address[index].state;
      this.tempAddress.city = this.get_address[index].city;
      this.updateAddress = true;
      this.selected_id = id;
    },
    async updateAddressEve(id) {
      this.is_loading = true;
      var payload = {
        // selected_address: true,
        name: this.tempAddress.name,
        country_code: this.tempAddress.countryCode,
        mobile: this.tempAddress.mobile,
        address_line_one: this.tempAddress.address_line_1,
        address_line_two: this.tempAddress.address_line_2,
        country: this.tempAddress.country,
        zipcode: this.tempAddress.zipCode,
        state: this.tempAddress.state,
        city: this.tempAddress.city,
      };
      var self = this;
      await this.$axios
        .post("/auth/user/editAddress/" + id, payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.$emit("changeAddress");
          self.is_loading = false;
        })
        .catch(function (error) {
          const object = error.response.data;
          for (const property in object) {
            self.$bvToast.toast(object[property], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
          self.is_loading = false;
        });
      self.getAddresss();
      self.tempAddress = {
        name: "",
        countryCode: "",
        mobile: "",
        address_line_1: "",
        address_line_2: "",
        country: "",
        zipCode: "",
        state: "",
        city: "",
      };
      self.updateAddress = false;
      self.add_new_address = false;
      // self.$bvModal.hide("address-modal");
    },
    async deleteAddress(id) {
      this.is_loading = true;
      var self = this;
      await this.$axios
        .$delete("/auth/user/deleteAddress/" + id)
        .then(function (response) {
          self.$bvToast.toast(response.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.$emit("changeAddress");
          self.is_loading = false;
          self.$bvModal.hide("address-modal");
        })
        .catch(function (error) {
          const object = error.response;
          for (const property in object) {
            self.$bvToast.toast(object[property], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }

          self.is_loading = false;
       self.$bvModal.hide("address-modal");
        });
      self.getAddresss();
      self.updateAddress = false;
      self.add_new_address = false;

    },
    async selectDefultAddress(id) {
      var payload = {};
      var self = this;
      await this.$axios
        .post("/auth/user/setDefaultAddress/" + id)
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
            self.$bvToast.toast(object[property], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
        });
      self.getAddresss();
      self.$bvModal.hide("address-modal");
      self.$emit("changeAddress");
    },
    async getAddresss() {
      // this.isBusy = true;
      var self = this;
      await this.$axios
        .$get("/auth/user/getAddress")
        .then(function (response) {
          self.get_address = response;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
          // self.isBusy = false;
        });
    },
  },
};
</script>

<style>
.delete-ico:hover {
  cursor: pointer;
}

.shipping-mobile {
  height: calc(1.5em + 0.75rem + 9px);
  border-radius: 50px;
  font-size: 15px;
  padding: 18px 25px;
  margin-bottom: 18px;
  display: block;
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #f9f9f9;
  border: 1px solid #ced4da;
}

.shipping-mobile:focus-visible {
  border: 1px solid #ced4da !important;
  outline: none;
  background-color: #fff;
}

.shipping-country .vue-country-select {
  border-radius: 50rem !important;
  background-color: #f4f4f4;
  height: calc(2.5em + 0.75rem + -6px) !important;
  width: 100%;
  border: none !important;
}
.multi-address-card:hover {
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
  -webkit-box-shadow: 0 1px 2px -2px #00000029, 0 3px 6px #0000001f,
    0 5px 12px 4px #00000017;
  box-shadow: 0 1px 2px -2px #00000029, 0 3px 6px #0000001f,
    0 5px 12px 4px #00000017;
}
.selectedcard {
  border-color: var(--primary);
}
</style>
