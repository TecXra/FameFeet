<template>
  <div>
    <b-modal
      hide-footer
      centered
      header-class="ff-heading-modal darken-3"
      size="md"
      content-class="ff-Sign-modal"
      :id="'fansrequest' + offersIndex"
    >
      <template #modal-title
        ><i class="fi fi-rr-cloud-upload"></i> Upload Offer Content
      </template>
      <div class="px-5 py-2">
        <!-- Content Upload Form -->

        <b-form ref="formUpload">
          <b-form-group
            id="input-group-2"
            v-if="contentType === '5'"
            class="mb-2 upload-content-type"
            label-class="mb-0"
            label-size=""
          >
            <label for="" v-if="imageslength == 1"
              >Select {{ imageslength }} image
              <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>

              </label
            >
            <label for="" v-else>Select {{ imageslength }} images
              <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>

            </label>
            <b-form-file
              id=""
              class="upload-field"
              @change="onFileChange"
              multiple
              accept="image/jpeg"
            >
              <template slot="file-name" slot-scope="{ names }">
                <b-badge class="w-100" variant="dark">{{ names[0] }}</b-badge>
                <b-badge v-if="names.length > 1" variant="dark" class="ml-1">
                  + {{ names.length - 1 }} More files
                </b-badge>
              </template>
            </b-form-file>
            <b-form-invalid-feedback
              class="d-block"
              v-if="fileType"
            > Please upload only images.
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
            id="input-group-2"
            v-else
            class="mb-2 upload-field upload-content-type"
            label-class="mb-0"
            label-size=""
          >
          <template v-slot:label>
            Select a video:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
            <!-- <input type="file" accept="video/*" @change="handleFileUpload( $event )"/> -->
            <b-form-file
              id="video"
              size=""
              multiple
              accept="video/*"
              @change="handleFileUpload"
            ></b-form-file>
            <b-form-invalid-feedback
              class="d-block"
              v-if="videoType"
            > Please upload video in only MP4 format.
            </b-form-invalid-feedback>
            <b-form-invalid-feedback
              class="d-block"
              v-if="videoDuration"
            > Video duration should be 60 seconds or less.
            </b-form-invalid-feedback>

            <b-form-invalid-feedback
              class="d-block"
              v-else-if="videoSize"
            > Video size should be less than 10GB.
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
            <div class="col-12">
              <b-form-group
                id="input-group-title"
                class="mt-2"
                label="Title:"
                label-class="form-label"
                label-for="input-title"
              >
                <b-form-input
                  id="input-title"
                  v-model="title"
                  disabled
                  class="Famefeet-input-field"
                  placeholder="Title"
                >
                </b-form-input>
              </b-form-group>
            </div>
          </div>

          <b-form-group
            id="input-group-2"
            label-class="form-label"
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
              @click.prevent="postUpload(offersIndex)"
              v-if="contentType == 6"
              :disabled="(contentType == 6 && file == '') || ( videoSize  ) || videoType || videoDuration || !uploadForm.description "
            >
            <b-spinner small class="" v-show="isActiveSpinner"></b-spinner>  Submit</b-button
            >
            <b-button
              class="mt-3 ff-btn1-pink border-0"
              @click.prevent="postUpload(offersIndex)"
              v-else
              :disabled="fileType || (contentType == 5 && images.length !== imageslength) || !uploadForm.description "
            >
            <b-spinner small class="" v-show="isActiveSpinner"></b-spinner>  Submit</b-button
            >
          </div>
        </b-form>
        <!-- Content Upload End -->
      </div>
    </b-modal>
  </div>
</template>
<script>
import { required, minLength } from "vuelidate/lib/validators";
export default {
  computed: {},
  name: "uploadOffer",
  props: ["offersIndex", "contentType", "title", "imageslength"],

  data() {
    return {
      fileType: false,
      value: 0,
      file: "",
      videosrc: [],
      content_type: null,
      images: [],
      videoType: false,
      videoSize: false,
      fileName:'',
      videoDuration: false,
      maxUpload: 10000,
      maxDuration: 60,
      uploadDuration: 0,
      isActiveSpinner:false,
      // selected: 5,
      selectedCategory: null,
      uploadForm: {
        userName: "",
        title: "",
        description: "",
        price: null,
        category: "",
      },
    };
  },
  validations: {
    uploadForm: {
      title: { required },
      description: { required },
    },
  },

  methods: {
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      if (!files[0].type.match('image/*')) {
        this.fileType = true;
      } else { 
       this.fileType = false;
       // Proceed with creating an image
       this.createImage(files);
       }
      
     
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
      this.images.splice(index, 1);
      event.preventDefault();
    },

    // Video Upload
    handleFileUpload(e) {
      
      this.videosrc = [];
      this.file = e.target.files[0];
      this.fileName = e.target.files[0].name;
      let fileSizeMb = (this.file.size / 1048576).toFixed(2);
      //Checks
      this.videoType = false;
      this.videoSize = false;
      this.videoDuration = false;

      if(!this.file.type.match('video/*')){
        
        this.videoType = true;
      }
      else if(fileSizeMb > this.maxUpload){
        this.videoSize = true;
      }else{
        this.videoType = false;
        this.videoSize = false;
        this.videoDuration = true;
        this.previewVideo();
      }

    },
    previewVideo() {
      console.log('I have reached here')
      let video = document.getElementById("video-preview");

      let reader = new FileReader();
      console.log(video);
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
    async checkDuration(video){
      var self = this;
      console.log(video+' First Console');
      console.log(this.videosrc+' VideoSRC');
      var payload = {
        duration_payload : video,
      };
      let formData = new FormData();
      formData.append('duration_payload', video);
      formData.append('extension', this.fileName.split('.').pop());
      await this.$axios.post('checkVideoDuration', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
        ,onUploadProgress: function (progressEvent) {
          self.value = parseInt(
            Math.round((progressEvent.loaded / progressEvent.total) * 100)
          );
        }.bind(self),
      }).then(function (response) {
        if (response.data.isValidVideoDuration === false) {
           self.videoDuration = false;
           } else {
          self.videoDuration = true;
            }
        // if(response === 'small'){
        //   self.videoDuration = false;
        // }else{
        //   self.videoDuration = true;


        // }
        console.log(response);

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

    async postUpload(offerId) {
      this.isActiveSpinner= true;
      if (this.contentType === "5") {
        this.file_path = this.images;
      }
      if (this.contentType === "6") {
        if(!this.videoType && !this.videoDuration && !this.videoSize) {

          this.file_path = this.videosrc;
        }
      }
      if(this.file_path) {
        this.payload = {
          file_path: this.file_path,
          status: "upload",
          extension:this.fileName.split('.').pop()
        };
        console.log(this.payload);
        var self = this;
        await self.$axios
          .post("/auth/uploadOfferContent/" + offerId, self.payload, {
            onUploadProgress: function (progressEvent) {
              self.value = parseInt(
                Math.round((progressEvent.loaded / progressEvent.total) * 100)
              );
            }.bind(self),
          })
          .then(function (response) {
            self.$emit("contentPost", "temp_UploadForm");

            self.$bvToast.toast(response.data.message, {
              title: "Success",
              variant: "success",
              solid: true,
            });
            self.isActiveSpinner = false;
            self.$emit("getupdatedOffers", offerId);
          })
          .catch(function (error) {
            const object = error.response.data;
            self.$bvToast.toast(object.message, {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
            self.isActiveSpinner = false;
            self.file = "";
            self.images = [];
            self.$bvModal.hide("fansrequest" + offerId);
            // alert("fansrequest" + offerId);
          });
      }
      },
    // onOver() {
    // 	this.$refs.dropdown.visible = true;
    // },
    // onLeave() {
    // 	this.$refs.dropdown.visible = false;
    // },
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
}

.img-removebtn {
  margin-top: 2px;
}
</style>
