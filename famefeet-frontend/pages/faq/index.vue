<template>
  <div class="container-fluid px-0">
    <Loader v-show="isLoadershow"></Loader>
    <!-- <ff-navbar /> -->

    <div class="ff-faq text-center">
      <h2>Frequently Asked Questions</h2>
      <!-- <p class="ff-paragraph1">Get your questions answered quickly! Please email help@famefeet.com for more help!</p> -->
    </div>

    <div class="container">
      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-1 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left"
                >Can I use the platform only in the US?</span
              >
            </b-button>
          </div>
          <b-collapse id="accordion-1" accordion="my-accordion" role="tabpanel">
            <div class="card px-2 px-md-5 faq-body py-1 border-0">
              <b-card-text class="card-text"
                >Fame Feet is for users in most countries.
              </b-card-text>
            </div>
          </b-collapse>
        </div>
      </div>

      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-2 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left">How much money do I make?</span>
            </b-button>
          </div>
          <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
            <div class="card px-2 px-md-5 faq-body py-1 border-0">
              <b-card-text
                >Sellers make 80% from all revenue streams. For shipping,
                sellers receive 100%</b-card-text
              >
            </div>
          </b-collapse>
        </div>
      </div>

      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="no-body mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-3 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left">How do I sell worn socks? </span>
            </b-button>
          </div>
          <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
            <div class="card px-2 px-md-5 faq-body py-1 border-0">
              <b-card-text
                >Upload a clear picture of your worn socks to your Sock Shop and
                set your price.
              </b-card-text>
            </div>
          </b-collapse>
        </div>
      </div>

      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="no-body mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-4 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left">My phone number will be secure? </span>
            </b-button>
          </div>
          <b-collapse id="accordion-4" accordion="my-accordion" role="tabpanel">
            <div class="card px-2 px-md-5 faq-body py-2 border-0">
              <b-card-text
                >Yes. Your phone number is secure and will never be
                sold.</b-card-text
              >
            </div>
          </b-collapse>
        </div>
      </div>

      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="no-body mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-5 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left text-left faq_with"
                >To use the Fame Feet platform, do I need to be a certain age?
              </span>
            </b-button>
          </div>
          <b-collapse id="accordion-5" accordion="my-accordion" role="tabpanel">
            <div class="card px-2 px-md-5 faq-body py-2 border-0">
              <b-card-text>You must be at least 18 years of age. </b-card-text>
            </div>
          </b-collapse>
        </div>
      </div>

      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="no-body mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-6 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left"
                >Is the platform free to use for buyers and sellers?
              </span>
            </b-button>
          </div>
          <b-collapse id="accordion-6" accordion="my-accordion" role="tabpanel">
            <div class="card px-2 px-md-5 faq-body py-2 border-0">
              <b-card-text
                >The platform is 100% free to all users.
              </b-card-text>
            </div>
          </b-collapse>
        </div>
      </div>

      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="no-body mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-7 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left">Can I return purchase socks?</span>
            </b-button>
          </div>
          <b-collapse id="accordion-7" accordion="my-accordion" role="tabpanel">
            <div class="card faq-body px-5 py-2 border-0">
              <b-card-text
                >Unfortunately, no. All worn socks are non-returnable
                and non-refundable.</b-card-text
              >
            </div>
          </b-collapse>
        </div>
      </div>
      <div class="accordion px-0 px-md-5 py-1" role="tablist">
        <div class="no-body mb-1">
          <div class="p-1" role="tab">
            <b-button v-b-toggle:accordion-8 class="w-100 faq-btn rounded">
              <span class="when-open float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-up"
                ></b-icon> </span
              ><span class="when-closed float-right">
                <b-icon
                  class="rounded-circle ff-icon p-1 text-white"
                  icon="chevron-bar-down"
                ></b-icon>
              </span>
              <span class="float-left">How do I get paid? </span>
            </b-button>
          </div>
          <b-collapse id="accordion-8" accordion="my-accordion" role="tabpanel">
            <div class="card faq-body px-5 py-2 border-0">
              <b-card-text
                >Any sale goes instantly into your Fame Feet wallet. You then
                withdraw those funds to go directly into
                your bank account.</b-card-text
              >
            </div>
          </b-collapse>
        </div>
      </div>
    </div>

    <TopFooter></TopFooter>
  </div>
</template>

<script>
import Loader from "@/components/common/loader";
import TopFooter from "@/components/home/topFooter.vue";
export default {
  name: "faq",
  layout: "home",
  components: { TopFooter,Loader },

  data() {
    return {
      isLoadershow: true,
    };
  },
  mounted() {
    setTimeout(() => {
      this.isLoadershow = false;
    }, 2000); // Adjust the timeout duration as needed
  },
};
</script>

<style>
.ff-faq {
  margin-top: 2rem;
  padding: 1.5rem;
  color: #000;
  font-family: "Poppins", sans-serif;
}

.ff-faq h2 {
  font-size: 48px;
  font-weight: 700;
}

.collapsed > .when-open,
.not-collapsed > .when-closed {
  display: none;
}

.faq-btn {
  background-color: var(--secondary);
  box-shadow: rgb(28 27 27 / 45%) 0px 4px 29px -6px;
  border: solid 1px #fff !important;
  padding-top: 10px;
  padding-bottom: 10px;
}

.faq-btn:hover {
  background-color: var(--secondary);
  color: white;
}

.faq-btn:focus {
  background-color: var(--secondary);
  box-shadow: none;
}

.faq-btn:active {
  background-color: var(--secondary) !important;
}

.faq-body {
  background-color: #42a5f554 !important;
  margin-left: 5px;
  margin-right: 5px;
}


@media only screen and (max-width: 768px) {
  .ff-faq h2{
    font-size: 40px;
  }
  .card-text{
    font-size: 14px;
  }
}

@media only screen and (max-width: 600px) {
  .faq-btn {
    font-size: 10px;
  }
  .ff-faq h2{
    font-size: 26px;
  }
  .card-text{
    font-size: 10px;
  }
}
@media only screen and (max-width: 375px) {
  .faq_with {
    width: 240px;
  }
  .ff-faq h2{
    font-size: 22px;
  }
}

</style>
