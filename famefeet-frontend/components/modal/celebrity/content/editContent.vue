<template>
  <div>
    <b-modal
      hide-footer
      centered
      header-class="ff-heading-modal darken-3"
      no-close-on-backdrop
      no-close-on-esc
      visible
      size="md"
      content-class="ff-Sign-modal"
      id="editContentForm-modal"
    >
      <template #modal-header="{ close }">
        <!-- Emulate built in modal header close button action -->
        <b-button size="sm d-none" variant="outline-danger" @click="close()">
          Close Modal
        </b-button>
        <h5><i class="fi fi-rr-edit"></i> Edit Content</h5>
      </template>
      <div class="px-5 py-2">
        <!-- Content Upload Form -->
        <b-form>
          <div class="row">
            <div class="col-12">
              <InputPrice
                v-model="uploadForm.price"
                class="mt-2 mb-2"
                :isRequired="false"
              ></InputPrice>
              <div class="text-danger mb-3" v-if="uploadForm.price <= 0">
                <small
                  >If no price is entered, this content will be unlocked
                  automatically and made available for free to all users.</small
                >
              </div>
            </div>
          </div>
          <b-form-group
            id="input-group-2"
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
              v-model="uploadForm.description"
              @blur="$v.uploadForm.description.$touch"
              class="Famefeet-input-field scrollbar-none"
            ></b-form-textarea>
            <b-form-invalid-feedback
              class="d-block"
              v-if="$v.uploadForm.description.$error"
              >Description is required
            </b-form-invalid-feedback>
          </b-form-group>

          <div class="text-center">
            <b-button
              class="mt-3 ff-btn1-pink border-0"
              @click.prevent="closeUpload()"
            >
              Close</b-button
            >

            <b-button
              class="mt-3 ff-btn1-pink border-0"
              @click.prevent="editUpload()"
              :disabled="$v.uploadForm.description.$error || !changesMade"
            >
              Update</b-button
            >
          </div>
        </b-form>
      </div>
    </b-modal>
  </div>
</template>
<script>
import { TheMask } from "vue-the-mask";
import InputPrice from "@/components/common/inputPrice";
import { required, minLength } from "vuelidate/lib/validators";
export default {
  props: ["editableData"],
  name: "editContent",
  components: { TheMask, InputPrice },

  data() {
    return {
      uploadForm: JSON.parse(JSON.stringify(this.editableData)),
      price: 0.0,
      images: [],
      selected: "photo",
      selectedCategory: null,
      changesMade: false,
      initialData:{
        price:0.0,
        description:""
      },
      optionsRadio: [
        { value: "photo", text: "Photos" },
        { value: "video", text: "Videos " },
      ],
    };
  },
  validations: {
    uploadForm: {
      title: { required },
      description: { required },
      price: { required, minLength: minLength(5) },
      category: { required },
    },
  },
  mounted() {
    this.initialData.price = this.uploadForm.price;
    this.initialData.description = this.uploadForm.description
  },
  watch: {
    'uploadForm.description'(newValue, oldValue) {
      if (newValue !== this.initialData.description) {
        this.changesMade = true;
      } else {
        this.changesMade = false;
      }
    },
    'uploadForm.price'(newValue, oldValue) {
      if (newValue !== this.initialData.price) {
        this.changesMade = true;
      } else {
        this.changesMade = false;
      }
    }
  },
  methods: {
    editUpload() {
      event.preventDefault();
      this.$emit("contentUpdate", this.uploadForm);
      // this.uploadForm.title = "";
      // this.uploadForm.price = "";
      // this.uploadForm.description = "";
      // this.selectedCategory = null;
    },
    closeUpload() {
      var isShow = false;
      this.$emit("modelshow", isShow);
    },
    // onFileChange(e) {
    //     var files = e.target.files || e.dataTransfer.files;
    //     if (!files.length) return;
    //     this.createImage(files);
    // },
    // createImage(files) {
    //     var vm = this;
    //     for (var index = 0; index < files.length; index++) {
    //         var reader = new FileReader();
    //         reader.onload = function (event) {
    //             const imageUrl = event.target.result;
    //             vm.images.push(imageUrl);
    //         };
    //         reader.readAsDataURL(files[index]);
    //     }
    // },
    // removeImage(index) {
    //     this.images.splice(index, 1);
    //     event.preventDefault();
    // },
    // onOver() {
    //     this.$refs.dropdown.visible = true;
    // },
    // onLeave() {
    //     this.$refs.dropdown.visible = false;
    // },
  },
};
</script>

<style>
.Famefeet-input-field option:hover {
  background-color: red !important;
}

.upload-content-type .custom-file-input:lang(en) ~ .custom-file-label::after {
  content: url("~/assets/images/svg/upload.svg");
  background-color: transparent;
  fill: white;
}

.upload-content-type .custom-file-input:lang(en) ~ .custom-file-label {
  border-radius: 50px;
}

.custom-file-label {
  border-radius: 1.5rem;
}

.img-removebtn {
  margin-top: 2px;
}
/* .content-dd-btn button {
    padding: 0px;
} */
</style>
