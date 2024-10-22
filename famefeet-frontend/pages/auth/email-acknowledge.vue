<template>
  <div class="success-screen">

    <div class="brand-wrapper my-4" @click="$router.push('/')">
      <img src="~/assets/images/png/emailAcknowledge/famefeet-logo.png" alt="FameFeet logo - A marketplace for buying and selling feet pics and worn socks." height="100" class="logo" />
    </div>

    <div class="email-verification-successful" v-if="is_show == 1">
      <div class="icon-container">
        <i class="fa fa-check material-icons"></i>
      </div>
      <div class="message-container">
        <h3>Email Verification Successful</h3>
        <p>Your email has been verified successfully.</p>
        <!-- {{ loggedIn }} -->
        <button class="button" ref="statBtn" @click="goToDashboard()">
          <span>Go To Dashboard</span>
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  name: "email-acknowledge",

  data() {
    return {
      token: this.$route.query.token ? this.$route.query.token : null,
      is_show: null,
    };
  },

  mounted() {
    this.verifyUserEmail(this.token);
  },
  methods: {
    async verifyUserEmail(token) {
      var self = this;
      await this.$axios
        .$get("/verifyUserEmail/" + token)
        .then(function (response) {
          if (self.loggedIn == true) {
            self.$store.commit("updateStateEmailverify", true);
          }
          self.is_show = response;
          if (self.is_show == 0) {
            self.goToPage("/auth/email-verification");
          }
        })
        .catch(function (error) {});
    },

    goToPage(page) {
      this.$router.push(page);
    },

    goToDashboard() {
      if (this.loggedIn == true) {
        if (this.user.user_type == 1) {
          this.goToPage("/celebrity/content");
        }
        if (this.user.user_type == 2) {
          this.goToPage("/fan/celebrities");
        }
      } else {
        this.$router.push("/");
      }
    },
  },
};
</script>

<style scoped>
.success-screen {
  background-color: #17a2b8;
}
.success-screen {
  display: flex;
  flex-direction: column;
  align-items: center;
  /* justify-content: center; */
  height: calc(100vh);
}
.email-verification-successful {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #fff;
  color: #0097a7;
  padding: 2rem;
  box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px,
    rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
}

.icon-container {
  border: #0097a7 2px solid;
  border-radius: 50%;
  padding: 0px 12px;
  font-size: 3rem;
  margin-bottom: 2rem;
}

.message-container {
  text-align: center;
}
.icon-container:hover {
  transform: scale(1.2);
}
.message-container h3 {
  margin-bottom: 1rem;
}
.message-container {
  /* margin-bottom: 2rem; */
}
.button {
  width: 50%;
  padding: 10px 0;
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

@media (max-width: 768px) {
  .email-verification-successful {
    padding: 1rem;
  }
  .button {
    font-size: 16px;
    padding: 10px 0;
  }
  .icon-container {
    font-size: 3rem;
    margin-bottom: 1rem;
  }
}
</style>
