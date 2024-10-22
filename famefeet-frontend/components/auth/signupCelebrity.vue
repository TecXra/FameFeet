<template>
  <div class="ff-login-area">
    <div class="right-side px-0">
      <div class="form-area py-5">
        <div class="login-wrapper">
          <h2 class="login-title mb-5">Signup Celebrity</h2>
          <b-form action="#!">
            <b-form-group>
              <!-- <b-tooltip
                class="signup-tooltip"
                :show.sync="showTooltip"
                target="example-input-1"
                placement="top"
              >
                We
                <strong>recommend</strong> to use your Real Name if you’re well
                known.
              </b-tooltip> -->
              <b-form-input
                id="username-input"
                name="username"
                maxlength="20"
                class="Famefeet-input-field mb-2"
                v-model="$v.celebForm.user_name.$model"
                :state="validateUsernameState"
                aria-describedby="username-live-feedback"
                placeholder="Username *"
                required
                 @keyup="isUsernameAvailable($v.celebForm.user_name.$model)"
              ></b-form-input>
              <p class="text-danger mb-0" v-show="usernameAvailable != null && !usernameAvailable">
                <strong>·</strong> Username already taken.
              </p>
              <b-form-invalid-feedback id="username-live-feedback">
                <!-- Required field must be at least 6 to 20
                characters. -->
                <template v-if="!$v.celebForm.user_name.minLength">
                     Username must be at least 6 characters long.
                </template>
                <template v-else-if="!$v.celebForm.user_name.regex">
                     Please use a valid username (alphanumeric and underscores only).
                </template>
                <!-- <template v-else>
                  Required field must be between 6 and 20 characters.
                </template> -->
              </b-form-invalid-feedback>
            </b-form-group>

            <!-- Real name -->
            <b-form-group>
              <b-form-input
                id="fullname-input"
                name="fullname"
                maxlength="25"
                class="Famefeet-input-field mb-2"
                v-model="$v.celebForm.full_name.$model"
                :state="FullNameValidateState('full_name')"
                aria-describedby="fullname-live-feedback"
                @input="checkExtraSpace()"
                placeholder="Real name *"
                required
              ></b-form-input>
              <b-form-invalid-feedback id="fullname-live-feedback">
                <!-- Required field must be at least 6 to 20
                characters. -->
                <template v-if="!$v.celebForm.user_name.minLength">
                     Full name must be at least 6 characters long.
                </template>
                <template v-else>
                  Required field must be between 6 and 30 characters.
                </template>
              </b-form-invalid-feedback>
            </b-form-group>

            <!-- Email -->
            <b-form-group>
              <b-input-group>
                <b-form-input
                  id="email"
                  v-model.trim="$v.celebForm.email.$model"
                  required
                  :state="emailValidateState('email')"
                  type="email"
                  name="email"
                  placeholder="Email Address *"
                  @input="removeSpaces"
                />
              </b-input-group>
            </b-form-group>
            <!-- Password -->
            <b-form-group id="password">
              <b-input-group>
              <b-form-input
                id="password"
                v-model="$v.celebForm.password.$model"
                :state="passValidateState('password')"
                aria-describedby="password-live-feedback"
                :type="showPassword ? 'text' : 'password'"
                class="Famefeet-input-field mb-2 password-fields-signup"
                placeholder="Password *"
                required
              ></b-form-input>
              <b-input-group-append>
                <b-button class="show-password-button"
                @click="showPassword = !showPassword" 
                size="sm" >
                  <b-icon class="mr-2" :icon="showPassword?'eye-fill':'eye-slash-fill'">
                  </b-icon>
               </b-button>
              </b-input-group-append>
              <b-form-invalid-feedback id="password-live-feedback"
                >Your password must be 8 characters
                long</b-form-invalid-feedback
              >
            </b-input-group>
            </b-form-group>
            <!-- Conf Password -->
            <b-form-group id="passwordConfirmation">
              <b-input-group>
              <b-form-input
              :type="showConfirmPassword ? 'text' : 'password'"
                v-model="$v.celebForm.password_confirmation.$model"
                :state="confPassValidateState('password_confirmation')"
                aria-describedby="input-4-live-feedback"
                class="Famefeet-input-field mb-2 password-fields-signup" 
                id="Conf-password"
                placeholder="Confirm Password *"
                required
              ></b-form-input>
              <b-input-group-append>
                <b-button class="show-password-button"
                @click="showConfirmPassword = !showConfirmPassword" 
                size="sm" >
                  <b-icon class="mr-2" :icon="showConfirmPassword?'eye-fill':'eye-slash-fill'">
                  </b-icon>
               </b-button>
              </b-input-group-append>
              <b-form-invalid-feedback id="input-4-live-feedback"
                >Please make sure your passwords match</b-form-invalid-feedback
              >
            </b-input-group>
            </b-form-group>
            <div class="row">
              <div class="col-3 col-lg-2 pr-0">
                <vue-country-code
                  @onSelect="onSelect"
                  id="country-code"
                  class
                  defaultCountry="us"
                  disabled
                  :preferredCountries="['vn', 'us', 'gb']"
                ></vue-country-code>
              </div>
              <div class="col-9 col-lg-10">
                <div class="form-group">
                  <the-mask
                    id="phone-number"
                    placeholder="Phone Number *"
                    class="form-control"
                    type="text"
                    v-model="celebForm.mobile"
                    :mask="[selectedContryDialCode + ' (###) ###-####']"
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6 pr-1">
                <!-- <b-form-group id="state-name">
                    <b-form-input
                      id="state-name"
                      class="Famefeet-input-field mb-2"
                      placeholder="State"
                      v-model="celebForm.state"
                    ></b-form-input>
                </b-form-group>-->
                <b-form-group>
                  <b-form-select
                    v-model="celebForm.state"
                    class="file-select-bv"
                    id="state-name"
                    :options="state_Options"
                    value-field="text"
                  ></b-form-select>
                </b-form-group>
              </div>
              <div class="col-6 pl-1">
                <div class="form-group">
                  <the-mask
                    id="zip-code"
                    placeholder="Zip Code *"
                    class="form-control"
                    type="text"
                    :mask="['#####']"
                    v-model="celebForm.zipcode"
                  />
                </div>
                <span v-if="celebForm.zipcode ? celebForm.zipcode.length !== 5 : false" class="text-danger">Zip code must be 5 digits</span>
              </div>
            </div>
            <div class="row">
              <div class="col-4 pr-1">
                <b-form-select
                  id="date-of-birth-day"
                  v-model="dob.birth_day"
                  class="mb-3 file-select-bv"
                >
                  <template #first>
                    <b-form-select-option :value="null" disabled
                      >- Day -</b-form-select-option
                    >
                  </template>
                  <b-form-select-option
                    v-for="item in 31"
                    :value="item"
                    :key="item.index"
                    >{{ item + 0 }}</b-form-select-option
                  >
                </b-form-select>
              </div>

              <div class="col-4 px-1">
                <b-form-select
                  id="date-of-birth-month"
                  v-model="dob.birth_month"
                  class="mb-3 file-select-bv"
                >
                  <template #first>
                    <b-form-select-option :value="null" disabled
                      >- Month -</b-form-select-option
                    >
                  </template>
                  <b-form-select-option
                    v-for="item in 12"
                    :value="item"
                    :key="item.index"
                    >{{ item + 0 }}</b-form-select-option
                  >
                </b-form-select>
              </div>

              <div class="col-4 pl-1">
                <b-form-select
                  id="date-of-birth-year"
                  v-model="dob.birth_year"
                  class="mb-3 file-select-bv"
                >
                  <template #first>
                    <b-form-select-option :value="null" disabled
                      >- Year -</b-form-select-option
                    >
                  </template>
                  <b-form-select-option
                    v-for="(item, index) in reversdata"
                    :value="item"
                    :key="index"
                    >{{ item }}</b-form-select-option
                  >
                </b-form-select>
              </div>
            </div>
            <div class="form-group">
              <input
                type="text"
                name="referral"
                id="referral"
                v-model="celebForm.referral"
                class="form-control"
                placeholder="(Optional) Referral Code"
              />
            </div>
            <div class="row">
              <div class="col">
                <div class="row">
                  <!-- Front ID Upload-->
                  <div class="col-2"></div>
                  <div class="col-12">
                    <!-- Input Field Hide -->
                    <b-form-group
                      label="Front ID"
                      class="mb-0 upload-content-type"
                      label-class="mb-0 text-center lable-for-slect"
                      label-size
                    >
                      <b-form-file
                        v-model="file_one"
                        ref="pickImage"
                        class="upload-field"
                        @change="onFileChangeFront"
                        v-show="false"
                        accept="image/jpeg, image/png, image/gif"
                      ></b-form-file>
                    </b-form-group>
                    <!-- Dumy Image -->
                    <div
                      class="upload-id-card"
                      @click="clickToSelectImage()"
                      :style="{ background: `url(/images/png/front.png)` }"
                      v-if="!imagesId.length"
                      v-b-tooltip.hover
                    ></div>
                    <!-- Uploded Image -->
                    <div
                      class
                      v-for="(image, index) in imagesId"
                      :key="image.index"
                    >
                      <div class="single-img position-relative">
                        <div
                          class="upload-id-card"
                          :style="{ background: `url(${image})` }"
                        ></div>
                        <div class="text-center" style="height: 0">
                          <button
                            class="btn img-removebtn border-0 shadow-none signup-image-remove"
                            @click="removeFrontImage(index)"
                          >
                            <i class="fas fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="row">
                  <!-- Selfie with ID Upload -->
                  <div class="col-12">
                    <!-- Input Field Hide -->
                    <b-form-group
                      label="Selfie with ID"
                      class="mb-0 upload-content-type"
                      label-class="mb-0 text-center lable-for-slect"
                      label-size
                    >
                      <b-form-file
                        ref="pickImage2"
                        v-model="file_two"
                        class="upload-field"
                        @change="onFileChangeSelfe"
                        v-show="false"
                        accept="image/jpeg, image/png, image/gif"
                      ></b-form-file>
                    </b-form-group>
                    <!-- Dumy Image -->
                    <div
                      class="upload-id-card"
                      @click="clickToSelectSelfeImage()"
                      :style="{ background: `url(/images/png/self.png)` }"
                      v-if="!imagesSelfe.length"
                      v-b-tooltip.hover
                    ></div>
                    <!-- Uploded Image -->
                  </div>
                  <div
                    class="col-12"
                    v-for="(image, index) in imagesSelfe"
                    :key="image.index"
                  >
                    <div class="single-img position-relative">
                      <div
                        class="upload-id-card"
                        :style="{ background: `url(${image})` }"
                      ></div>
                      <div class="text-center" style="height: 0">
                        <button
                          class="btn img-removebtn border-0 shadow-none signup-image-remove"
                          @click="removeSelfeImage(index)"
                        >
                          <i class="fas fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <a
                @click="showInformation()"
                id="verifytext"
                class="forgot-password-link"
              >
                To verify your identity/age, please upload a government issued
                ID and a selfie with that same ID. These will always remain
                secure.
              </a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <a @click="showInformation()" class="ff-alink2"
                >Why am I being asked for this?</a
              >
            </div>

            <b-form-checkbox
              id="checkbox-1"
              v-model="acceptedTerms"
              size="sm"
              class="mt-1"
              name="checkbox-1"
              value="true"
            >
              I agree to the
              <a @click="goToPage('/terms')" class="ff-alink2"
                >Terms & Conditions</a
              >
              and the
              <a @click="goToPage('/privacy')" class="href-text ff-alink2"
                >privacy policy.</a
              >
            </b-form-checkbox>
            <div class="d-flex justify-content-between align-items-center">
              <b-button
                type="submit"
                class="mt-2 btn login-btn rounded-pill"
                variant="ff-variant-pink"
                :disabled="isActiveSpinner ||
                    celebForm.state === '' ||
                    celebForm.zipcode.length !== 5 ||
                    celebForm.user_name === '' ||
                    celebForm.full_name === '' ||
                    celebForm.email === '' ||
                    celebForm.password === '' ||
                    celebForm.password_confirmation === '' ||
                    celebForm.mobile === '' ||
                    file_one.length === 0 ||
                    file_two.length === 0 ||
                    !dob.birth_day ||
                    !dob.birth_month ||                 
                    !dob.birth_year ||
                    !acceptedTerms  ||
                    usernameAvailable != null && !usernameAvailable 
                  "
                @click.prevent="onSubmitClick()"
              >
                <b-spinner
                  small
                  class="mr-2"
                  v-show="isActiveSpinner"
                ></b-spinner>
                <span>Sign Up</span>
              </b-button>
              <div class="ml-3">
              <a @click="goToPage('/signin')" class="ff-alink2"
                >Already have an Account?</a
              >
              </div>
            </div>
          </b-form>
        </div>
      </div>
    </div>
    <WayDoText :textInfo="wayDoText"></WayDoText>
  </div>
</template>
<script>
import { TheMask } from "vue-the-mask";
import WayDoText from "@/components/modal/auth/information";
import { required, email, minLength, sameAs } from "vuelidate/lib/validators";
const regex = (pattern) => {
  return value => !value || pattern.test(value);
};
export default {
  components: { TheMask, WayDoText },
  name: "signupCelebrity",
  data() {
    return {
      showTooltip: true,
      usernameAvailable: null,
      isActiveSpinner: false,
      year: null,
      file_one: [],
      file_two: [],
      imagesId: [],
      imagesSelfe: [],
      selectedFile: null,
      acceptedTerms: false,
      calculatedYear: null,
      state_Options: [],
      dob: {
        birth_day: null,
        birth_month: null,
        birth_year: null,
      },
      date_of_birth: "",
      selectedContryDialCode: null,
      wayDoText:
        "For legal reasons, we need to verify you are of legal age and your identify. All information is secure.",
      celebForm: {
        state: "",
        zipcode: "",
        user_name: "",
        full_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        mobile: "",
        referral: "",
        dob: "",
        front_id: "",
        self_with_id: "",
      },
      showPassword:false,
      showConfirmPassword:false,
    };
  },
  validations: {
    dob: {
      birth_day: { required },
      birth_month: { required },
      birth_year: { required },
    },
    celebForm: {
      full_name: { required, minLength: minLength(6),  },
      user_name: { required, minLength: minLength(6), regex: regex(/^[a-zA-Z0-9_]{6,20}$/) },
      email: { required, email },
      password: { required, minLength: minLength(8) },
      password_confirmation: { required, sameAsPassword: sameAs("password") },
      mobile: { required },
    },
  },
  computed: {
    validateUsernameState: function () {
      if (this.validateState("user_name") != null) {
        if (!this.validateState("user_name")) {
          return false;
        } else {
          if (this.usernameAvailable) {
            return true;
          } else {
            return false;
          }
        }
      }
      return null;
    },
    reversdata: function () {
      var vm = this;
      var element = null;
      var options = [];
      for (let index = 1; index <= 83; index++) {
        element = vm.calculatedYear + index;
        options.push(element);
      }
      return options.reverse();
    },
  },
  mounted() {
    this.getStateList();
    const currentYear = new Date().getFullYear();
    const previousYear = currentYear - 101;
    this.calculatedYear = previousYear;
    this.year = new Date().getFullYear();
  },
  methods: {
    async isUsernameAvailable(username) {
      if (this.validateState("user_name")) {
        // this.isUsernameAvailableLoader = true;
        this.payload = { username: this.celebForm.user_name };
        var self = this;
        await this.$axios
          .post("/auth/isUsernameAvailable", self.payload)
          .then(function (response) {
            if (response.data == 0) {
              self.usernameAvailable = false;
            } else {
              self.usernameAvailable = true;
            }
            // self.isUsernameAvailableLoader = false;
          })
          .catch(function (error) {
            // self.$bvToast.toast(object[property][0], {
            //   title: "Warning",
            //   variant: "warning",
            //   solid: true,
            // });
          });
      }
    },
    checkExtraSpace()
    {
      this.celebForm.full_name = this.celebForm.full_name.trim();
      // console.log();
      // console.log(this.celebForm.full_name.trim()[0]);
      // console.log(this.celebForm.full_name.trim().length);
      // this.celebForm.full_name.trim().length == 0
      // [0] === " "
    },
    goToPage(page) {
      // this.$router.push(page);
      const absolutePath = this.$router.resolve(page).href;
      window.open(absolutePath, '_blank');
    
    },
    validateState(user_name) {
      const { $dirty, $error } = this.$v.celebForm[user_name];
      return $dirty ? !$error : null;
    },
    // Front ID
    clickToSelectImage() {
      this.$refs.pickImage.$el.childNodes[0].click();
    },
    onFileChangeFront(e) {
      this.selectedFile = event.target.files[0];
      var files = e.target.files || e.dataTransfer.files;
      this.createFrontImage(files);
    },
    createFrontImage(files) {
      var self = this;
      var reader = new FileReader();
      reader.onload = function (event) {
        const imageUrlfront = event.target.result;
        // console.log(imageUrlfront);
        self.imagesId.push(imageUrlfront);
      };
      reader.readAsDataURL(files[0]);
    },
    removeFrontImage(index) {
      console.log(this.file_one);
      this.imagesId.splice(index);
      this.file_one = [];
    },
    // Sefle With ID
    clickToSelectSelfeImage() {
      this.$refs.pickImage2.$el.childNodes[0].click();
    },
    onFileChangeSelfe(e) {
      var files = e.target.files || e.dataTransfer.files;
      this.createSelfeImage(files);
    },
    createSelfeImage(files) {
      var self = this;
      var reader = new FileReader();
      reader.onload = function (event) {
        const imageUrlSelfe = event.target.result;
        self.imagesSelfe.push(imageUrlSelfe);
      };
      reader.readAsDataURL(files[0]);
    },
    removeSelfeImage(index) {
      this.imagesSelfe.splice(index);
      this.file_two = [];
    },
    showInformation() {
      this.$root.$emit("bv::show::modal", "information");
    },
    onSelect({ name, iso2, dialCode }) {
      this.selectedContryDialCode = dialCode;
    },
    validateState(user_name) {
      const { $dirty, $error } = this.$v.celebForm[user_name];
      return $dirty ? !$error : null;
    },
    passValidateState(password) {
      const { $dirty, $error } = this.$v.celebForm[password];
      return $dirty ? !$error : null;
    },
    emailValidateState(email) {
      const { $dirty, $error } = this.$v.celebForm[email];
      return $dirty ? !$error : null;
    },
    FullNameValidateState(full_name) {
      const { $dirty, $error } = this.$v.celebForm[full_name];
      return $dirty ? !$error : null;
    },
    removeSpaces() {
      this.$v.celebForm.email.$model = this.$v.celebForm.email.$model.replace(
        /\s/g,
        ""
      );
      // if (this.$v.fandata.email.$model.includes(" ")) {
      //   this.showEmailError = true;
      // } else {
      //   this.showEmailError = false;
      // }
    },
    confPassValidateState(password_confirmation) {
      const { $dirty, $error } = this.$v.celebForm[password_confirmation];
      return $dirty ? !$error : null;
    },
    async getStateList() {
      var self = this;
      await this.$axios
        .get("/getAllStates")
        .then(function (response) {
          self.state_Options = response.data;
          self.celebForm.state = self.state_Options[0].text;
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
    async onSubmitClick() {
      if (this.celebForm.user_name.length < 6) {
        this.$bvToast.toast(
          "The username must be between 6 and 20 characters long.",
          {
            title: "Warning",
            variant: "warning",
            solid: true,
          }
        );
        return;
      }
      if (this.acceptedTerms == false) {
        this.$bvToast.toast(
          "Please read the Terms & Conditions and privacy policy carefully before Sign up.",
          {
            title: "Warning",
            variant: "warning",
            solid: true,
          }
        );
        return;
      }
      this.isActiveSpinner = true;
      if (
        this.dob.birth_year != null &&
        this.dob.birth_month != null &&
        this.dob.birth_day != null
      ) {
        this.date_of_birth =
          this.dob.birth_year +
          "-" +
          this.dob.birth_month +
          "-" +
          this.dob.birth_day;
      } else {
        this.date_of_birth = "";
      }

      this.payload = {
        username: this.celebForm.user_name,
        full_name: this.celebForm.full_name,
        email: this.celebForm.email,
        password: this.celebForm.password,
        confirm_password: this.celebForm.password_confirmation,
        phone_number: this.selectedContryDialCode + this.celebForm.mobile,
        date_of_birth: this.date_of_birth,
        used_referral_code: this.celebForm.referral,
        front_id_pic: this.imagesId[0],
        back_id_pic: this.imagesSelfe[0],
        state: this.celebForm.state,
        zipcode: this.celebForm.zipcode,
      };
      var self = this;
      await this.$axios
        .post("/auth/registerCelebrityUser", self.payload)
        .then(function (response) {
          self.$bvToast.toast("Registered Successfuly.", {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.login();
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
    },
    async login() {
      self = this;
      try {
        await this.$auth.loginWith("local", {
          data: {
            email: this.payload.email,
            password: this.payload.password,
          },
        });
        self.$router.push("/celebrity/settings/profile");
      } catch (e) {
        const object = e.response.data;
        for (const property in object) {
          self.$bvToast.toast(object[property][0], {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        }
      }
    },
  },
};
</script>

<style lang="css" scoped>
#verifytext:hover {
  text-decoration: none;
  color: #919aa3;
}

.ff-login-area {
  height: 100vh;
}

.ff-login-area .left-side {
  background-color: var(--primary);
  height: 100vh;
}

/* .ff-login-area .right-side {} */

.ff-login-area .form-area {
  height: 100vh;
  overflow-y: scroll;
  display: flex;
  justify-content: center;
}

.brand-wraper {
  padding: 5rem;
}

.brand-wraper .logo {
  height: 90px;
}

.brand-wraper .intro-title {
  font-size: 30px;
  font-weight: 500;
  margin-bottom: 18px;
  color: #fff;
}

.brand-wraper .intro-text {
  font-size: 16px;
  line-height: 1.29;
  color: #ffffff;
}

.intro-section-footer {
  margin-top: 35px;
}

.intro-section-footer p {
  font-size: 14px;
  color: #f6f6f6;
  margin-bottom: 0;
}

.id-upload-field .custom-file-input:lang(en) ~ .custom-file-label::after {
  content: url("~/assets/images/svg/upload.svg");
  background-color: transparent;
  fill: white;
  padding-top: 15px;
  height: auto;
}

.id-upload-field .custom-file-label {
  min-height: 55px !important;
  padding: 15px 24px 19px !important;
  border-radius: 50px;
  background-color: #f4f4f4;
  border: 0;
}

.upload-id-card {
  background-position: center !important;
  background-size: cover !important;
  background-repeat: no-repeat !important;
  padding-top: 100%;
  position: relative;
  margin-top: 3px;
  border-radius: 10px;
}

.signup-image-remove {
  position: absolute;
  top: 1px;
  right: 1px;
  color: white;
}

.signup-image-remove:hover {
  color: #fff;
  outline: 2px solid #fff;
  border-radius: 50%;
  outline-offset: -7px;
}

@media only screen and (max-width: 600px) {
  .login-wrapper {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }
}

@media only screen and (max-width: 992px) {
  .ff-login-area .left-side {
    background-color: var(--primary);
    height: 25vh;
  }
  .ff-login-area {
    height: auto;
  }
  .ff-login-area .form-area {
    height: auto;
    overflow-y: unset;
  }
}
</style>
