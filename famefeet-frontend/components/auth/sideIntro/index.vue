<template>
  <div class="intro-section">
    <div class="back-btn">
      <button
        class="d-inline-flex align-items-center bg-transparent text-light border btn"
        @click="$router.push('/')"
      >
        <i class="fi fi-rr-angle-left mr-2" style="line-height: 0"></i>
        Back to site
      </button>
    </div>

    <div class="brand-wrapper" @click="$router.push('/')">
      <img src="~/assets/images/png/signIn/famefeet-logo.png" alt="FameFeet logo - A marketplace for buying and selling feet pics and worn socks." class="logo" />
    </div>

    <div class="intro-content-wrapper d-none d-lg-block">
      <h1 class="intro-title">Welcome to website !</h1>
      <p class="intro-text">
        Fame Feet allows you to buy/sell feet pictures, feet videos, worn socks
        from famous people. Experience the fun from our verified users in a
        secure environment
      </p>
    </div>

    <div class="intro-section-footer d-none d-lg-block">
      <p>
        Copyright © {{ year }} |
        <a class="text-reset footer-link fw-bold" href="/">Famefeet.com</a>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "IntroSection",

  data() {
    return {
      year: null,
    };
  },
  mounted() {
    this.year = new Date().getFullYear();
  },
  methods: {},
};
</script>

<style>
.intro-section {
  background-color: var(--primary);
  border-radius: 0px 0% 0% 0px;
  padding: 75px 95px;
  min-height: 100vh;
  display: -webkit-box;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  flex-direction: column;
  color: #ffffff;
}
.brand-wrapper {
  margin-bottom: 35px;
  display: flex;
  align-items: center;
}
.brand-wrapper:hover {
  cursor: pointer;
}
.back-btn {
  position: absolute;
  top: 1rem;
  left: 1rem;
}
.logo-famefeet {
  font-size: 42px;
}
.intro-content-wrapper {
  width: 371px;
  max-width: 100%;
  margin-top: auto;
  margin-bottom: auto;
}

.intro-content-wrapper .intro-title {
  font-size: 30px;
  font-weight: bold;
  margin-bottom: 18px;
}

.intro-content-wrapper .intro-text {
  font-size: 14px;
  line-height: 1.29;
  color: #ffffff;
}

.intro-content-wrapper .btn-read-more {
  background-color: #fff;
  padding: 13px 30px;
  border-radius: 0;
  font-size: 16px;
  font-weight: bold;
  color: #000;
}

.intro-content-wrapper .btn-read-more:hover {
  background-color: transparent;
  border: 1px solid #fff;
  color: #fff;
}
@media (max-width: 767px) {
  .intro-section-footer {
    margin-top: 35px;
  }
}

.intro-section-footer p {
  font-size: 14px;
  color: #f6f6f6;
  margin-bottom: 0;
}
.brand-wrapper .logo {
  height: 90px;
}

@media (max-width: 767px) {
  .brand-wrapper {
    margin-bottom: 35px;
  }
  .intro-section {
    padding-top: 68px !important;
    padding: 28px;
  }
}
@media (max-width: 991px) {
  .brand-wrapper span {
    font-size: 32px;
  }
  .brand-wrapper .logo {
    font-size: 32px;
    height: 60px;
  }
  .intro-section {
    padding-left: 50px;
    padding-right: 50px;
    min-height: auto;
  }
  .brand-wrapper {
    justify-content: center;
  }
}
</style>
