<template>
  <div>
    <div
      v-if="type == 'celeb'"
      class="d-inline-flex align-items-center go-to-profile"
      @click="goToProfile(username,accountstatus)"
    >
      <b-avatar class="mr-2 user-avatar" :size="size" :src="avatarURL"></b-avatar>
      <div class="d-felx flex-column">
        <p class="mb-0 user-name-link user_name text-break">
          {{ username }}
        </p>
      </div>
    </div>
    <div
      v-else
      class="d-inline-flex align-items-center go-to-profile"
      @click="goToFanProfile(userid,account_status)"
    >
      <b-avatar class="mr-2 user-avatar" :size="size" :src="avatarURL"></b-avatar>
      <div class="d-felx flex-column">
        <p class="mb-0 user-name-link user_name text-break">
          {{ username }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "goToProfile",
  props: ["username", "avatarURL", "celebid", "userid", "size", "type","account_status","accountstatus"],

  data() {
    return {};
  },
  methods: {
    goToProfile(username,accountstatus) {
      if(accountstatus == 4){
          this.$bvToast.toast("This account has been deleted!", {
         title: "Warning",
         variant: "warning",
         solid: true,
        });
        }else{
          this.$router.push('/celebrity/'+username);
        }

      // this.$router.push('/celebrity/'+this.username);
      // this.$router.push({
      //   path: "/fan/celebrities/" + userid,
      //   query: { id: userid, userid: id },
      // });
    },
    goToFanProfile(userid,account_status) {

      if(account_status == 4){
          this.$bvToast.toast("This account has been deleted!", {
         title: "Warning",
         variant: "warning",
         solid: true,
        });
        }else{
          this.$router.push({
        path: "/celebrity/fans/" + userid,
      });
        }


    },
  },
};
</script>

<style>
.user-name-link {
  color: var(--primary);
  font-weight: 700;
}
.go-to-profile {
  cursor: pointer;
}
</style>
