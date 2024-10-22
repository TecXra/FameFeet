<template>
  <b-modal hide-footer centered header-class="ff-heading-modal darken-3" content-class="ff-Sign-modal"
    :id="'send-offer' + offersIndex">
    <template #modal-title> Send Offer </template>
    <div class="p-5">
      <b-form>
        <b-form-group id="input-group-title" label-class="form-label" >
          <template v-slot:label>
            Title:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
          <b-form-input id="input-title" class="Famefeet-input-field" v-model="title"></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-price" label-class="form-label" >
          <template v-slot:label>
            Price($):
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
          <div class="form-group">
            <!-- <the-mask
              placeholder=""
              v-model="coins"
              class="form-control Famefeet-input-field"
              type="text"
              :mask="['###']"
            /> -->
            <InputPrice v-model="coins" class=""  :isRequired="true" :isShowLable="true"></InputPrice>
          </div>
          <!-- <b-form-input
            id="input-price"
            class="Famefeet-input-field"
            type="numbr"
            v-model="coins"
          ></b-form-input> -->
        </b-form-group>

        <b-form-group id="input-group-description"  label-class="form-label"
          >
          <template v-slot:label>
            Description:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
          <b-form-textarea rows="4" id="input-description" class="Famefeet-input-field scrollbar-none" v-model="description">
          </b-form-textarea>
        </b-form-group>

        <b-form-group >
          <template v-slot:label>
            Content Type:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
          <b-form-radio name="some-radios" value="5" v-model="content_type">Photos</b-form-radio>
          <b-form-radio name="some-radios" value="6" v-model="content_type">Videos</b-form-radio>
        </b-form-group>

        <div class="" v-if="content_type == 5">
          <b-form-select v-model="quantity" class="Famefeet-input-field">
            <template #first>
              <b-form-select-option :value="null" disabled>-- Number of photos --</b-form-select-option>0
            </template>
            <b-form-select-option :value="index + 1" v-for="(item, index) in 15" :key="item.index" v-text="index + 1">
            </b-form-select-option>
          </b-form-select>
        </div>
      </b-form>
    </div>
    <div class="text-center">
      <b-button class="ff-btn1-pink border-0" @click="sendOffer(offersIndex)" :disabled="isLoading || !title.trim() 
      || coins < 1 || !description.trim() || content_type === null || (content_type == 5 && quantity === null)">
        <span v-if="isLoading" class="spinner-border spinner-border-sm py-0" role="status" aria-hidden="true"></span>
            {{ isLoading ? 'Sending...' : 'Send' }}
      </b-button>

    </div>
  </b-modal>
</template>
<script>
import { TheMask } from "vue-the-mask";
import InputPrice from "@/components/common/inputPrice";
export default {
  name: "sendOffer",
  props: ["offersIndex"],
  components: { TheMask, InputPrice },

  data() {
    return {
      title: "",
      coins: 0.0,
      description: "",
      quantity: null,
      content_type: null,
      isLoading: false,
      // celebrity_id: ,
    };
  },
  methods: {
    async sendOffer(index) {
      this.isLoading = true;
      if (parseInt(this.content_type) == 6) {
        this.quantity = 1;
      }
      var payload = {
        title: this.title,
        coins: parseFloat(this.coins),
        description: this.description,
        quantity: this.quantity,
        content_type: parseInt(this.content_type),
        celebrity_id: this.offersIndex,
      };
      var self = this;
      await this.$axios
        .post("/auth/sendOffer", payload)
        .then(function (response) {
          self.isLoading = false;
          self.$root.$emit("bv::hide::modal", "send-offer" + index);
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
            })
          }
          self.$root.$emit("bv::hide::modal", "send-offer" + index);
        }).finally(() => {
          this.isLoading = false;
        });
      self.title = "";
      self.coins = 0.0;
      self.description = "";
      self.quantity = null;
      self.content_type = null;
    },
  },
};
</script>

<style lang="css" scoped></style>
