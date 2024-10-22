<template>
  <div
    class="container vh-100 d-flex flex-column justify-content-center align-items-center"
  >
    <div class="loader"></div>
    <p>Please wait while we're logging you in...</p>
    <AccountDeactivetd />
  </div>
</template>

<script>
import AccountDeactivetd from "@/components/modal/auth/accountDeactivetd";

export default {
  middleware: ["guest"],
  components: { AccountDeactivetd },

  data() {
    return {
      token: this.$route.query.token ? this.$route.query.token : null,
      status: this.$route.query.status ? this.$route.query.status : null,
    };
  },
  mounted() {
    if (this.status === null) {
      this.$bvModal.show("accountdeactive");
      console.log("your account disabled");
    } else {
      // console.log(this.token);
      this.$auth.setToken("local", "Bearer " + this.token);
      this.$auth.setStrategy("local");
      this.$axios.setToken("Bearer " + this.token);
      this.$auth
        .fetchUser()
        .then(() => {
          console.log("then");
          this.$router.push("/");
        })
        .catch((e) => {
          console.log("catch");
          this.$auth.logout();
          this.$router.push("/signin");
        });
    }
  },
};
</script>

<style lang="scss" scoped>
.container {
  text-align: center;
}
.container p {
  color: var(--primary);
}
// .loader {
//   margin: 20px auto;
//   border: 8px solid #f3f3f3;
//   border-radius: 50%;
//   border-top: 8px solid #3b5998;
//   border-bottom: 8px solid #3b5998;
//   width: 60px;
//   height: 60px;
//   -webkit-animation: spin 1.2s linear infinite;
//   animation: spin 1.2s linear infinite;
// }
// @-webkit-keyframes spin {
//   0% {
//     -webkit-transform: rotate(0deg);
//   }
//   100% {
//     -webkit-transform: rotate(360deg);
//   }
// }
// @keyframes spin {
//   0% {
//     transform: rotate(0deg);
//   }
//   100% {
//     transform: rotate(360deg);
//   }
// }
.loader {
  margin: 20px auto;
  border: 12px solid lightgrey;
  border-radius: 50%;
  /* border-top: 16px solid rgb(232, 75, 136); */
  border-top: 12px solid var(--primary);
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
