<template>
  <!-- HOW IT WORKS -->
  <div class="container-fluid px-0" id="howItWorks">
    <h1 class="text-center text-dark ff-heading2 mt-4 mt-lg-0">HOW IT WORKS</h1>
    <div class="">
      <div class="py-3">
        <div class="row m-0 align-items-center">
          <div class="col-lg-4">
            <div class="px-5 py-lg-5 py-3 d-flex justify-content-center">
              <img
                src="~/assets/images/svg/authentication-profile-verification.svg"
                alt="Authentication process: Create a profile and get instantly verified with an ID for sellers."
                class="how-its-images"
              />
            </div>
          </div>

          <div class="col-lg-8">
            <div
              class="text-center mr-lg-5 px-lg-5 pb-3 pb-lg-5 pt-lg-5 d-flex"
            >
              <p class="ff-paragraph3 text-dark mb-0">
                Create a profile. Sellers will be instantly verified with an ID.
              </p>
            </div>
          </div>
        </div>

        <div
          class="row m-0 align-items-center flex-md-row-reverse howItWorks-second"
        >
          <div class="col-lg-4">
            <div class="px-5 py-lg-5 py-3 d-flex justify-content-center">
              <img
                src="~/assets/images/svg/feet-pics-celebrities-services.svg"
                alt="Celebrities can post feet pictures and videos, sell worn socks, and offer subscription services"
                class="how-its-images-share"
              />
            </div>
          </div>
          <div class="col-lg-8">
            <div class="text-center mr-lg-5 px-5 pb-lg-5 pb-2 pt-lg-5 d-flex">
              <p class="ff-paragraph3 text-light">
                Sellers can instantly post feet pictures, feet videos, share
                content, sell their worn socks, have a subscription service, and
                send custom offers.
              </p>
            </div>
          </div>
        </div>

        <div class="row m-0 align-items-center">
          <div class="col-lg-4">
            <div class="px-5 py-lg-5 py-3 d-flex justify-content-center">
              <img
                src="~/assets/images/svg/celebrities-influencers-fans-services.svg"
                alt="Fans can instantly purchase content, subscribe to celebrities, follow, message, request custom content, 
buy worn socks, and review influencers"
                class="how-its-images-share"
              />
            </div>
          </div>

          <div class="col-lg-8">
            <div class="text-center mr-lg-5 px-5 pt-lg-5 d-flex">
              <p class="ff-paragraph3 text-dark">
                Buyers can instantly purchase content, subscribe to sellers,
                follow, message, request custom content, buy worn socks, and
                review sellers.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "howItWorks",

  data() {
    return {};
  },
};
</script>

<style lang="css" scoped>
.how-its-images {
  max-width: 200px;
}
.how-its-images-share {
  max-width: 270px;
}
.howItWorks-second {
  background-color: var(--secondary);
}
</style>
