<template>
  <div class="container-fluid px-0">
    <HeroSection></HeroSection>
    <CookieConsent></CookieConsent>

    <HowItWorks></HowItWorks>
    <FeatureCategories></FeatureCategories>
    <FeatureCelebrities></FeatureCelebrities>
    <SafetySection></SafetySection>
    <Testimonials></Testimonials>
    <TopFooter></TopFooter>
  </div>
</template>

<script>
import HeroSection from "@/components/home/heroSection.vue";
import HowItWorks from "@/components/home/howItWorks.vue";
import FeatureCategories from "@/components/home/featureCategories.vue";
import FeatureCelebrities from "@/components/home/featureCelebrities.vue";
import SafetySection from "@/components/home/safetySection.vue";
import Testimonials from "@/components/home/testimonials.vue";
import TopFooter from "@/components/home/topFooter.vue";
import CookieConsent from "../components/common/cookieConsent.vue";

export default {
  layout: "home",
  name: "home",
  components: {
    HeroSection,
    HowItWorks,
    FeatureCategories,
    SafetySection,
    FeatureCelebrities,
    Testimonials,
    TopFooter,
    CookieConsent
  },
};
</script>
