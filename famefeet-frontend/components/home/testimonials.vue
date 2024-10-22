<template>
  <div class="bg-white">
    <div class="text-center pt-5">
      <h2 class="ff-heading2 mb-4">CUSTOMER REVIEWS</h2>
      <p class="ff-paragraph2 text-dark">What our clients are saying..</p>
    </div>

    <b-carousel
      id="carousel-1"
      :interval="4000"
      controls
      indicators
      background="#fff"
    >
      <!-- Text slides with image -->
      <b-carousel-slide v-for="(item, index) in testimonials" :key="index">
        <div class="carousel-caption">
          <p>{{ item.review }}</p>
          <b-avatar size="4rem" :src="item.avatarURL"></b-avatar>
          <div id="image-caption">{{ item.name }}</div>
        </div>
      </b-carousel-slide>
    </b-carousel>
  </div>
</template>
<script>
export default {
  name: "testimonials",

  data() {
    return {
      testimonials: [],
    };
  },
  mounted() {
    this.getTestimonials();
  },
  methods: {
    async getTestimonials() {
      var self = this;
      await this.$axios
        .$get("/getAllTestimonials")
        .then(function (response) {
          self.isShow = false;
          self.testimonials = response;
        })
        .catch(function (error) {
          // const object = error.response.data;
          // for (const property in object) {
          //   self.$bvToast.toast(object[property][0], {
          //     title: "Warning",
          //     variant: "warning",
          //     solid: true,
          //   });
          // }
        });
    },
  },
};
</script>

<style>
.carousel-caption {
  font-family: "Poppins", sans-serif;
  position: initial;
  z-index: 10;
  padding: 1rem 7rem;
  color: #343a40;
  text-align: center;
  font-size: 1.2rem;
  font-weight: bold;
  line-height: 2rem;
}

/* 	.carousel-caption img {
		width: 6rem;
		border-radius: 50%;
		margin-top: 2rem
	} */
@media (max-width: 767px) {
  .carousel-caption {
    position: initial;
    z-index: 10;
    padding: 3rem 2rem;
    color: #343a40;
    text-align: center;
    font-size: 0.7rem;
    font-weight: bold;
    line-height: 1.5rem;
  }
}

.carousel-indicators {
  bottom: -20px;
}

.carousel-indicators li {
  background-color: var(--secondary);
  width: 10px;
  height: 10px;
  border-radius: 100%;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
  filter: invert(51%) sepia(95%) saturate(1151%) hue-rotate(182deg)
    brightness(101%) contrast(92%);
}

@media only screen and (min-width: 1200px) {
  .carousel-control-prev {
    left: 174px;
  }

  .carousel-control-next {
    right: 174px;
  }

  .carousel-caption {
    padding-left: 12rem;
    padding-right: 12rem;
  }
}

@media (max-width: 767px) {
  .carousel-caption img {
    width: 4rem;
    border-radius: 4rem;
    /* margin-top: 1rem; */
  }

  .carousel-caption {
    padding-top: 0.7rem;
  }
}
</style>
