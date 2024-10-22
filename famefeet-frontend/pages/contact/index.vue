<template>
  <div class="container-fluid px-0">
    <Loader v-show="isLoadershow"></Loader>

    <!-- <ff-navbar /> -->
    <div class="ff-contactus text-center">
      <h2>Contact Us</h2>
      <p class="ff-paragraph1">
        Do you have any questions? Please do not hesitate to contact us
        directly. <br />
        Our team will come back to you within a matter of hours to help you.
      </p>
    </div>
    <div class="container-fluid background-f">
      <div class="d-flex flex-md-row m-0 flex-column-reverse">
        <div class="col-md-8">
          <div class="ff-contact py-5">
            <b-form class="ff-contact-form">
              <b-form-group id="name-group" > 
                <template v-slot:label>
                  Your Name:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
                <b-form-input id="name" class="Famefeet-input-field" v-model="name" placeholder="Name"></b-form-input>
              </b-form-group>

              <b-form-group id="Email-group">
                <template v-slot:label>
                  Email address:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
                <b-form-input id="email" class="Famefeet-input-field" type="email" v-model="email" placeholder="Email"
                  required></b-form-input>

                <p v-if="emailError" class="error-message-contact">
                  {{ emailError }}
                </p>
              </b-form-group>

              <b-form-group id="Subject-group" >
                <template v-slot:label>
                  Subject:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
                <b-form-input id="Subject" v-model="subject" class="Famefeet-input-field"
                  placeholder="Subject"></b-form-input>
              </b-form-group>

              <b-form-group id="textarea-group" >
                <template v-slot:label>
                  Message:
                    <span style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
                </template>
                <b-form-textarea v-model="message" id="textarea" placeholder="Write your message...."
                  class="Famefeet-input-field scrollbar-none" rows="5" required></b-form-textarea>
              </b-form-group>
              <div class="text-center text-md-left">
                <!-- <b-button class="btn ff-btn1-pink px-3" @click="onSubmitClick()"
                  >Send Message</b-button
                > -->
                <b-button class="btn ff-btn1-pink px-3"
                 @click="onSubmitClick()" :disabled="isSending || 
                 name === '' ||
                 email === '' ||
                 subject === '' ||
                 message === ''" >
                  <b-spinner v-if="isSending" small />
                  {{ isLoading ? 'Sending...' : 'Send Message' }}
                </b-button>
              </div>
            </b-form>
          </div>
        </div>
        <div class="col-md-4 d-flex justify-content-center">
          <div class="align-self-center">
            <img src="~/assets/images/svg/contact_us.svg" alt="Contact Us" class="img-fluid pt-md-0 pt-5" />
          </div>
        </div>
      </div>
    </div>

    <TopFooter></TopFooter>
  </div>
</template>
<script>
import Loader from "@/components/common/loader";
import TopFooter from "@/components/home/topFooter.vue";

export default {
  computed: {
    emailError() {
      if (this.email === "") {
        return "";
      }
      if (!this.validateEmail(this.email)) {
        return "Please enter a valid email address.";
      }
      return "";
    },
  },

  name: "contact",
  layout: "home",
  components: { TopFooter,Loader },

  data() {
    return {
      name: "",
      email: "",
      subject: "",
      message: "",
      isSending: false,
      isLoadershow: true,
    };
  },
  mounted() {
    setTimeout(() => {
      this.isLoadershow = false;
    }, 2000); // Adjust the timeout duration as needed
  },
  methods: {
    validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    },
    async onSubmitClick() {
      this.isSending = true;
      this.payload = {
        name: this.name,
        email: this.email,
        subject: this.subject,
        message: this.message,
      };
      // alert(JSON.stringify(payload))
      var self = this;
      await this.$axios
        .post("/contact-us", self.payload)
        .then(function (response) {
          self.isSending = false;
          self.$bvToast.toast(response.data.message, {
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
      self.isSending = false;
      self.name = "";
      self.email = "";
      self.subject = "";
      self.message = "";
    },
  },
};
</script>

<style>
.error-message-contact {
  color: red;
}

.background-f {
  background-color: var(--secondary);
  margin-bottom: 8rem;
  margin-top: 4rem;
  box-shadow: rgb(28 27 27 / 45%) 0px 4px 29px -6px;
}

.ff-contactus {
  margin-top: 4rem;
  padding: 1.5rem;
  color: #000;
  font-family: "Poppins", sans-serif;
}

.ff-contactus h2 {
  font-size: 48px;
  font-weight: 700;
}

.ff-contact-form {
  font-family: "Poppins", sans-serif;
  font-size: 16px;
  font-weight: 500;
  color: white;
}

@media only screen and (max-width: 600px) {
  .background-f {
    padding-left: 2rem;
    padding-right: 2rem;
  }

  .ff-contact {
    margin-right: 0rem;
  }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 768px) {
  .ff-contact {
    margin-right: 0rem;
  }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
  .ff-contact {
    margin-right: 3rem;
  }

  .background-f {
    padding-left: 3rem;
    padding-right: 3rem;
  }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  .ff-contact {
    margin-right: 2rem;
  }

  .ff-contact {
    margin-right: 8rem;
  }
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
  .background-f {
    padding-left: 10rem;
    padding-right: 10rem;
  }
}
</style>
