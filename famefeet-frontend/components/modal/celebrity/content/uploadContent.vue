<template>
  <div>
    <b-modal
      hide-footer
      centered
      header-class="ff-heading-modal darken-3"
      size="md"
      content-class="ff-Sign-modal"
      id="uploadContentForm-modal"
    >
      <template #modal-title v-if="contenttype == 'offer'"
        ><i class="fi fi-rr-cloud-upload"></i> <span>Send Offer to Fan</span>
      </template>
      <template #modal-title v-else
        ><i class="fi fi-rr-cloud-upload"></i> <span>Add new Content</span>
      </template>
      <div class="px-5 py-2">
        <!-- Content Upload Form -->
        <!-- {{ uploadForm }} -->
        <b-form ref="formUpload">
          <b-form-group>
            <template v-slot:label>
              Content Type
              <span style="font-size: 8px; color: red"
                ><b-icon icon="asterisk" class="mb-2"></b-icon
              ></span>
            </template>
            <template v-slot:default>
              <b-form-radio-group
                id="content-type-radios"
                v-model="selected"
                :options="optionsRadio"
                @change="inpState"
                aria-describedby="content-type-radios"
                name="radios-btn-default"
                buttons
                button-variant="light rounded-pill mr-2"
              ></b-form-radio-group>
            </template>
          </b-form-group>

          <b-form-group
            label=""
            v-if="selected === 5"
            class="upload-content-type"
            label-class="mb-0"
            label-size=""
          >
            <label for=""
              >Select up to 15 images.
              <span style="font-size: 8px; color: red"
                ><b-icon icon="asterisk" class="mb-2"></b-icon
              ></span>
            </label>
            <b-form-file
              id=""
              class="upload-field"
              @change="onFileChange"
              multiple
              v-model="uploadForm.photos"
              accept="image/jpeg"
              ref="fileinput"
            >
              <template slot="file-name" slot-scope="{ names }">
                <b-badge id="dark" variant="dark">{{ names[0] }}</b-badge>
                <b-badge
                  id="dark"
                  v-if="names.length > 1"
                  variant="dark"
                  class="ml-1"
                >
                  + {{ names.length - 1 }} More files
                </b-badge>
              </template>
            </b-form-file>
            <b-form-invalid-feedback
              v-if="isImageLimitExceeded"
              class="d-block text-danger"
            >
              You can only select up to 15 images.
            </b-form-invalid-feedback>

            <b-form-invalid-feedback class="d-block" v-if="imageType">
              Please select only images.
            </b-form-invalid-feedback>

            <!-- <b-form-invalid-feedback class="d-block text-info"
              >If you upload a single image, you will be shown an option whether
              you want to keep it locked or not, Otherwise, the first image of
              the bundle will be unlocked. <br />
              Also, if anyone can buy your subscription then all your content is
              unlocked.</b-form-invalid-feedback
            > -->
          </b-form-group>

          <b-form-group
            v-else
            class="upload-field upload-content-type"
            label-class="mb-0"
            label-size=""
            label-for=""
          >
            <template v-slot:label>
              Select a video
              <span style="font-size: 8px; color: red"
                ><b-icon icon="asterisk" class="mb-2"></b-icon
              ></span>
            </template>
            <!-- <input type="file" accept="video/*" @change="handleFileUpload( $event )"/> -->
            <b-form-file
              id="video"
              size=""
              ref="video_upload"
              multiple
              accept="video/*"
              @change="handleFileUpload"
              @loadedmetadata="logDuration"
            ></b-form-file>
            <b-form-invalid-feedback class="d-block" v-if="videoType">
              Please upload proper video.
            </b-form-invalid-feedback>

            <b-form-invalid-feedback class="d-block" v-else-if="videoSize">
              Video size should be less than 10GB.
            </b-form-invalid-feedback>
            <b-form-invalid-feedback class="d-block" v-if="videoDuration">
              Video duration should be 60 seconds or less.
            </b-form-invalid-feedback>
            <video id="video-preview" controls v-show="file != ''" />
            <b-progress
              height="10px"
              :value="value"
              show-progress
              class="mt-2"
              v-show="file != ''"
            >
            </b-progress>
          </b-form-group>

          <div class="row" v-if="selectedImgesQty == 1">
            <div class="col-12">
              <div class="mb-0 pt-2 d-flex align-items-center">
                <div class="d-inline">
                  <input
                    type="checkbox"
                    v-model="image_status"
                    class="switch_2"
                    true-value="Unlocked"
                    false-value="Locked"
                  />
                </div>
                <div class="ml-2">
                  {{ image_status }}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-3" v-for="(image, index) in images" :key="index">
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
            <div class="col-md-6">
              <b-form-group id="input-group-title" label-class="form-label">
                <template v-slot:label>
                  Title:
                  <span style="font-size: 8px; color: red"
                    ><b-icon icon="asterisk" class="mb-2"></b-icon
                  ></span>
                </template>
                <b-form-input
                  id="input-title"
                  v-model="uploadForm.title"
                  @blur="$v.uploadForm.title.$touch"
                  class="Famefeet-input-field"
                  placeholder="Title"
                >
                </b-form-input>
                <b-form-invalid-feedback
                  class="d-block"
                  v-if="$v.uploadForm.title.$error"
                  >Title is required minimum 10 characters.
                </b-form-invalid-feedback>
              </b-form-group>
            </div>
            <div class="col-md-6 mb-3">
              <InputPrice
                v-model="price"
                :status="image_status"
                :isRequired="true"
              ></InputPrice>
            </div>
          </div>

          <b-form-group label-class="form-label">
            <template v-slot:label>
              Description:
              <span style="font-size: 8px; color: red"
                ><b-icon icon="asterisk" class="mb-2"></b-icon
              ></span>
            </template>
            <b-form-textarea
              rows="3"
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
          <div v-if="contenttype != 'offer'">
            <b-form-group label="Category:" label-class="form-label">
              <vue-tags-input
                v-model="tag"
                :tags="tags"
                :autocomplete-items="filteredItems"
                placeholder="add category"
                :add-only-from-autocomplete="true"
                @tags-changed="(newTags) => (tags = newTags)"
              />
            </b-form-group>
            <!-- <b-form-select class="Famefeet-input-field" v-model="selectedCategory" :options="options">
						</b-form-select> -->
          </div>
          <div class="text-center" v-if="contenttype == 'offer'">
            <b-button
              class="mt-3 ff-btn1-pink border-0"
              @click.prevent="offerUpload()"
              :disabled="$v.uploadForm.title.$error || price <= 0"
            >
              <b-spinner
                small
                class="mr-1"
                v-show="isActiveSpinner"
              ></b-spinner>
              <span>Send</span></b-button
            >
          </div>
          <div class="text-center" v-if="contenttype != 'offer'">
            <b-button
              class="mt-3 ff-btn1-pink border-0"
              @click.prevent="postUpload()"
              :disabled="
                $v.uploadForm.title.$error ||
                isActiveSpinner == true ||
                !uploadForm.description ||
                videoType ||
                videoDuration ||
                videoSize ||
                (image_status === 'Locked' && price <= 0) ||
                (selected == 5 && images.length == 0) ||
                (selected == 5 && imageType) ||
                isImageLimitExceeded ||
                (selected == 6 && file == '')
              "
            >
              <b-spinner
                small
                class="mr-2"
                v-show="isActiveSpinner"
              ></b-spinner>
              <span>Submit</span></b-button
            >
            <!-- {{ selectedImgesQty }} -->
          </div>
        </b-form>
        <!-- Content Upload End -->
      </div>
    </b-modal>
  </div>
</template>
<script>
import { TheMask } from "vue-the-mask";
import InputPrice from "@/components/common/inputPrice";
import { required, minLength } from "vuelidate/lib/validators";
export default {
  name: "uploadContent",
  components: { TheMask, InputPrice },
  props: ["contenttype", "fanid"],

  data() {
    return {
      selectedFiles: [],
      isActiveSpinner: false,
      value: 0,
      image_status: "Locked",
      file: "",
      videoType: false,
      imageType: false,
      videoSize: false,
      videoDuration: false,
      maxUpload: 10000,
      durationPayload: "",
      videosrc: [],
      content_type: null,
      allCategories: [],
      categories_id: [],
      fileName: "",
      tag: "",
      tags: [],
      price: 0.0,
      images: [],
      selected: 5,
      selectedCategory: null,
      optionsRadio: [
        { value: 5, text: "Photos" },
        { value: 6, text: "Videos " },
      ],
      options: [
        { value: null, text: "Select Category" },
        { value: "ASMR", text: "ASMR" },
        { value: "BDMS", text: "BDMS" },
      ],
      uploadForm: {
        userName: "",
        title: "",
        photos: [],
        description: "",
        price: null,
        category: "",
      },
      isImageLimitExceeded: false,
    };
  },
  validations: {
    uploadForm: {
      title: {
        required,
        minLength: minLength(10),
        trimmedMinLength: (value) => value.trim().length >= 10,
      },
      description: { required },
      price: { required, minLength: minLength(5) },
      category: { required },
    },
  },

  mounted() {
    this.getCategories();
    if (this.images.length > 1) {
      this.image_status = "Locked";
    }
  },

  watch: {
    image_status(newValue, oldValue) {
      if (newValue === "Unlocked") {
        this.price = 0.0;
      }
    },
  },
  methods: {
    inpState() {
      if (this.selected == 6) {
        this.images = [];
        this.image_status = "Locked";
        this.$refs.fileinput.reset();
        this.uploadForm.title = "";
        this.price = "";
        this.uploadForm.description = "";
        this.tags = [];
        if (this.$refs.video_upload) {
          this.$refs.video_upload.reset();
        }
      }
      if (this.selected == 5) {
        this.file = "";
        this.uploadForm.title = "";
        this.price = "";
        this.uploadForm.description = "";
        this.tags = [];
        if (this.$refs.video_upload) {
          this.$refs.video_upload.reset();
        }
      }
    },

    onFileChange(e) {
      this.isImageLimitExceeded = false;
      this.imageType = false;

      // var files = e.target.files || e.dataTransfer.files;
      // if (!files.length) return;

      // // Check if the selected files are images
      // const isImageType = this.checkIfImageType(files);
      // if (!isImageType) {
      //   // Display error message or take appropriate action for non-image files
      //   this.imageType = true;
      //   return;
      // }

      // // Clear previously selected files
      // this.selectedFiles = [];

      // // Create images and update selected files
      // this.createImage(files);
      // this.selectedFiles = [...this.selectedFiles, ...files];

      // // Check if the number of selected images exceeds the limit
      // if (this.selectedFiles.length > 15) {
      //   this.isImageLimitExceeded = true;
      // }
      // old code
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      // Check if the selected files are images
      const isImageType = this.checkIfImageType(files);
      if (!isImageType) {
        // Display error message or take appropriate action for non-image files
        this.imageType = true;
        return;
      }

      this.createImage(files);
      this.selectedFiles = [...this.selectedFiles, ...files];
      console.log(this.selectedFiles.length, "hello");

      // Check if the number of selected images exceeds the limit
      if (this.selectedFiles.length > 15) {
        this.isImageLimitExceeded = true;
      } else {
        this.isImageLimitExceeded = false;
      }
    },

    checkIfImageType(files) {
      // Define allowed image file types
      const allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];

      for (let i = 0; i < files.length; i++) {
        if (!allowedImageTypes.includes(files[i].type)) {
          return false; // Non-image file found
        }
      }
      return true; // All files are images
    },

    logDuration() {
      console.log("duration", this.$refs.videoPlayer.duration);
    },
    createImage(files) {
      var vm = this;
      for (var index = 0; index < files.length; index++) {
        var reader = new FileReader();
        console.log(reader);

        reader.onload = function (event) {
          const imageUrl = event.target.result;
          vm.images.push(imageUrl);
        };
        reader.readAsDataURL(files[index]);
      }
    },
    removeImage(index) {
      this.images.splice(index, 1);
      this.uploadForm.photos.splice(index, 1);
      this.selectedFiles.splice(index, 1);
      if (this.selectedFiles.length < 16) {
        this.isImageLimitExceeded = false;
      }
      event.preventDefault();
    },

    // Video Upload
    handleFileUpload(e) {
      if (e.target?.files.length > 0) {
        this.videosrc = [];
        this.videoType = false;
        this.file = e.target.files[0];
        this.fileName = e.target.files[0].name;
        // this.checkDuration(e.target.files[0]);
        let fileSizeMb = (this.file.size / 1048576).toFixed(2);
        //Checks
        if (!this.file.type.match("video/*")) {
          this.videoType = true;
        }
        if (fileSizeMb > this.maxUpload) {
          this.videoSize = true;
        }
        if (!this.videoType && !this.videoSize) {
          this.videoType = false;
          this.videoSize = false;
          this.videoDuration = true;
          this.previewVideo();
        }
      } else {
        this.videosrc = [];
        this.file = "";
      }
    },
    previewVideo() {
      console.log("I have reached here");
      let video = document.getElementById("video-preview");

      let reader = new FileReader();
      // console.log(video);
      console.log("reader", reader);

      reader.readAsDataURL(this.file);
      var vm = this;

      reader.addEventListener("load", function () {
        video.src = reader.result;
        vm.assignVideosrc(video.src);
        vm.checkDuration(video.src);

        // alert(video.src)

        // this.videosrc = reader.result;
      });
    },

    assignVideosrc(src) {
      this.videosrc.push(src);
    },

    async checkDuration(video) {
      var self = this;
      console.log(video + " First Console");
      console.log(this.videosrc + " VideoSRC");
      var payload = {
        duration_payload: video,
      };
      let formData = new FormData();
      formData.append("duration_payload", video);
      formData.append("extension", this.fileName.split(".").pop());
      await this.$axios
        .post("checkVideoDuration", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
          onUploadProgress: function (progressEvent) {
            self.value = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(self),
        })
        .then(function (response) {
          if (response.data.isValidVideoDuration === false) {
            self.videoDuration = false;
          } else {
            self.videoDuration = true;
          }
        })
        .catch(function (error) {
          console.log(error);
          const object = error.response.data;
          // for (const property in object) {
          //   self.$bvToast.toast(object[property][0], {
          //     title: "Warning",
          //     variant: "warning",
          //     solid: true,
          //   });
          // }
          // self.login();
        });
    },

    async getCategories() {
      // this.isBusy = true;
      var self = this;
      await this.$axios
        .$get("/getAllCategories")
        .then(function (response) {
          self.allCategories = response;
        })
        .catch(function (error) {
          // self.isBusy = false;
        });
    },
    async postUpload() {
      this.isActiveSpinner = true;
      this.categories_id = [];
      for (var i = 0; i < this.tags.length; i++) {
        var payload = this.tags[i].id;
        this.categories_id.push(payload);
      }
      if (this.selected === 5) {
        this.file_path = this.images;
      }
      if (this.selected === 6) {
        // alert(this.videosrc)
        this.file_path = this.videosrc;
      }
      this.payload = {
        title: this.uploadForm.title,
        description: this.uploadForm.description,
        content_type: this.selected,
        file_path: this.file_path,
        price: this.price,
        category_id: this.categories_id,
        extension: this.fileName.split(".").pop(),
      };
      console.log(this.payload);
      var self = this;
      await this.$axios
        .post("/auth/createPost", self.payload, {
          onUploadProgress: function (progressEvent) {
            self.value = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(self),
        })
        .then(function (response) {
          self.$emit("contentPost", "temp_UploadForm");
          // self.$ref.video_upload.reset();
          self.$bvToast.toast("Content Uploaded Successfully!", {
            title: "Success",
            variant: "success",
            solid: true,
          });
          window.location.reload();
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
          self.uploadForm = {
            userName: "",
            title: "",
            description: "",
            price: null,
            video: null,
          };
          // self.login();
        });

      self.isActiveSpinner = false;
      self.$bvModal.hide("uploadContentForm-modal");
      self.uploadForm.title = "";
      self.uploadForm.description = "";
      self.price = 0.0;
      self.categories_id = [];
      self.file = "";
      self.images = [];
      self.value = 0;
    },
    async offerUpload() {
      this.isActiveSpinner = true;
      this.categories_id = [];
      for (var i = 0; i < this.tags.length; i++) {
        var payload = this.tags[i].id;
        this.categories_id.push(payload);
      }
      if (this.selected === 5) {
        this.file_path = this.images;
      }
      if (this.selected === 6) {
        alert(this.videosrc);
        this.file_path = this.videosrc;
      }
      this.payload = {
        title: this.uploadForm.title,
        description: this.uploadForm.description,
        content_type: this.selected,
        file_path: this.file_path,
        price: this.price,
        fan_id: this.fanid,
      };
      var self = this;
      await this.$axios
        .post("/auth/celebritySendOfferToFan", self.payload, {
          onUploadProgress: function (progressEvent) {
            self.value = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(self),
        })
        .then(function (response) {
          self.$emit("contentPost", "temp_UploadForm");
          self.$bvToast.toast("Content Uploaded Successfully!", {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.uploadForm = {
            userName: "",
            title: "",
            filePath: "",
            description: "",
            price: null,
          };
        })
        .catch(function (error) {
          const object = error.response.data;
          self.$bvToast.toast(object[property][0], {
            title: "Warning",
            variant: "warning",
            solid: true,
          });

          // self.login();
        });

      self.isActiveSpinner = false;
      self.$bvModal.hide("uploadContentForm-modal");
      self.uploadForm.title = "";
      self.uploadForm.description = "";
      self.price = 0.0;
      self.categories_id = [];
      self.file = "";
      self.images = [];
      self.value = 0;
    },
    onOver() {
      this.$refs.dropdown.visible = true;
    },
    onLeave() {
      this.$refs.dropdown.visible = false;
    },
  },
  computed: {
    filteredItems() {
      return this.allCategories.filter((i) => {
        return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
      });
    },
    selectedImgesQty: function () {
      if (this.images.length > 1) {
        this.image_status = "Locked";
      }
      return this.images.length;
    },
  },
};
</script>

<style>
#video-preview {
  width: 100%;
  margin-top: 24px;
  border-radius: 10px;
}

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
  padding-right: 3.5rem;
  white-space: unset;
}
.form-file-text {
  overflow: hidden;
  width: 100%;
}
.img-removebtn {
  margin-top: 2px;
}
#dark {
  width: 100%;
}

.invalid-feedback {
  margin-top: 0.5rem !important;
}
</style>
