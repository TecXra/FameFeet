<template>
  <div>
    <b-modal
      hide-footer
      centered
      header-class="ff-heading-modal darken-3"
      size="lg"
      content-class="ff-Sign-modal"
      id="Sell-single-item"
    >
      <template #modal-title>
        <div class="d-flex">
          <i class="mr-2 fi fi-rr-shopping-bag-add"></i>
          Add new item
        </div>
      </template>
      <b-form>
        <div class="row">
          <div class="col-lg-6">
            <b-form-group
              id="input-group-title"
              label-class="form-label"
            >
            <template v-slot:label>
              Title:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
              <b-form-input
                id="input-title"
                placeholder="Title"
                maxlength="30"
                v-model="$v.singleStoreItem.title.$model"
                class="Famefeet-input-field"
                :state="titleValidateState('title')"
                aria-describedby="item-title"
              ></b-form-input>
              <b-form-invalid-feedback id="item-title"
                >Your title must be 6 to 30 characters .
              </b-form-invalid-feedback>
            </b-form-group>
          </div>
          <div class="col-lg-6 mb-3">
            <InputPrice v-model="price"  :isRequired="true"></InputPrice>
          </div>
        </div>

        <b-form-group
          id="input-group-2"
          class="upload-content-type"
          label-class="mb-0"
          label-size=""
        >
        <template v-slot:label>
          Select Maximum 5 images:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
          <b-form-file
            id=""
            class="upload-field"
            size=""
            @change="onFileChange"
            v-model="singleStoreItem.photo"
            multiple
            accept="image/jpeg, image/png, image/gif"
          >
            <template slot="file-name" slot-scope="{ names }">
              <b-badge variant="dark">{{ names[0] }}</b-badge>
              <b-badge v-if="names.length > 1" variant="dark" class="ml-1">
                + {{ names.length - 1 }} More files
              </b-badge>
            </template>
          </b-form-file>
          <b-form-invalid-feedback
            id="input-1-live-feedback"
            :class="{ 'd-block': hasError }"
            >{{ errorMessage }}
          </b-form-invalid-feedback>
        </b-form-group>

        <div class="row">
          <div
            class="col-3"
            v-for="(image, index) in images"
            :key="image.index"
          >
            <div class="single-img">
              <div
                class="bg-image"
                :style="{ background: `url(${image})` }"
              ></div>
              <div class="text-center">
                <button
                  class="btn img-removebtn border-0 shadow-none"
                  @click="removeImage(index)"
                >
                  <i class="fas fa fa-times"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <b-form-group >
              <template v-slot:label>
                Sock Size:
                  <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
              <b-form-select
                v-model="singleStoreItem.size"
                class="Famefeet-input-field bg-white"
                value-field="value"
                ref="file-input"
              >
                <b-form-select-option :value="null"
                  >Select</b-form-select-option
                >
                <b-form-select-option-group label="Women’s Sock Size">
                  <b-form-select-option
                    v-for="(item, index) in optionsSocksWomen"
                    :key="index"
                    :value="item.id"
                    :disabled="item.status === 0"
                    >{{ item.text }}
                  </b-form-select-option>
                </b-form-select-option-group>
                <b-form-select-option-group label="Men’s Sock Size">
                  <b-form-select-option
                    v-for="(item, index) in optionsSocksMen"
                    :key="index"
                    :value="item.id"
                    :disabled="item.status === 0"
                    >{{ item.text }}
                  </b-form-select-option>
                </b-form-select-option-group>
              </b-form-select>
            </b-form-group>
          </div>
          <div class="col-lg-6">
            <label for="Condition">Condition:</label>
            <b-form-select
              id="Condition"
              v-model="singleStoreItem.condition"
              :options="optionsCondition"
              class="mb-3 Famefeet-input-field"
              value-field="item"
              text-field="name"
            ></b-form-select>
          </div>
          <div class="col-lg-6">
            <label for="ContentType">Quantity:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
            </label>
            <!-- <b-form-select
              id="ContentType"
              v-model="singleStoreItem.quantity"
              class="mb-3 Famefeet-input-field"
              value-field="item"
              text-field="name"
            >
              <template #first>
                <b-form-select-option :value="null"
                  >Select
                </b-form-select-option>
                <b-form-select-option
                  :value="item"
                  v-for="(item, index) in 10"
                  :key="index"
                  >{{ item }}
                </b-form-select-option>
              </template>
            </b-form-select> -->
            <div class="form-group">
              <the-mask
                placeholder="Enter Quantity"
                v-model="singleStoreItem.quantity"
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
              <b-form-input
                class="Famefeet-input-field"
                v-model="singleStoreItem.ounce"
                type="number"
                pattern="[0-9]*([.][0-9]+)?"
                title="Please enter a valid number"
                @input="validateInput"
              ></b-form-input>
            </div>
            <b-form-invalid-feedback
              id="discription-feed"
              class="d-block text-muted font-weight-bold"
              ><small>Weight of Full Package Must be between 0 and 13 OZ</small>
            </b-form-invalid-feedback>
          </div>
          <!-- <div class="col-lg-6">
            <b-form-group
              id="input-group-2"
              label="Weight (Pounds)"
              label-for="input-2"
            >
              <b-form-input
                id="input-2"
                v-model="singleStoreItem.weight"
                placeholder="Enter Pound"
                required
                type="number"
                class="Famefeet-input-field"
              ></b-form-input>
              <b-form-invalid-feedback
                id="discription-feed"
                class="d-block text-muted"
                >Weight of Full Package.
              </b-form-invalid-feedback>
            </b-form-group>
          </div> -->
        </div>

        <b-form-group
          id=""
          label-class="form-label"
          class="mt-3 mt-md-0"
        >
        <template v-slot:label>
          Description:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
          <b-form-textarea
            rows="4"
            id="input-description"
            v-model="$v.singleStoreItem.description.$model"
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
          @click.once="postItem()"
          :disabled="
            selectedImgesQty > 5 ||
            price < 1 ||
            images.length == 0 ||
            !singleStoreItem.title ||
            !singleStoreItem.size ||
            !singleStoreItem.quantity ||
            singleStoreItem.quantity == 0 ||
            ((singleStoreItem.weight || !singleStoreItem.ounce) &&
              (!singleStoreItem.weight || singleStoreItem.ounce) &&
              (!singleStoreItem.weight || !singleStoreItem.ounce)) ||
            $v.singleStoreItem.description.$invalid ||
            $v.singleStoreItem.ounce.$invalid ||
            $v.singleStoreItem.title.$invalid ||
            isActiveSpinner == true
          "
          class="ff-btn1-pink px-3 py-2 text-uppercase mr-2 border-0"
        >
          <b-spinner small class="mr-2" v-show="isActiveSpinner"></b-spinner>
          <span>Post</span>
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

  data() {
    return {
      errorMessage: "You can upload only 5 images.",
      isActiveSpinner: false,
      hasError: false,
      price: 0,
      images: [],
      optionsCondition: [{ item: "old", name: "Worn Socks" }],
      optionsSocksWomen: [],
      optionsSocksMen: [],
      singleStoreItem: {
        // userName: "",
        title: "",
        description: "",
        // date: null,
        photo: [],
        weight: 0,
        ounce: null,
        quantity: null,
        condition: "old",
        price: null,
        size: null,

        // type: null,
      },
    };
  },

  validations: {
    singleStoreItem: {
      title: { required, minLength: minLength(6),trimmedMinLength: (value) => value.trim().length >= 6 },
      description: { required, minLength: minLength(15),trimmedMinLength: (value) => value.trim().length >= 15 },
      ounce: { required, between: between(0.1, 13) },
    },
  },
  mounted() {
    this.socksSize();
    // if (this.images.length == 5) {
    //   alert();
    //   this.hasError = true;
    // }
  },
  methods: {
    validateInput() {
      // Remove any non-digit characters except decimal point
      this.singleStoreItem.ounce = this.singleStoreItem.ounce.replace(
        /[^0-9.]/g,
        ""
      );

      // Ensure there is only one decimal point
      const decimalCount = this.singleStoreItem.ounce.split(".").length - 1;
      if (decimalCount > 1) {
        const parts = this.singleStoreItem.ounce.split(".");
        this.singleStoreItem.ounce = parts[0] + "." + parts.slice(1).join("");
      }
    },

    validateState(disc) {
      const { $dirty, $error } = this.$v.singleStoreItem[disc];
      return $dirty ? !$error : null;
    },

    onFileChange(e) {
      // console.log(e.target.files);
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;

      // Validate file types
      const validImageTypes = ["image/jpeg", "image/png", "image/gif"];
      for (let i = 0; i < files.length; i++) {
        if (!validImageTypes.includes(files[i].type)) {
          this.hasError = true;
          this.errorMessage = "Invalid file format. Please select only images.";
          return;
        }
      }
      // Validate maximum number of images
      const maxImages = 5;
      if (files.length > maxImages) {
        this.hasError = true;
        this.errorMessage = `You can upload only ${maxImages} images.`;
        return;
      }
      // Reset error if all validations pass
      this.hasError = false;
      this.createImage(files);



      //   console.log(e.target.files);
      // var files = e.target.files || e.dataTransfer.files;
      // if (!files.length) return;
      // this.createImage(files);
      // console.log(files);
    },
    createImage(files) {
      var vm = this;
      for (var index = 0; index < files.length; index++) {
        var reader = new FileReader();
        reader.onload = function (event) {
          const imageUrl = event.target.result;
          vm.images.push(imageUrl);
        };
        reader.readAsDataURL(files[index]);
      }
    },
    removeImage(index) {
      // Remove the filename from the input field and files
      this.images.splice(index, 1);
      this.singleStoreItem.photo.splice(index, 1);
      event.preventDefault();
    },
    async postItem() {
      this.isActiveSpinner = true;
      this.payload = {
        title: this.singleStoreItem.title,
        description: this.singleStoreItem.description,
        file_path: this.images,
        quantity: this.singleStoreItem.quantity,
        price: this.price,
        condition: this.singleStoreItem.condition,
        socks_size_id: this.singleStoreItem.size,
        weight: this.singleStoreItem.weight,
        ounce: this.singleStoreItem.ounce,
      };
      var self = this;
      await this.$axios
        .post("/auth/createShopItem", self.payload)
        .then(function (response) {
          self.$bvToast.toast("Item added successfully.", {
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
      self.isActiveSpinner = false;
      self.$bvModal.hide("Sell-single-item");
      self.price = 0;
      self.singleStoreItem = {
        title: "",
        quantity: "",
        description: "",
        condition: null,
        price: null,
      };
      self.images = [];
      self.$emit("add");
    },
    titleValidateState(title) {
      const { $dirty, $error } = this.$v.singleStoreItem[title];
      return $dirty ? !$error : null;
    },
    async socksSize() {
      var self = this;
      await this.$axios
        .$get("/auth/getAllSocksSizes")
        .then(function (response) {
          self.optionsSocksMen = response.man_socks_size;
          self.optionsSocksWomen = response.women_socks_size;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    // 	postItem() {
    // 		var temp_UploadItems = {
    // 			userName: this.loggedInUser.username,
    // 			title: this.singleStoreItem.title,
    // 			description: this.singleStoreItem.description,
    // 			date: new Date(),
    // 			photo: "",
    // 			quantity: this.singleStoreItem.quantity,
    // 			type: this.selected,
    // 			price: this.price,
    // 			condition: this.singleStoreItem.condition,
    // 		};
    // 	// alert(JSON.stringify(this.singleStoreItem));
    // 	this.$emit('itemPost', temp_UploadItems);
    // 	this.$dtoast.pop({
    // 		preset: "success",
    // 		heading: `Success`,
    // 		content: `Item added successfully`,
    // 	});

    // }
  },
};
</script>

<style>
.upload-content-type .custom-file-input:lang(en) ~ .custom-file-label::after {
  content: url("~/assets/images/svg/upload.svg");
  background-color: transparent;
  fill: white;
}
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
