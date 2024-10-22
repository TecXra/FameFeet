<template>
  <div class="profile" @click="goToProfile(username)">
    <div class="profile-image">
      <img :src="imageUrl" :alt="username" />
    </div>
    <h3 class="profile-username">{{ username }}</h3>
  </div>
</template>

<script>
export default {
  props: {
    imageUrl: {
      type: String,
      required: true,
    },
    username: {
      type: String,
      required: true,
    },
  },
  methods: {
    goToProfile(username) {
      this.$router.push("/celebrity/" + username);
    },
  },
};
</script>

<style scoped>
.profile {
  cursor: pointer;
  display: flex;
  padding: 10px;
  align-items: center;
  text-align: center;
}

.profile-image {
  width: 35px;
  height: 35px;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 5px;
}

.profile-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profile-username {
  font-weight: 500;
  font-size: 1rem;
  margin: 0;
}

@media screen and (max-width: 767px) {
  .profile {
    margin-bottom: 30px;
  }

  .profile-image {
    width: 35px;
    height: 35px;
  }
}
</style>
