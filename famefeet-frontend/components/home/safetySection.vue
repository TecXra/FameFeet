<template>
  <div class="ff-section-area">
    <div class="row m-0">
      <div class="col-lg-4">
        <div class="p-lg-5 px-5 py-0 mt-5 d-flex justify-content-center">
          <img src="~/assets/images/svg/famefeet-security-safety.svg" alt="FameFeet is a secure platform that ensures your information is safe and anonymous with PCI 
compliance" class="safety-img" />
        </div>
      </div>

      <div class="col-lg-8">
        <div class="text-center mr-lg-5 p-lg-5">
          <h2 class="ff-heading2 mt-5 mb-4 text-light">IS FAMEFEET SAFE?</h2>
          <p class="ff-paragraph3">
            FameFeet is a secure platform. Your information is safe and
            anonymous. We are PCI compliant.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "safetySection",

  data() {
    return {};
  },
};
</script>

<style>
.safety-img {
  max-width: 280px;
}

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
  .safety-img {
    max-width: 250px;
  }
}
</style>
