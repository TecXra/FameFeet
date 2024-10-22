<template>
  <b-modal
    hide-footer
    hide-header
    centered
    size="lg"
    @show="getContentPost(userid)"
    :id="'offers-fans' + userid"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <!-- @click="$bvModal.hide('information')" -->
    <section
      style="background-color: #f7f6f6; border-radius: 12px"
    >
      <div class="d-flex justify-content-end">
        <h4 class="famefeet-link-a mb-0" @click="$bvModal.show('information')">
          <i class="fi fi-sr-exclamation float-right"></i>
        </h4>
      </div>
      <div class="row">
        <div class="col-md-12">
          <b-tabs
            content-class=""
            align="center"
            nav-class="tabs-nav-link"
            active-nav-item-class="ff-tabs-link"
          >
            <b-tab
              title-link-class="ff-tablink-pro "
              @click="isShow_upload = false"
            >
              <template #title>
                <div
                  class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
                >
                  <!-- <i class="mr-0 mr-md-1 fi fi-rr-share"></i> -->
                  <span class="d-md-inline-block">My Content</span>
                </div>
              </template>
              <div class="row d-flex justify-content-center pre-scrollable">
                <div class="col">
                  <div class="text-center" v-if="is_show">
                    <b-spinner
                      variant="info"
                      style="width: 3rem; height: 3rem"
                      label="Spinning"
                    ></b-spinner>
                  </div>
                  <div class="px-3" v-else-if="posts_celebrity.length == 0">
                    <h4 class="text-center p-5">{{ "No Content found" }}</h4>
                  </div>
                  <div
                    class="card mb-3"
                    v-for="(post, index) in posts_celebrity"
                    :key="index"
                    v-else
                  >
                    <!-- {{ post }} -->
                    <div class="blog-slider">
                      <div
                        class="blog-slider__wrp swiper-wrapper"
                        v-if="post.content_type == '5'"
                      >
                        <div class="blog-slider__item swiper-slide d-flex m-0" style="overflow: hidden;">
                          <div class="blog-image__container p-2">
                          <div
                            class="blog-slider__img"
                            @click="show(index, post.media)"

                            :style="{
                          'background-image': post.media && post.media[0] ? 'url(' + post.media[0].AppURL + ')' : '',
                            }"
                          >
                            <div class="text-area">
                              <div class="text-block-centered33">
                                1 / {{ post.media.length }}
                              </div>
                            </div>
                          </div>
                        </div>
                          <div class="blog-slider__content ml-2 p-2">
                            <div class="blog-slider__title text-break">
                              {{ post.title }}
                            </div>
                            <div class="blog-slider__text">
                              <p class="text-break">{{ post.description }}</p>
                            </div>
                            <div class="mb-3">
                              <a
                                class="ff-btn1-pink"
                                @click="sharePost(post.id)"
                                ><i class="fa fa-share-alt-square mr-2"></i
                                >SHARE</a
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- videos -->
                      <div
                        class="blog-slider__wrp swiper-wrapper"
                        v-if="post.content_type == '6'"
                      >
                        <div class="blog-slider__item swiper-slide d-flex m-0" style="overflow: hidden;">
                          <div class="p-2">
                          <video
                            width="150px"
                            class=""
                            height="150px"
                            controls
                            preload="none"
                          >
                          <source
                              v-if="post.media && post.media[0] && post.media[0].AppURL"
                              :src="post.media[0].AppURL"
                                 type="video/mp4"
                                 />

                            <!-- <source
                              :src="post.media[0].AppURL"
                              type="video/mp4"
                            /> -->
                          </video>
                          </div>
                          
                          <!-- {{ post.id }} -->
                          <div class="blog-slider__content ml-2 p-2">
                            <div class="blog-slider__title text-break">
                              {{ post.title }}
                            </div>
                            <div class="blog-slider__text ">
                              <p class="text-break">{{ post.description }}</p>
                            </div>
                            <div class="mb-3">
                              <a
                                class="ff-btn1-pink"
                                @click="sharePost(post.id)"
                                ><i class="fa fa-share-alt-square mr-2"></i
                                >SHARE</a
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </b-tab>
            <b-tab
              title-link-class="ff-tablink-pro"
              @click="isShow_upload = true"
            >
              <template #title>
                <div
                  class="tabs-link-name d-flex flex-column flex-md-row align-items-center align-items-md-left"
                >
                  <!-- <i class="mr-0 mr-md-1 fi fi-rr-upload"></i> -->
                  <span class="d-md-inline-block">New Offer</span>
                </div>
              </template>
              <div>
                <div class="px-5 py-2">
                  <!-- Content Upload Form -->
                  <b-form ref="formUpload">
                    <b-form-group
                    >
                    <template v-slot:label>
                  Content Type
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
                      <b-form-radio-group
                        id="btn-radios-1"
                        v-model="selected"
                        :options="optionsRadio"
                        :state="inpState"
                        :aria-describedby="ariaDescribedby"
                        name="radios-btn-default"
                        buttons
                        button-variant="light rounded-pill mr-2"
                      ></b-form-radio-group>
                    </b-form-group>

                    <b-form-group
                      id="input-group-2"
                      label=""
                      v-if="selected === 5"
                      class="mb-2 upload-content-type"
                      label-class="mb-0"
                      label-size=""
                    >
                      <label for="">Select up to 15 images.
                        <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
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
                          <b-badge variant="dark" class="w-100">{{ names[0] }}</b-badge>
                          <b-badge
                            v-if="names.length > 1"
                            variant="dark"
                            class="ml-1"
                          >
                            + {{ names.length - 1 }} More files
                          </b-badge>
                        </template>
                      
                      </b-form-file>
                      <b-form-invalid-feedback v-if="isImageLimitExceeded" class="d-block text-danger">
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
                      id="input-group-2"
                      v-else
                      class="mb-2 upload-field upload-content-type"
                      label-class="mb-0"
                      label-size=""
                      label-for=""
                    >
                    <template v-slot:label>
                        Select a video 
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
                      <!-- <input type="file" accept="video/*" @change="handleFileUpload( $event )"/> -->
                      <b-form-file
                        id=""
                        size=""
                        v-model="file"
                        multiple
                        accept=".mp4"
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
                      <div
                        class="col-3"
                        v-for="(image, index) in images"
                        :key="index"
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
                      <div class="col-md-6">
                        <b-form-group
                          id="input-group-title"
                          class="mt-2"
                          label-class="form-label"
                          label-for="input-title"
                        >
                        <template v-slot:label>
                Title:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
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
                      <div class="col-md-6">
                        <InputPrice
                          v-model="price"
                          :status="image_status"
                          class="mt-2"
                           :isRequired="true"
                        ></InputPrice>
                      </div>
                    </div>

                    <b-form-group
                      id="input-group-2"
                      label-class="form-label">
                      <template v-slot:label>
            Description:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
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
                  </b-form>
                  <!-- Content Upload End -->
                </div>
              </div>
            </b-tab>
          </b-tabs>
        </div>
      </div>

      <div class="my-3 text-dark"></div>
      <div class="text-center pb-3">
        <b-button
          class="ff-btn1-pink py-2 px-3 border-0"
          @click="$bvModal.hide('offers-fans' + userid)"
          >Close</b-button
        >

        <b-button
          v-if="contenttype == 'offer' && isShow_upload"
          class="ff-blue-button py-2"
          @click.prevent="offerUpload()"
          :disabled="
             $v.uploadForm.title.$error ||
                isActiveSpinner == true ||
                !uploadForm.description ||
                videoType || videoDuration || videoSize ||
                (image_status === 'Locked' && price <= 0) ||
                (selected == 5 && images.length == 0) ||
                (selected == 5 && imageType) ||
                isImageLimitExceeded || 
                (selected == 6 && file == '')
                "
        >
          <b-spinner small class="mr-1" v-show="isActiveSpinner"></b-spinner>
          <span>Send</span></b-button
        >
      </div>
    </section>
    <b-modal
      hide-footer
      hide-header
      centered
      id="information"
      header-class="ff-heading-modal darken-3"
      content-class="ff-Sign-modal"
    >
      <section style="background-color: #f7f6f6; border-radius: 12px">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="mt-3">
              <p>
                Clicking <b>"share"</b> sends any of your posted content to a
                user for purchase. <b>Remember</b> only share to
                non-subscribers.
              </p>
              <p>
                Click <b>"upload"</b> to send <b>NEW</b> custom content to a
                user for purchase. You can upload to <b>subscribers</b> &
                <b>non-subscribers</b>!
              </p>
            </div>
          </div>
        </div>
        <div class="text-center pb-3">
          <b-button
            class="ff-btn1-pink mb-3 border-0 py-2 px-3"
            @click="$bvModal.hide('information')"
            >Close</b-button
          >
        </div>
      </section>
    </b-modal>
  </b-modal>
</template>

<script>
import { TheMask } from "vue-the-mask";
import InputPrice from "@/components/common/inputPrice";
import { required, minLength } from "vuelidate/lib/validators";
import "viewerjs/dist/viewer.css";
import loader from "@/components/common/loader";
import VueViewer from "v-viewer";
import Vue from "vue";
Vue.use(VueViewer);
export default {
  computed: {
    getPostImages: function () {
      var vm = this;
      return function (arry) {
        let postImages = [];
        for (let i = 0; i < arry.length; i++) {
          postImages.push(arry[i].AppURL);
        }
        return postImages;
      };
    },
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
    inpState() {
      if (this.selected == 6) {
        this.images = [];
        this.image_status = "Locked";
        this.$refs.fileinput.reset();
        this.uploadForm.title= "";
        this.price = "";
        this.uploadForm.description="";
      }
      if (this.selected == 5) {
        this.file = "";
        this.uploadForm.title= "";
        this.price = "";
        this.uploadForm.description="";
      }
    },
  },
  components: { loader, TheMask, InputPrice },
  name: "send-offer-fan",
  props: ["userid", "fanid"],

  data() {
    return {
      imageType: false,
      selectedFiles: [],
      isImageLimitExceeded: false,
      contenttype: "offer",
      posts_celebrity: [],
      is_show: true,
      isShow_upload: false,
      isActiveSpinner: false,
      value: 0,
      image_status: "Locked",
      file: "",
      videosrc: [],
      content_type: null,
      videoType: false,
      videoSize: false,
      videoDuration: false,
      maxUpload: 10000,
      maxDuration: 60,
      uploadDuration: 0,
      allCategories: [],
      categories_id: [],
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
        photos: [],
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
      title: { required,
         minLength: minLength(10),
        trimmedMinLength: (value) => value.trim().length >= 10
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
    // this.getContentPost();
  },
  methods: {
    uploadOffer() {
      this.$bvModal.hide("offers-fans" + this.userid);
      this.$emit("uploadcontentrequest");
    },
    async getContentPost(id) {
      var self = this;
      await this.$axios
        .$get("/auth/getAuthCelebrityPsotsForSharing/" + id)
        .then(function (response) {
          self.posts_celebrity = response;
          self.is_show = false;
        })
        .catch(function (error) {});
    },
    async sharePost(postid) {
      this.payload = {
        user_id: this.userid,
        post_id: postid,
      };
      var self = this;
      await this.$axios
        .post("/auth/sharePost", self.payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          console.log(response);
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
      self.$bvModal.hide("offers-fans" + self.userid);
    },

    show(index, img) {
      for (var i = 0; i < this.posts_celebrity.length; i++) {
        if (i == index) {
          this.$viewerApi({
            images: this.getPostImages(img),
          });
        }
      }
    },

    onFileChange(e) {
      
      this.isImageLimitExceeded = false;
            
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
    

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
        console.log('ture');
        this.isImageLimitExceeded = true;
      } else {
        this.isImageLimitExceeded = false;
        console.log('false');
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
      // console.log(this.uploadForm.photos.length);
      if( this.selectedFiles.length < 16){
        this.isImageLimitExceeded = false;
      }
      event.preventDefault();
    },

    // Video Upload
    handleFileUpload(e) {
      if(e.target?.files.length > 0){
      this.videosrc = [];
      this.file = e.target?.files[0];
      this.fileName = e.target?.files[0]?.name;
      let fileSizeMb = (this.file?.size / 1048576).toFixed(2);
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
      }else{
        this.videosrc = [];
      this.file = "";
      }
    },
    previewVideo() {
      let video = document.getElementById("video-preview");

      let reader = new FileReader();
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
        // alert(this.videosrc)
        this.file_path = this.videosrc;
      }
      this.payload = {
        title: this.uploadForm.title,
        description: this.uploadForm.description,
        content_type: this.selected,
        file_path: this.file_path,
        price: this.price,
        fan_id: this.fanid,
        // category_id: this.categories_id
      };
      // console.log(this.images);
      var self = this;
      await this.$axios
        .post("/auth/celebritySendOfferToFan", self.payload, {
          onUploadProgress: function (progressEvent) {
            this.value = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(this),
        })
        .then(function (response) {
          self.$emit("contentPost", "temp_UploadForm");
          self.$bvToast.toast("Content Uploaded", {
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
          self.uploadForm = {
            userName: "",
            title: "",
            description: "",
            price: null,
          };

          // self.login();
        });
      self.isActiveSpinner = false;
      self.$bvModal.hide("offers-fans" + self.userid);
      self.uploadForm.title = "";
      self.uploadForm.description = "";
      self.price = 0.0;
      self.categories_id = [];
      self.file = "";
      self.images = [];
    },
    onOver() {
      this.$refs.dropdown.visible = true;
    },
    onLeave() {
      this.$refs.dropdown.visible = false;
    },
  },
};
</script>

<style scoped>
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
.blog-slider__title {
  font-size: 18px;
  font-weight: 500;
  color: var(--primary);
}
/* .blog-slider__text {
  text
} */
.blog-slider__content {
  display: flex;
  justify-content: space-between;
  flex-direction: column;
}

.blog-slider__img {
  background-position: center !important;
  background-size: cover !important;
  background-repeat: no-repeat !important;
  width: 150px;
  flex-shrink: 0;
  height: 150px;
  overflow: hidden;
  position: relative;
}

.text-block-centered33 {
  position: absolute;
  background-color: rgba(0, 0, 0, 0.5);
  border-radius: 100%;
  padding: 8px 8px 8px 8px;
  font-size: 1rem;
  font-weight: 700;
  top: 62%;
  left: 50%;
  transform: translate(-50%, -100%);
  z-index: 200;
  font-weight: 700;
  color: aliceblue;
}
@media only screen and (max-width: 600px) {
  .blog-slider__img {
    background-position: center !important;
    background-size: cover !important;
    background-repeat: no-repeat !important;
    width: 150px;
    flex-shrink: 0;
    height: 150px;
    overflow: hidden;
  }
}

@media only screen and (max-width: 380px) {
  .blog-slider__item {
    display: block !important;
    text-align: center !important;
  }
  .blog-image__container{
    display: flex;
    justify-content: center
  }
}


</style>
