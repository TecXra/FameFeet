<template>
  <!-- Sidebar  -->
  <nav id="sidebar" :class="{ active: sidebarEvent }">
    <div class="d-flex flex-column justify-content-between h-100">
      <div class="sidebar-header d-flex justify-content-center">
        <!-- Sidebar Profile -->
        <div class="" v-if="loggedIn" @click="goToProfile()">
          <b-avatar :src="user.avatarURL" class="profile-avatar img-thumbnail avatar-bg-area"></b-avatar>
          <div class="">
            <a class="User-profile p-0" id="profile-info"
              ><span class="text-center">{{ "My Profile" }}</span></a
            >
          </div>
        </div>
      </div>
      <!-- {{ sideNav }} -->
      <ul class="list-unstyled">
        <li
          :class="{ active: isLinkActive(item.url) }"
          v-for="(item, index) in sideNav"
          :key="index"
        >
          <a class="" @click="goToPage(item.url)">
            <i class="align-middle fi" :class="item.icon"></i
            ><span>{{ item.name }}</span></a
          >
        </li>
        <li v-if="settingSide">
          <a class="" @click="showDeleteModal()">
            <i class="align-middle fi fi-rr-remove-user"></i
            ><span>Delete Account</span></a
          >
        </li>
      </ul>
      <div class="sidebar-logout">
        <a class="" @click="logout()">
          <i class="align-middle fi fi-rr-sign-out-alt"></i
          ><span class="ml-1">Logout</span></a
        >
      </div>
    </div>
    <DeleteAccount></DeleteAccount>
  </nav>
</template>

<script>
import { mapState } from "vuex";
import DeleteAccount from "~/components/modal/common/settings/profile/deleteAccount";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  name: "sidebar",
  props: ["sideNav", "sidebarEvent", "settingSide"],
  components: { DeleteAccount },
  data() {
    return {};
  },
  methods: {
    showDeleteModal() {
      this.$bvModal.show("deleteAccount-modal");
      this.$emit("sidebarHideShowEvent", false);
    },
    goToProfile() {
      if (this.user.user_type == 1) {
        this.goToPage("/celebrity/settings/profile");
      }
      if (this.user.user_type == 2) {
        this.goToPage("/fan/settings/profile");
      }
    },
    isLinkActive(href) {
      return this.$route.path === href;
    },
    goToPage(page) {
      console.log(page);
      this.$router.push(page);
      this.$emit("sidebarHideShowEvent", false);

    },
    async logout() {
      await this.$auth.logout();
      localStorage.removeItem("cart_items");
      localStorage.removeItem("address");
      this.goToPage("/");
    },
  },
};
</script>
<style></style>
