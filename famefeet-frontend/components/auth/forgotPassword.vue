<template>
  <div class="form-section pt-0">
    <div class="login-wrapper" v-if="step_one">
      <h2 class="login-title font-weight-bold">Forgot Password?</h2>
      <form action="#!">
        <div class="form-group">
          <label for="email"
            >Enter the email address associated with your account.</label
          >
          <input
            type="email"
            class="form-control rounded-pill"
            v-model.trim="$v.email.$model"
            required
            id="email"
            placeholder="mail@website.com"
            aria-describedby="emailHelp"
          />
        </div>
        <div class="d-flex justify-content-end align-items-center mb-5">
          <button
            class="btn login-btn rounded-pill"
            :disabled="isActiveSpinner || !$v.email.required"
            type="button"
            @click="onSubmitClick()"
          >
            <span>Send</span>
            <b-spinner small class="" v-show="isActiveSpinner"></b-spinner>
          </button>
        </div>
      </form>
    </div>
    <div class="login-wrapper" v-if="step_two">
      <h2 class="login-title font-weight-bold">Verification</h2>
      <form action="#!">
        <div class="form-group">
          <label for="token-verification">
            <div class="">
              <span
                >Please enter the verification Code that you received on your
                email</span
              >
            </div>
          </label>
          <input
            type="text"
            class="form-control rounded-pill"
            required
            v-model="token"
            id="token-verification"
            placeholder="code"
          />
        </div>
        <div class="d-flex justify-content-end align-items-center mb-5">
          <button
            class="btn login-btn rounded-pill"
            :disabled="isActiveSpinner || !token || token.length < 6"
            type="button"
            @click="verifyCode()"
          >
            <span>Verify</span>
            <b-spinner small class="" v-show="isActiveSpinner || v"></b-spinner>
          </button>
        </div>
      </form>
    </div>
    <div class="login-wrapper" v-if="step_three">
      <h2 class="login-title font-weight-bold">Enter New Password!</h2>
      <form action="#!">
        <div class="row">
          <div class="col-12">
            <b-form-group>
              <label for="password">
                <div class="">
                  <span>Set a strong new password for your FameFeet account.</span>

                </div>
              </label>
              <b-form-input
                v-model="$v.password.$model"
                :state="passValidateState('password')"
                aria-describedby="input-password-live-feedback"
                type="password"
                class="Famefeet-input-field mb-2"
                id="password"
                placeholder="Password"
                required
              ></b-form-input>
              <b-form-invalid-feedback id="input-password-live-feedback"
                >Your password must be 8 characters long
              </b-form-invalid-feedback>
            </b-form-group>
          </div>
          <div class="col-12">
            <b-form-group>
              <b-form-input
                type="password"
                v-model="$v.password_confirmation.$model"
                :state="ConfPassValidateState('password_confirmation')"
                aria-describedby="input-con-pass-live-feedback"
                class="Famefeet-input-field mb-2"
                id="Conf-password"
                placeholder="Confirm Password"
                required
              >
              </b-form-input>
              <b-form-invalid-feedback id="input-con-pass-live-feedback"
                >Please make sure your passwords match
              </b-form-invalid-feedback>
            </b-form-group>
          </div>
        </div>

        <div class="d-flex justify-content-end align-items-center mb-5">
          <input
            name="login"
            id="login"
            :disabled="
              !$v.password.minLength ||
              !$v.password_confirmation.required ||
              !$v.password_confirmation.sameAsPassword
            "
            class="btn login-btn rounded-pill"
            @click="resetPassword()"
            type="button"
            value="Done"
          />
        </div>
      </form>
    </div>
    <div class="login-wrapper" v-if="step_four">
      <div class="d-flex">
        <h2 class="login-title font-weight-bold">Woo hoo!</h2>
        <!-- <span class="check2"><i class="fa fa-check"></i></span> -->
      </div>
      <form action="#!">
        <div class="form-group">
          <label for="exampleInputEmail1"
            ><span>Your password has been reset successfully!</span>
            <span>Now login with your new password.</span></label
          >
        </div>
        <div class="d-flex justify-content-end align-items-center mb-5">
          <input
            name="login"
            id="login"
            class="btn login-btn rounded-pill"
            @click="goToLogin()"
            type="button"
            value="login"
          />
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import { required, email, minLength, sameAs } from "vuelidate/lib/validators";
export default {
  name: "forgotPassword",
  data() {
    return {
      isActiveSpinner: false,
      email: "",
      token: "",
      password: "",
      password_confirmation: "",
      year: null,
      step_one: true,
      step_two: false,
      step_three: false,
      step_four: false,
    };
  },
  validations: {
    password: { required, minLength: minLength(8) },
    email: { required, email },
    password_confirmation: { required, sameAsPassword: sameAs("password") },
  },
  methods: {
    goToHome() {
      this.$router.push("/");
    },
    goToLogin() {
      this.$router.push("/signin");
    },
    passValidateState(password) {
      const { $dirty, $error } = this.$v.password;
      return $dirty ? !$error : null;
    },
    ConfPassValidateState(password_confirmation) {
      const { $dirty, $error } = this.$v.password_confirmation;
      return $dirty ? !$error : null;
    },
    async onSubmitClick() {
      this.isActiveSpinner = true;
      event.preventDefault();
      // alert()
      this.payload = {
        email: this.email,
      };
      var self = this;
      await this.$axios
        .post("/forgetPassword", self.payload)
        .then(function (response) {
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.isActiveSpinner = false;

          self.step_one = false;
          self.step_two = true;
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

      // this.mobile_number = '';
    },
    async verifyCode() {
      this.isActiveSpinner = true;

      event.preventDefault();
      // alert()
      this.payload = {
        token: this.token,
      };
      var self = this;
      await this.$axios
        .post("/varifyToken", self.payload)
        .then(function (response) {
          // console.log(response);
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.isActiveSpinner = false;
          self.step_one = false;
          self.step_two = false;
          self.step_three = true;
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

      // this.mobile_number = '';
    },
    async resetPassword() {
      this.isActiveSpinner = true;

      event.preventDefault();
      // alert()
      this.payload = {
        token: this.token,
        password: this.password,
        confirm_password: this.password_confirmation,
      };
      var self = this;
      await this.$axios
        .post("/resetForgetPassword", self.payload)
        .then(function (response) {
          // console.log(response);
          self.$bvToast.toast(response.data.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
          self.isActiveSpinner = false;
          self.step_one = false;
          self.step_two = false;
          self.step_three = false;
          self.step_four = true;
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
  },
};
</script>

<style lang="css" scoped>
.check2 {
  display: flex;
  background-color: var(--primary);
  color: #fff;
  font-size: 17px;
  width: 40px;
  height: 40px;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  margin-bottom: 10px;
}
.check2 i {
  font-size: 25px;
}
</style>
