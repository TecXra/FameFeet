<template>
  <form
    action=""
    class="text-center profile-input mt-4"
    method="post"
    enctype="multipart/form-data"
  >
    <label for="fileToUpload">
      <div v-if="isImageUploading" class="pt-4">
        <b-spinner label="Spinning"></b-spinner>
      </div>
      <div
        v-else
        class="profile-pic-updated"
        v-bind:style="{
          'background-image': 'url(' + user.avatarURL + ')',
        }"
      >
        <!-- <span><i class="mr-1 fas fa fa-camera"></i>Upload</span> -->
        <div class="profile-change-link">
          <i class="mr-1 fas fa fa-camera"></i>Upload Picture
        </div>
      </div>
     
    </label>
    <b-form-file
      id="fileToUpload"
      name="fileToUpload"
      v-show="false"
      class="upload-field"
      @change="onFileChange"
      v-model="photos"
      accept="image/jpeg, image/png, image/gif"
    ></b-form-file>
  </form>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  name: "updatePicture",

  data() {
    return {
      remoteUrl: null,
      photos: [],
      isImageUploading: false,
    };
  },
  methods: {
    // Profile Picture Update
    onFileChange(e) {
      this.isImageUploading = true
      const selectedImage = e.target.files[0];
      this.createBase64Image(selectedImage);
    },
    createBase64Image(fileObject) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.avatar = e.target.result;
        this.uploadImage();
      };
      reader.readAsDataURL(fileObject);
    },
    async uploadImage() {
      const { avatar } = this;
      await this.$axios
        .post("/auth/updateAvatar", { avatar })
        .then((response) => {
          this.remoteUrl = response.data.data[0].avatarURL;
          // console.log(this.remoteUrl,"remoteurl")
          this.$store.commit(
            "updateProfilePicture",
            this.remoteUrl
          );
          this.isImageUploading = false;
          this.$dtoast.pop({
            preset: "success",
            heading: `Success`,
            content: response.data.message,
          });
        })
        .catch((err) => {
          return new Error(err.message);
        });
    },
  },
};
</script>

<style>
.profile-change-link {
  position: absolute !important;
  bottom: 0px;
  width: 100%;
  border-radius: 0px 0px 8px 8px;
  font-size: 14px !important;
  background-color: rgba(0, 0, 0, 0.5) !important;
}
</style>
