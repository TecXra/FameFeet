<template>
  <div class="container ff-notif px-0">
    <Loader v-show="is_show"></Loader>
    <div class="mt-3" v-show="!is_show">
      <!-- {{notify}} -->
      <b-card class="" body-class="px-1 p-sm-4">
        <b-card-title class="font-weight-bold pl-2">Notifications</b-card-title>
        <hr />

        <div class="container noti-container">
          <div class="justify-content-center align-items-center text-center d-flex">
            <p
            class="ff-paragraph4 h3 mt-3 text-center"
            v-if="!notify.length && is_show == false"
          >
            All your notifications will be shown here.
          </p>
          </div>
          <b-alert
            show
            class="ff-noti-alert"
            v-for="(item, index) in notify"
            :key="index"
          >
            <div class="d-flex align-items-center text-break">
              <b-icon
                icon="bell"
                class="ff-noti-icon mr-3 border-light rounded-circle"
              ></b-icon>
              <div>
                <!-- {{ item.data.user_id 11 userid8 }} -->
                <!-- {{ item.data.user_id }} -->
                <!-- {{user}} -->
                <p class="mb-0">
                  <span
                    class="ff-notif-text"
                    @click="
                      goToProfile(
                        item.data.user_id,
                        user.user_type,
                        item.data.user_name,
                        item.user.account_status
                      )
                    "
                    >{{ item.data.user_name }}</span
                  >
                  <span>{{ item.data.message | sentenceCase }}</span>
                </p>
                <time
                  ><small class="text-muted"
                    >{{ item.created_at | moment("from", true) }} ago</small
                  ></time
                >
              </div>
            </div>
          </b-alert>

        </div>
      </b-card>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Loader from "@/components/common/loader";

export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },

  name: "notifications",
  components: { Loader },

  data() {
    return {
      is_show: true,
      notify: [
        // {
        // 	name: 'Aamir',
        // 	type: 'followed you.',
        // 	date: "Monday, February 21st 2022"
        // },
        // {
        // 	name: '',
        // 	type: 'Add content to your profile! Buyers won’t see your account until you have added a profile picture and at least one album.',
        // 	date: "Monday, February 21st 2019"
        // },
        // {
        // 	name: '',
        // 	type: 'Your age verification has been approved. Click here to finish setting up your account.',
        // 	date: "Monday, February 21st 2021"
        // },
        // {
        // 	name: '',
        // 	type: 'Welcome to Famefeet! Before you can upload content, edit your profile, and more, you need to get verified. Click here to verify your account.',
        // 	date: "Monday, February 21st 2018"
        // },
      ],
    };
  },

  mounted() {
    this.getAllNotifications();
    // this.notify = []
    // localStorage.setItem('notify', JSON.stringify(this.notify));
    this.markAsread();
  },
  methods: {
    goToProfile(userId, usertype, username,account_status) {

      if (usertype == 1) {
        if(account_status == 4){
          this.$bvToast.toast("This account has been deleted!", {
         title: "Warning",
         variant: "warning",
         solid: true,
        });
        }else{
          this.$router.push({
          path: "/celebrity/fans/" + userId,
        });
        }

      } else {
        if(account_status == 4){
          this.$bvToast.toast("This account has been deleted!", {
         title: "Warning",
         variant: "warning",
         solid: true,
        });
        }else{
          this.$router.push("/celebrity/" + username);

        }
      }
    },

    async getAllNotifications() {
      var self = this;
      await this.$axios
        .$get("/auth/getAllNotifications")
        .then(function (response) {
          self.notify = response;
          self.is_show = false;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    async markAsread() {
      var self = this;
      await this.$axios
        .$get("/auth/markAsReadNotification")
        .then(function (response) {
          // console.log(response);
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      this.$nuxt.$emit("notificationRead");
    },
  },
};
</script>

<style>
.ff-notif .card {
  height: 89vh;
}

.ff-notif-text:hover {
  cursor: pointer;
}

.ff-notif-text {
  color: var(--primary);
  font-weight: 700;
}

.ff-noti-icon {
  width: 40px;
  color: var(--primary);
  height: 40px;
  padding: 8px;
  border: solid 1px var(--primary) !important;
}

.ff-noti-alert {
  border-left: 6px solid var(--primary);
  border-right: none;
  border-top: none;
  border-bottom: none;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  background-color: #fff;
}
.noti-container {
  height: 89%;
  overflow-y: auto;
}
</style>
