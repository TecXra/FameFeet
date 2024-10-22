import Vue from "vue";
import VueMoment from "vue-moment";

// import VueCardFormat from "vue-credit-card-validation";

import VueStarRating from "vue-star-rating";
import VueTagsInput from "@johmun/vue-tags-input";
import VueCountryCode from "vue-country-code-select";

// Moment Library
Vue.use(require("vue-moment"));

// Vue Country Code
Vue.use(VueCountryCode);

// Vue Star Rating
Vue.component("VueStarRating", VueStarRating);

Vue.use(VueTagsInput);

// // Vue 2 - Implementation Example vue-credit-card-validation
// Vue.use(VueCardFormat);

