<template>
  <div>
    <b-modal
      hide-footer
      centered
      header-class="ff-heading-modal darken-3"
      size="lg"
      @show="setValues(itemid)"
      content-class="ff-Sign-modal"
      :id="'edit-single-item' + itemid"
    >
      <template #modal-title>
        <div class="d-flex">
          <i class="mr-2 fi fi-rr-shopping-bag-add"></i>
          Update Item
        </div>
      </template>
      <b-form>
        <div class="row">
          <div class="col-lg-6">
            <b-form-group
              id="input-group-title"
              label-class="form-label"
              label-for="input-title"
            >
            <template v-slot:label>
              Title:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
              <b-form-input
                id="input-title"
                placeholder="Title"
                maxlength="30"
                v-model="$v.itemData.title.$model"
                class="Famefeet-input-field"
                :state="titleValidateState('title')"
                aria-describedby="item-title"
              ></b-form-input>
              <b-form-invalid-feedback id="item-title"
                >Your title must be 6 to 30 characters .
              </b-form-invalid-feedback>
            </b-form-group>
          </div>
          <div class="col-lg-6">
            <InputPrice v-model="itemData.price"  :isRequired="true"></InputPrice>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6 mt-md-0 mt-3">
            <label for="ContentType">Quantity:
              <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
            </label>

            <div class="form-group">
              <the-mask
                placeholder="Enter Quantity"
                v-model="itemData.quantity"
                class="form-control Famefeet-input-field"
                type="text"
                :mask="['###']"
              />
            </div>
          </div>

          <div class="col-lg-6">
            <label for="ContentType">Weight (Ounces):
              <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
            </label>
            <div class="form-group mb-1">
              <the-mask
                placeholder="Enter Ounce"
                v-model="itemData.ounce"
                class="form-control Famefeet-input-field"
                type="text"
                :mask="['##']"
              />
            </div>
            <b-form-invalid-feedback
              id="discription-feed"
              class="d-block text-muted font-weight-bold"
              ><small>Weight of Full Package Must be between 0 and 13 OZ</small>
            </b-form-invalid-feedback>
          </div>
        </div>

        <b-form-group
          id=""
          class="mt-md-0 mt-3"
          label-class="form-label"
          label-for="input-description"
        >
        <template v-slot:label>
          Description:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
          <b-form-textarea
            rows="4"
            id="input-description"
            v-model="$v.itemData.description.$model"
            class="Famefeet-input-field scrollbar-none"
            :state="validateState('description')"
            aria-describedby="discription-feed"
          ></b-form-textarea>
          <b-form-invalid-feedback id="discription-feed"
            >Required field must be at least 15 characters.
          </b-form-invalid-feedback>
        </b-form-group>
      </b-form>
      <div class="text-center mb-2 ff-paragraph4">
        <button
          @click.once="editShopItems(itemid)"
          :disabled="
            isActiveSpinner == true ||
            !itemData.quantity ||
            itemData.quantity == 0 ||
            $v.itemData.description.$invalid ||
            $v.itemData.ounce.$invalid ||
            !itemData.ounce ||
            itemData.price < 1 || !changesMade
          "
          class="ff-btn1-pink px-3 py-2 text-uppercase mr-2 border-0"
        >
          <b-spinner small class="mr-2" v-show="isActiveSpinner"></b-spinner>
          <span>Update</span>
        </button>
        <!-- {{ selectedImgesQty }} -->
      </div>
    </b-modal>
  </div>
</template>
<script>
import { TheMask } from "vue-the-mask";
import InputPrice from "@/components/common/inputPrice";
import { required, minLength, between } from "vuelidate/lib/validators";
export default {
  computed: {
    selectedImgesQty: function () {
      if (this.images.length > 5) {
        this.hasError = true;
        // alert();
      } else {
        this.hasError = false;
      }
      return this.images.length;
    },
  },

  name: "uploadItem",
  components: { TheMask, InputPrice },
  props: [
    "itemid",
    "title",
    "Price",
    "Condition",
    "Quantity",
    "WeightOZ",
    "Description",
  ],
  data() {
    return {
      isActiveSpinner: false,
      hasError: false,
      optionsSocksWomen: [],
      optionsSocksMen: [],
      itemData: {
        price: 0,
        title: "",
        description: "",
        weight: 0,
        ounce: null,
        quantity: null,
        condition: "old",
        price: null,
        size: null,
      },
      changesMade: false,
      initialData:{
        price: 0,
        title: "",
        description: "",
        weight: 0,
        quantity: null,
      },
    };
  },

  validations: {
    itemData: {
      title: { required, minLength: minLength(6),
        trimmedMinLength: (value) => value.trim().length >= 6
       },
      description: { required, minLength: minLength(15),
        trimmedMinLength: (value) => value.trim().length >= 15
       },
      ounce: { required, between: between(0, 13) },
    },
  },
  watch: {
    'itemData.description'(newValue, oldValue) {
      if (newValue !== this.initialData.description) {
        this.changesMade = true;
      } else {
        this.changesMade = false;
      }
    },
    'itemData.price'(newValue, oldValue) {
      if (newValue !== this.initialData.price) {
        this.changesMade = true;
      } else {
        this.changesMade = false;
      }
    },
    'itemData.title'(newValue, oldValue) {
      if (newValue !== this.initialData.title) {
        this.changesMade = true;
      } else {
        this.changesMade = false;
      }
    },
    'itemData.ounce'(newValue, oldValue) {
      if (newValue !== this.initialData.ounce) {
        this.changesMade = true;
      } else {
        this.changesMade = false;
      }
    },
    'itemData.quantity'(newValue, oldValue) {
      if (newValue !== this.initialData.quantity) {
        this.changesMade = true;
      } else {
        this.changesMade = false;
      }
    },
  },
  methods: {
    setValues(id) {
      this.itemData.price = this.Price;
      this.initialData.price = this.Price;

      this.itemData.title = this.title;
      this.initialData.title = this.title;

      this.itemData.description = this.Description;
      this.initialData.description = this.Description;

      this.itemData.ounce = this.WeightOZ;
      this.initialData.ounce = this.WeightOZ;

      this.itemData.quantity = this.Quantity;
      this.initialData.quantity = this.Quantity;

    },
    async editShopItems(id) {
      this.isActiveSpinner = true;
      var payload = {
        title: this.itemData.title,
        description: this.itemData.description,
        quantity: this.itemData.quantity,
        price: this.itemData.price,
        ounce: this.itemData.ounce,
      };
      var self = this;
      await this.$axios
        .post("/auth/editShopItem/" + id, payload)
        .then(function (response) {
          self.$emit("getitems");
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
      self.isActiveSpinner = false;
      self.$bvModal.hide("edit-single-item" + id);
    },
    validateState(disc) {
      const { $dirty, $error } = this.$v.itemData[disc];
      return $dirty ? !$error : null;
    },

    titleValidateState(title) {
      const { $dirty, $error } = this.$v.itemData[title];
      return $dirty ? !$error : null;
    },
  },
};
</script>

<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}
</style>
