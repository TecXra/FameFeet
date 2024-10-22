<template>
  <b-modal
    hide-footer
    hide-header
    centered
    :id="'moreinfo' + offersIndex"
    header-class="ff-heading-modal darken-3"
    content-class="ff-Sign-modal"
  >
    <section style="background-color: #f7f6f6; border-radius: 12px">
      <h4 class="pt-3 pl-2">Information</h4>
      <div class="my-3 text-dark">
        <div class="row d-flex justify-content-center pre-scrollable">
          <div class="col-md-12 col-lg-10 col-xl-11">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex flex-start">
                  <div class="w-100">
                    <div v-if="usertype == 1">
                      <b-table stacked class="text-left" :items="items">
                        <template #cell(age)>
                          <span class="" v-if="celebrity.show_age == 1">{{
                            age
                          }}</span>
                        </template>
                        <template #cell(footsize)>
                          <span class="" v-if="celebrity.feet_id != null">{{
                            celebrity.feet.size
                          }}</span>
                        </template>
                        <template #cell(gender)>
                          <span class="">{{ celebrity.feet.size }}</span>
                        </template>
                        <!-- <template #cell(experiance)>
                          <span class="">{{ 'profeshnal' }}</span>
                        </template>  -->
                        <template #cell(fun_fact)>
                          <span class="">{{ celebrity.fun_fact }}</span>
                        </template>
                        <template #cell(dislikes)>
                          <span class="">{{ celebrity.dislike }}</span>
                        </template>
                        <template #cell(likes)>
                          <span class="">{{ celebrity.like }}</span>
                        </template>
                      </b-table>
                    </div>
                    <div v-else>
                      <b-table stacked class="text-left" :items="itemsfan">
                        <template #cell(age)>
                          <span class="" v-if="showAge == 1">{{ age }}</span>
                        </template>
                        <template #cell(gender)>
                          <span class="">{{ gender }}</span>
                        </template>
                      </b-table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center">
        <b-button
          class="mt-1 mb-3 ff-btn1-pink border-0"
          @click="$bvModal.hide('moreinfo' + offersIndex)"
          >Close
        </b-button>
      </div>
    </section>
  </b-modal>
</template>

<script>
export default {
  name: "celeb-about",
  props: [
    "offersIndex",
    "gender",
    "celebrity",
    "age",
    "feetsize",
    "showAge",
    "feetshow",
    "usertype",
  ],

  data() {
    return {
      fields: [
        "age",
        "gender",
        "footsize",
        "experiance",
        "likes",
        "dislikes",
        "fun_fact",
      ],
      itemsfan: [{ age: "", gender: "" }],
      items: [{ age: "", footsize: "", likes: "", Dislikes: "", fun_fact: "" }],
    };
  },
};
</script>

<style lang="css" scoped></style>
