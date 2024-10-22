<template>
  <section>
    <div class="hero-section-ff mb-3">
      <div class="content-svg position-relative">
        <i class="d-none d-lg-block">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="1919.997"
            height="936.289"
            viewBox="0 0 1919.997 936.289"
          >
            <defs>
              <filter
                id="Path_1"
                x="0"
                y="0"
                width="1919.997"
                height="936.289"
                filterUnits="userSpaceOnUse"
              >
                <feOffset dy="15" input="SourceAlpha" />
                <feGaussianBlur result="blur" />
                <feFlood flood-color="var(--primary)" flood-opacity="0.361" />
                <feComposite operator="in" in2="blur" />
                <feComposite in="SourceGraphic" />
              </filter>
            </defs>
            <g id="Untitled-2" transform="translate(0 1417)">
              <g
                transform="matrix(1, 0, 0, 1, 0, -1417)"
                filter="url(#Path_1)"
                style="mix-blend-mode: darken; isolation: isolate"
              >
                <path
                  id="Path_1-2"
                  data-name="Path 1"
                  d="M0-956.356v460.644l4.165-2.276c6.7-3.824,30.171-15.385,42.362-20.847,102.4-46.065,235.683-77.29,355.251-83.389,65.016-3.368,106.464-2.094,196.571,5.917,104.025,9.195,157.359,9.923,227.86,3.186,58.921-5.735,127.391-19.937,190.171-39.6,10.667-3.277,21.638-6.555,24.483-7.283,5.587-1.365,21.435-6.555,53.232-17.3,11.479-3.915,30.476-10.105,42.159-13.747,11.784-3.641,25.9-8.557,31.492-10.833,9.549-4.1,18.489-7.192,45.613-16.022,11.886-3.915,26.616-7.374,47.848-11.2,21.638-4.006,30.883-5.917,43.175-9.195,6.4-1.639,14.019-3.459,16.762-4.006,20.419-4.006,48.152-5.917,68.063-4.643,58.311,3.55,73.041,5.189,91.937,10.014,3.657.91,11.581,3,17.778,4.552a233.015,233.015,0,0,1,32.406,10.651c4.368,1.73,14.019,4.916,21.333,7.1,16.965,5.007,21.232,6.464,25.8,8.557,2.133.91,14.222,4.006,27.022,6.828,27.429,6.008,55.264,13.018,79.34,19.937,40.229,11.653,115.4,26.036,156.952,30.133,27.733,2.731,33.727,2.731,70.4,0l7.822-.637V-1417H0Z"
                  transform="translate(0 1417)"
                  fill="var(--primary)"
                  fill-opacity="0.600"
                />
              </g>
            </g>
          </svg>
        </i>
        <div class="row mx-0 w-100 Main-Content-Area h-100">
          <div
            class="col-lg-6 main-left-side d-flex justify-content-center px-sm-4 px-2 px-md-5 px-lg-0"
          >
            <div
              class="main-text-area d-flex justify-content-center flex-column py-5"
            >
              <h1 class="mb-3 mt-md-0 text-light header-heading">
                Buy and Sell Feet Pics & Worn Socks – Connecting Fans with
                Celebrities
              </h1>
              <p class="mb-sm-3 mb-1 header-paragraph">
                Welcome to the premier platform where fans can buy exclusive
                feet pics and worn socks directly from celebrities. Our secure,
                user-friendly marketplace offers fans access to unique,
                high-quality content, including premium feet photos and
                authentic worn socks from their favorite celebrities. Join today
                to explore and connect!
              </p>
              <div class="pt-md-3 pt-1 d-sm-flex text-center text-sm-left" v-if="loggedIn">
                <a
                  v-if="user.user_type == 2"
                  @click.prevent="goToPage('/contents')"
                  class="btn btn-outline-light font-weight-bold rounded-pill mr-2"
                  >Buy Exclusive Feet Pics & Worn Socks</a
                >
                <a
                  v-if="user.user_type == 1"
                  @click.prevent="goToPage('/celebrity/content')"
                  class="btn btn-outline-light font-weight-bold rounded-pill"
                  >Sell Feet Pics, Worn Socks & Exclusive Content</a
                >
              </div>
              <div class="pt-sm-3 pt-1 d-sm-flex text-center text-sm-left" v-if="!loggedIn">
                <a
                  href
                  @click.prevent="goToPage('/signup/fan')"
                  class="btn btn-outline-light font-weight-bold rounded-pill mr-2 mt-2 mt-sm-0"
                  >Buy Exclusive Feet Pics & Worn Socks</a
                >
                <a
                  href
                  @click.prevent="goToPage('/signup/celebrity')"
                  class="btn btn-outline-light font-weight-bold rounded-pill mt-2 mt-sm-0"
                  >Sell Feet Pics, Worn Socks & Exclusive Content</a
                >
              </div>
              <!-- {{ loggedIn }} -->
              <div class="pt-4 header-paragraph" v-if="!loggedIn">
                Already have an account?
                <a
                  href
                  @click.prevent="goToPage('/signin')"
                  class="ff-alink2 border-0 font-weight-bold"
                  >Sign In!</a
                >
              </div>
            </div>
          </div>
          <div class="col-lg-6 d-lg-block d-none">
            <div class="desktop-outer-img d-flex justify-content-center">
              <img src="~/assets/images/png/feet-pics-order-stats.webp" alt="Overview of order statistics showing total purchases of feet pics and worn socks" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },

  name: "heroSection",

  data() {
    return {};
  },
  methods: {
    goToPage(page) {
      this.$router.push(page);
    },
  },
};
</script>
<style>
.hero-section-ff {
  margin-top: -13px;
}
.Main-Content-Area {
  top: 0px;
}

.main-text-area a {
  border: 3px solid white;
}

.main-text-area a:hover {
  color: var(--primary);
}

.content-svg {
  background-image: url("~/assets/images/png/exclusive-feet-picture.png");
  background-repeat: no-repeat;
  background-size: 26%;
  background-position: 20% 47%;
}

.content-svg i {
  width: 100%;
  height: 100%;
}

.content-svg svg {
  height: auto;
  width: 100%;
  transform: scaleX(1);
  overflow: hidden;
  vertical-align: middle;
}

.desktop-outer-img img {
  max-width: 90%;
  margin-top: 4rem;
  margin-right: 2rem;
}


@media only screen and (max-width: 470px) {
  .header-heading {
    font-size: 1rem !important;
  }

  .main-text-area a {
    font-size: 0.6rem !important; 
  }
}

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
  .main-text-area {
    padding-left: 0rem;
  }

  .header-heading {
    font-size: 1.3rem !important;
  }

  .main-text-area a {
    font-size: 0.6rem !important;
  }

  /* .main-left-side {
    } */
}

/* Small devices (portrait tablets and large phones, 600px and up) */
/* @media only screen and (min-width: 600px) {
    .main-text-area {
    }

    .main-left-side {
    }
} */

@media only screen and (max-width: 991px) {
  .Main-Content-Area {
    height: 440px !important;
    background-color: var(--primarylight) !important;
  }

  .content-svg {
    background-image: none;
  }

  .header-heading {
    font-size: 1.7rem;
  }

  .main-text-area a {
    font-size: 0.8rem;
  }

  .header-paragraph {
    color: #fff !important;
    font-size: 0.9rem;
  }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  .main-text-area {
    padding: 0rem 0rem 0rem 5rem;
  }

  .header-heading {
    font-size: 1.4rem !important;
  }

  .header-paragraph {
    color: #fff;
    font-size: 0.8rem !important;
  }

  .main-text-area a {
    font-size: 0.7rem;
  }

  /* .main-left-side {
    } */

  .Main-Content-Area {
    position: absolute;
  }
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
  .main-text-area {
    padding-left: 11.4rem;
  }

  .header-heading {
    font-size: 2rem !important;
  }

  .header-paragraph {
    color: #fff;
    font-size: 1rem !important;
  }

  .main-text-area a {
    font-size: 0.8rem !important;
  }

  /* .main-left-side {
    } */
}

@media only screen and (min-width: 1440px) {
  .main-text-area {
    padding-left: 14.4rem;
  }
}
</style>
