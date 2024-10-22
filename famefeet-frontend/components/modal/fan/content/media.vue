<template>
  <b-modal
    hide-footer
    hide-header
    hide-header-close
    header-class="media-model-header"
    centered
    size="lg"
    :id="'media' + mediaId"
    content-class="ff-Sign-modal content-modal"
    class="mediashow-model"
    no-close-on-esc
    no-close-on-backdrop
  >
    <template #modal-title>
      <!-- <div class="model-footer-btns d-felx text-right">
				<b-button class="rounded-circle" @click="$bvModal.hide('media' + mediaId)">
					<i class="fas fa fa-times"></i>
				</b-button>
			</div> -->
    </template>
    <section>
      <div class="">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="card media-content-card">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <div class="w-100">
                    <!-- {{photomedia.lock_media}} -->
                    <div class="background-image-area">
                      <div class="model-footer-btns d-felx text-right">
                        <b-button
                          class="rounded-circle"
                          @click="$bvModal.hide('media' + mediaId)"
                        >
                          <i class="fas fa fa-times"></i>
                        </b-button>
                      </div>
                      <div class="media-lock" v-if="photomedia.lock_media == 1">
                        <i class="fi fi-rr-lock"></i>
                      </div>
                      <div>
                        <div
                          class="media-image"
                          :class="{
                            Imagelock:
                              (contentBlur && photomedia.lock_media == 1) ||
                              (photomedia.media.length == 1 &&
                                photomedia.lock_media == 1),
                          }"
                          :style="{ background: photomedia.media && photomedia.media[imageIndex]?.AppURL ? `url(${photomedia.media[imageIndex].AppURL})` : 'none' }"

                        ></div>
                      </div>
                    </div>
                    <div
                      class="text-dark mt-2 mb-0 d-flex align-content-center justify-content-center"
                    >
                      <i
                        class="mr-0 mr-sm-1 fi fi-rr-picture content-image-icon text-light"
                      ></i>
                      <span class="text-light content-count"
                        >{{ imageIndex + 1 }} of
                        {{ photomedia.media.length }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- {{ photomedia }} -->
      <div
        class="d-flex justify-content-center model-footer-btns"
        v-if="photomedia.media.length > 1"
      >
        <b-button
          class="mr-md-3 rounded-circle"
          @click="backPrev(photomedia.media)"
          :disabled="backbtnDisabled"
        >
          <i class="fas font-a fa fa-chevron-left"></i>
        </b-button>
        <b-button
          class="rounded-circle"
          @click="nextPrev(photomedia.media)"
          :disabled="nextbtnDisabled || photomedia.media.length == 1"
        >
          <i class="fas font-a fa fa-chevron-right"></i>
        </b-button>
      </div>
      <div class="py-3" v-else></div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "media",
  props: ["mediaId", "photomedia"],
  data() {
    return {
      imageIndex: 0,
      backbtnDisabled: true,
      nextbtnDisabled: false,
      contentBlur: false,
      contentshow: true,
    };
  },
  watch: {
    imageIndex(value) {
      if (this.imageIndex == 0) {
        this.backbtnDisabled = true;
        this.nextbtnDisabled = false;
      } else {
        this.backbtnDisabled = false;
      }
      if (this.imageIndex > 0) {
        // alert()
        this.contentBlur = true;
      } else {
        this.contentBlur = false;
      }
    },
  },
  mounted() {
    if (this.imageIndex > 1) {
      this.contentBlur = true;
    }
    // if (this.imageIndex < 0) {
    // 	// alert()
    // 	this.contentBlur = true
    // }
  },
  methods: {
    nextPrev(media) {
      this.imageIndex++;
      if (this.imageIndex == media.length - 1) {
        this.nextbtnDisabled = true;
      } else {
        this.nextbtnDisabled = false;
      }
    },
    backPrev() {
      this.imageIndex--;
      if (this.imageIndex == 0) {
        this.backbtnDisabled = true;
      } else {
        this.nextbtnDisabled = false;
      }
    },
  },
};
</script>

<style>
.background-image-area {
  border-radius: 10px;
  position: relative;
  overflow: hidden;
}

.background-image-area .model-footer-btns {
  position: absolute;
  right: 12px;
  top: 12px;
  z-index: 7;
}

.background-image-area .model-footer-btns i {
  vertical-align: middle;
}

.content-modal {
  background-color: transparent;
}

.media-image {
  background-position: center !important;
  background-size: cover !important;
  background-repeat: no-repeat !important;
  padding-top: 100%;
  margin-top: 3px;
  border-radius: 10px;
}

.Imagelock {
  filter: blur(20px);
  -webkit-filter: blur(20px);
  -moz-filter: blur(20px);
  -o-filter: blur(20px);
  -ms-filter: blur(20px);
}

.model-footer-btns button {
  background-color: var(--primary) !important;
  border: 0;
}

.media-content-card {
  border: 0;
  background-color: transparent !important;
}

.media-content-card .card-body {
  padding-bottom: 0 !important;
}

.model-footer-btns button .font-a {
  vertical-align: middle;
}

.media-model-header {
  display: flex;
  align-items: flex-start;
  /* justify-content: end; */
  padding: 0.4rem 0.5rem;
  border-bottom: 0;
  border-top-left-radius: calc(0.3rem - 1px);
  border-top-right-radius: calc(0.3rem - 1px);
}

.media-lock {
  position: absolute;
  top: 55%;
  left: 50%;
  transform: translate(-50%, -100%);
  background-color: rgba(0, 0, 0, 0.5);
  padding: 6px 12px 0px 12px;
  font-size: 2.5rem;
  border-radius: 100%;
  z-index: 200;
  font-weight: 700;
  color: aliceblue;
}

@media only screen and (max-width: 600px) {
  .media-lock {
    top: 60%;
  }
}
</style>
