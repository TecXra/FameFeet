<template>
  <div class="verify-email">
    <div class="title">Verify Your Email Address</div>

    <form class="form" @submit.prevent="submit">
      <p class="mb-2">You're almost there! We sent an email to</p>

      <div class="input-wrapper">
        <input
          type="email"
          disabled
          class="input"
          placeholder="Enter your email address"
          v-model.trim="user.email"
          :class="{ error: error }"
          required
        />
        <i class="fa fa-envelope"></i>
        <span v-if="error" class="error-message">{{ error }}</span>
      </div>
      <p class="my-2">
        Just click on the link in that email to complete your signup. If you
        don't see it, you may need to check your spam folder.
      </p>
      <p>Still can't find the email?</p>
      <button
        v-if="!timerRunning"
        class="button"
        :disabled="loading || timerRunning"
        @click="resendEmail"
        ref="startBtn"
      >
        <span v-if="!loading">Resend Email</span>
        <span v-if="loading"><i class="fa fa-spinner"></i> Resending...</span>
      </button>
      <button
        v-if="timerRunning"
        class="button"
        :disabled="loading || timerRunning"
        ref="startBtn"
      >
        <span
          ><i class="fa fa-spinner"></i> Resend After {{ minutes }}:{{
            seconds
          }}</span
        >
      </button>
    </form>
    <p>
      Need help?<a class="ml-1 famefeet-link-a" @click="goToPage('/contact')"
        >Contact Us</a
      >
    </p>
    <div v-if="success" class="success-message">
      A verification email has been sent to {{ user.email }}.
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  layout: "home",
  middleware: "unverifiedEmail",
  data() {
    return {
      email: null,
      error: null,
      success: false,
      loading: false,
      timerRunning: false,
      timeLeft: 0,
      timerIntervalId: null,
    };
  },

  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
    minutes() {
      return Math.floor(this.timeLeft / 60)
        .toString()
        .padStart(2, "0");
    },
    seconds() {
      return (this.timeLeft % 60).toString().padStart(2, "0");
    },
  },
  methods: {
    submit() {
      if (!this.email) {
        this.error = "Please enter your email address.";
        return;
      }
      // Validate email format
      const regex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
      if (!regex.test(this.email)) {
        this.error = "Please enter a valid email address.";
        return;
      }
      this.loading = true;
      // Send verification email (mock implementation for demonstration purposes)
      setTimeout(() => {
        this.loading = false;
        this.success = true;
      }, 2000);
    },
    async resendEmail() {
      this.timerRunning = true;
      var payload = {
        email: this.user.email,
      };
      var self = this;
      await this.$axios
        .$post("/resendUserEmailVerificationEmail", payload)
        .then(function (response) {
          self.startTimer();
          self.$bvToast.toast(response.message, {
            title: "Success",
            variant: "success",
            solid: true,
          });
        })
        .catch(function (error) {
          console.log(error);
          self.$bvToast.toast(error, {
            title: "Error",
            variant: "error",
            solid: true,
          });
        });
    },
    startTimer() {
      // Disable the button and set the timerRunning flag
      this.timerRunning = true;
      this.$refs.startBtn.disabled = true;

      // Set the timer to 2 minutes (120 seconds)
      const timerDuration = 120;

      // Start the timer
      const startTime = Date.now();
      this.timerIntervalId = setInterval(() => {
        const elapsedTime = Date.now() - startTime;
        this.timeLeft = Math.ceil(timerDuration - elapsedTime / 1000);
        if (elapsedTime >= timerDuration * 1000) {
          // Stop the timer and enable the button
          clearInterval(this.timerIntervalId);
          this.timerRunning = false;
          this.timeLeft = 0;
          this.$refs.startBtn.disabled = false;

          // Save the timeLeft value to local storage
          localStorage.setItem("timeLeft", this.timeLeft);
        }
      }, 1000);
    },
    saveTimerData() {
      // Save the timer data to local storage before the page is unloaded
      if (this.timerRunning) {
        localStorage.setItem("timerRunning", true);
        localStorage.setItem("timeLeft", this.timeLeft);
      } else {
        localStorage.removeItem("timerRunning");
        localStorage.removeItem("timeLeft");
      }
    },
    goToPage(page) {
      this.$router.push(page);
    },
  },
  mounted() {
    // Get the saved timer data from local storage and resume the timer if applicable
    const savedTimerRunning = localStorage.getItem("timerRunning");
    const savedTimeLeft = localStorage.getItem("timeLeft");
    if (savedTimerRunning && savedTimeLeft) {
      this.timeLeft = savedTimeLeft;
      this.timerRunning = true;

      // Restart the timer with the saved timeLeft value
      this.$refs.startBtn.disabled = true;
      const timerDuration = 120;
      const startTime = Date.now() - (timerDuration - this.timeLeft) * 1000;
      this.timerIntervalId = setInterval(() => {
        const elapsedTime = Date.now() - startTime;
        this.timeLeft = Math.ceil(timerDuration - elapsedTime / 1000);
        if (elapsedTime >= timerDuration * 1000) {
          clearInterval(this.timerIntervalId);
          this.timerRunning = false;
          this.timeLeft = 0;
          this.$refs.startBtn.disabled = false;
          localStorage.removeItem("timerRunning");
          localStorage.removeItem("timeLeft");
        }
      }, 1000);
    }

    // Add an event listener for the beforeunload event to save the timer data to local storage
    window.addEventListener("beforeunload", this.saveTimerData);
  },
  beforeDestroy() {
    // Remove the event listener for the beforeunload event
    window.removeEventListener("beforeunload", this.saveTimerData);
  },
};
</script>

<style scoped>
.verify-email {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  /* height: calc(100vh - 68px); */
  height: 100vh;
}
.verify-email a {
  color: #0097a7;
}
.title {
  font-size: 32px;
  font-weight: bold;
  color: #0097a7;
  margin-bottom: 30px;
  text-align: center;
}
.form {
  padding: 40px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px,
    rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  max-width: 400px;
  margin-bottom: 30px;
}
.input-wrapper {
  position: relative;
  width: 100%;
}
.input {
  width: 100%;
  padding: 15px 60px 15px 15px;
  border: none;
  border-radius: 30px;
  background-color: #f7f7f7;
  font-size: 18px;
  color: #333;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease-in-out;
}
.input:focus {
  outline: none;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
}
.input.error {
  border: 2px solid #ffab40;
}
.input:focus + i,
.input.not-empty + i {
  right: 20px;
  color: #0097a7;
}
.input-wrapper i {
  position: absolute;
  top: 50%;
  right: 30px;
  transform: translateY(-50%);
  color: #ccc;
  transition: all 0.3s ease-in-out;
}
.input.not-empty:focus + i {
  color: #0097a7;
}
.error-message {
  font-size: 14px;
  font-weight: bold;
  color: #ffab40;
  margin-top: 10px;
  text-align: center;
}
.button {
  width: 100%;
  padding: 15px 0;
  border: none;
  border-radius: 30px;
  background-color: #0097a7;
  font-size: 18px;
  font-weight: bold;
  color: #fff;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}
.button:hover {
  background-color: #007a87;
}
.button:active {
  background-color: #005c66;
}
.button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.success-message {
  font-size: 24px;
  font-weight: bold;
  color: #0097a7;
  text-align: center;
}
@media only screen and (max-width: 600px) {
  .title {
    font-size: 24px;
    margin-bottom: 20px;
  }
  .input {
    font-size: 16px;
  }
  .error-message {
    font-size: 12px;
  }
  .button {
    font-size: 16px;
    padding: 10px 0;
  }
  .success-message {
    font-size: 20px;
  }
}
</style>
