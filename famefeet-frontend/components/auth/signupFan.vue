<template>
  <div class="ff-login-area">
    <div class="right-side px-0">
      <div class="form-area py-5">
        <div class="login-wrapper">
          <h2 class="login-title">Signup Fan</h2>
          <!-- <nav class="social-login-links pb-4">
            <a href="#!" class="social-login-link rounded-pill">
              <img src="~/assets/images/svg/google.svg" alt="google logo" />
              Continue with Google
            </a>
          </nav> -->
          <SocialLogin></SocialLogin>

          <h6 class="social-login-title">OR</h6>
          <!-- Form-area -->
          <!-- @keydown.space="(event) => event.preventDefault()" -->

          <b-form class="">
            <b-form-group>
              <!-- <b-tooltip
                class="signup-tooltip"
                :show.sync="showTooltip"
                target="example-input-1"
                placement="top"
              >
                We <strong>recommend</strong> to use your Real Name if
                you’re well known.
              </b-tooltip> -->
              <b-form-input
                id="username"
                name="example-input-1"
                maxlength="20"
                class="Famefeet-input-field mb-2"
                v-model="$v.fandata.user_name.$model"
                :state="validateUsernameState"
                placeholder="Username *"
                required
                @keyup="isUsernameAvailable($v.fandata.user_name.$model)"
              ></b-form-input>
              <!-- <b-form-invalid-feedback v-show="!$v.fandata.user_name.required">
                <strong>·</strong> Required field must be at least 6 to 25 characters.
              </b-form-invalid-feedback>
              <b-form-invalid-feedback v-show="!$v.fandata.user_name.username">
                <strong>·</strong> Can not use space and special characters.
              </b-form-invalid-feedback> -->
              <p class="text-danger mb-0" v-show="usernameAvailable != null && !usernameAvailable">
                <strong>·</strong> Username already taken.
              </p>

              <b-form-invalid-feedback id="username-live-feedback">
                <!-- Required field must be at least 6 to 20
                characters. -->
                <template v-if="!$v.fandata.user_name.minLength">
                     Username must be at least 6 characters long.
                </template>
                <template v-else-if="!$v.fandata.user_name.regex">
                     Please use a valid username (alphanumeric and underscores only).
                </template>
                <!-- <template v-else-if="fandata.user_name.length < 6">
                  Required field must be between 6 and 20 characters.
                </template> -->
              </b-form-invalid-feedback>


            </b-form-group>
            <!-- Email -->
            <b-form-group>
              <b-input-group>
                <b-form-input
                  id="email"
                  v-model.trim="$v.fandata.email.$model"
                  :state="emailValidateState('email')"
                  required
                  type="email"
                  name="email"
                  placeholder="Email Address *"
                  @input="removeSpaces"
                />
              </b-input-group>
            </b-form-group>
            <!-- Password -->
            <b-form-group>
              <b-input-group>
              <b-form-input
                id="password"
                v-model="$v.fandata.password.$model"
                :state="passValidateState('password')"
                aria-describedby="input-password-live-feedback"
                class="Famefeet-input-field mb-2 password-fields-signup"
                placeholder="Password *"
                :type="showPassword ? 'text' : 'password'"
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
              <b-form-invalid-feedback id="input-password-live-feedback"
                >Your password must be 8 characters long
              </b-form-invalid-feedback>
            </b-input-group>
            </b-form-group>
           
            <!-- Conf Password -->
            <b-form-group id="input-group-3">
              <b-input-group>
              <b-form-input
              :type="showConfirmPassword ? 'text' : 'password'"
                v-model="$v.fandata.password_confirmation.$model"
                :state="ConfPassValidateState('password_confirmation')"
                aria-describedby="input-conf-password"
                class="Famefeet-input-field mb-2 password-fields-signup"
                id="Conf-password"
                placeholder="Confirm Password *"
                required
              >
              </b-form-input>
              <b-input-group-append>
                <b-button class="show-password-button"
                @click="showConfirmPassword = !showConfirmPassword" 
                size="sm" >
                  <b-icon class="mr-2" :icon="showConfirmPassword?'eye-fill':'eye-slash-fill'">
                  </b-icon>
               </b-button>
              </b-input-group-append>
             
              <b-form-invalid-feedback id="input-conf-password"
                >Please make sure your passwords match
              </b-form-invalid-feedback>
            </b-input-group>
            </b-form-group>
            <div class="row">
              <div class="col-3 col-lg-2 pr-0">
                <vue-country-code
                  id="country-code"
                  @onSelect="onSelect"
                  class=""
                  defaultCountry="us"
                  disabled
                  :preferredCountries="['vn', 'us', 'gb']"
                >
                </vue-country-code>
              </div>
              <div class="col-9 col-lg-10">
                <div class="form-group">
                  <!-- {{selectedContryDialCode}} -->
                  <the-mask
                    id="phone-number"
                    placeholder="Phone Number *"
                    class="form-control"
                    v-model="fandata.mobile"
                    type="text"
                    :mask="[selectedContryDialCode + ' (###) ###-####']"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 pr-1">
                <b-form-select
                  id="date-of-birth-day"
                  v-model="dob.birth_day"
                  class="mb-3 file-select-bv"
                >
                  <!-- This slot appears above the options from 'options' prop -->
                  <template #first>
                    <b-form-select-option :value="null" disabled
                      >- Day -</b-form-select-option
                    >
                  </template>

                  <!-- These options will appear after the ones from 'options' prop -->
                  <b-form-select-option
                    v-for="item in 31"
                    :value="item"
                    :key="item.index"
                    >{{ item + 0 }}
                  </b-form-select-option>
                </b-form-select>
              </div>
              <div class="col-4 px-1">
                <b-form-select
                  id="date-of-birth-month"
                  v-model="dob.birth_month"
                  class="mb-3 file-select-bv"
                >
                  <!-- This slot appears above the options from 'options' prop -->
                  <template #first>
                    <b-form-select-option :value="null" disabled
                      >- Month -</b-form-select-option
                    >
                  </template>

                  <!-- These options will appear after the ones from 'options' prop -->
                  <b-form-select-option
                    v-for="item in 12"
                    :value="item"
                    :key="item.index"
                    >{{ item + 0 }}
                  </b-form-select-option>
                </b-form-select>
              </div>
              <div class="col-4 pl-1">
                <b-form-select
                  id="date-of-birth-year"
                  v-model="dob.birth_year"
                  class="mb-3 file-select-bv"
                >
                  <!-- This slot appears above the options from 'options' prop -->
                  <template #first>
                    <b-form-select-option :value="null" disabled
                      >- Year -</b-form-select-option
                    >
                  </template>

                  <!-- These options will appear after the ones from 'options' prop -->
                  <b-form-select-option
                    v-for="(item, index) in reversdata"
                    :value="item"
                    :key="index"
                    >{{ item }}
                  </b-form-select-option>
                </b-form-select>
              </div>
            </div>
            <!-- <div class="form-group">
                                <input
                                    type="text"
                                    id="username"
                                    v-model="referral_code"
                                    class="form-control"
                                    placeholder="(Optional) Referral Code"
                                />
                            </div> -->

            <!-- Checkbox -->

            <!-- :disabled="
                  $v.$anyError ||
                  $v.fandata.$invalid ||
                  $v.dob.$invalid ||
                  !acceptedTerms ||
                  isActiveSpinner == true
                " -->
            <b-form-checkbox
              id="checkbox-agree"
              v-model="acceptedTerms"
              size="sm"
              class="mt-1"
              name="checkbox-1"
              value="true"
              >I agree to the
              <a @click="goToPage('/terms')" class="ff-alink2"
                >Terms & Conditions</a
              >
              and the
              <a @click="goToPage('/privacy')" class="href-text ff-alink2"
                >privacy policy.</a
              ></b-form-checkbox
            >

            <div class="d-flex justify-content-between align-items-center mb-3">
              <b-button
                type="submit"
                class="mt-2 btn login-btn rounded-pill"
                variant="ff-variant-pink"
                :disabled="fandata.user_name.length < 6 ||
                fandata.email === '' ||
                fandata.password === '' ||
                fandata.password_confirmation === '' ||
                fandata.mobile === '' ||
                !dob.birth_day ||
                !dob.birth_month ||                 
                !dob.birth_year ||
                !acceptedTerms || 
                isActiveSpinner ||
                usernameAvailable != null && !usernameAvailable
                "
                @click.prevent="onSubmitClick()"
              >
                <b-spinner
                  small
                  class="mr-2"
                  v-show="isActiveSpinner"
                ></b-spinner>
                <span>Sign Up</span></b-button
              >
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
  </div>
</template>
<script>
import { TheMask } from "vue-the-mask";
import SocialLogin from "@/components/auth/socialLogin";
const regex = (pattern) => {
  return value => !value || pattern.test(value);
};

import {
  required,
  email,
  minLength,
  sameAs,
  helpers,
} from "vuelidate/lib/validators";
const username = helpers.regex(
  "username",
  /^(?=[a-zA-Z0-9._]{6,35}$)(?!.*[_.]{2})[^_.].*[^_.]$/
);

export default {
  name: "signupFan",
  components: { TheMask, SocialLogin },
  data() {
    return {
      usernameAvailable: null,
      isUsernameAvailableLoader: false,
      showTooltip: true,
      years: 83,
      isActiveSpinner: false,
      year: null,
      selectedContryDialCode: null,
      acceptedTerms: false,
      dob: {
        birth_day: null,
        birth_month: null,
        birth_year: null,
      },
      date_of_birth: "",
      calculatedYear: null,
      payload: "",
      referral_code: "",
      fandata: {
        user_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        mobile: "",
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
    fandata: {
      // user_name: { required, minLength: minLength(6), username },
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
    const currentYear = new Date().getFullYear();
    const previousYear = currentYear - 101;
    this.calculatedYear = previousYear;
    this.year = new Date().getFullYear();
  },
  methods: {
    async isUsernameAvailable(username) {
      if (this.validateState("user_name")) {
        // this.isUsernameAvailableLoader = true;
        this.payload = { username: this.fandata.user_name };
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
    // ---------------------
    goToPage(page) {
      // this.$router.push(page);
      const absolutePath = this.$router.resolve(page).href;
      window.open(absolutePath, '_blank');
    },
    onSelect({ name, iso2, dialCode }) {
      this.selectedContryDialCode = dialCode;
    },
    validateState(user_name) {
      const { $dirty, $error } = this.$v.fandata[user_name];
      return $dirty ? !$error : null;
    },
    emailValidateState(email) {
      const { $dirty, $error } = this.$v.fandata[email];
      return $dirty ? !$error : null;
    },
    removeSpaces() {
      this.$v.fandata.email.$model = this.$v.fandata.email.$model.replace(
        /\s/g,
        ""
      );
      // if (this.$v.fandata.email.$model.includes(" ")) {
      //   this.showEmailError = true;
      // } else {
      //   this.showEmailError = false;
      // }
    },
    passValidateState(password) {
      const { $dirty, $error } = this.$v.fandata[password];
      return $dirty ? !$error : null;
    },
    ConfPassValidateState(password_confirmation) {
      const { $dirty, $error } = this.$v.fandata[password_confirmation];
      return $dirty ? !$error : null;
    },
    async onSubmitClick() {
      if (this.fandata.user_name.length < 6) {
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
        username: this.fandata.user_name,
        email: this.fandata.email,
        password: this.fandata.password,
        confirm_password: this.fandata.password_confirmation,
        phone_number: this.selectedContryDialCode + this.fandata.mobile,
        date_of_birth: this.date_of_birth,
        used_referral_code: this.referral_code,
      };
      var self = this;
      await this.$axios
        .post("/auth/registerFanUser", self.payload)
        .then(function (response) {
          self.login();
          self.$bvToast.toast("Registered Successfuly.", {
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
        self.$router.push("/fan/settings/profile");
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
<style scoped>
#verifytext:hover {
  text-decoration: none;
  color: #919aa3;
}
/* .login-wrapper {
} */
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
