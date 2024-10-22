<template>
  <div class="py-2 px-3 d-flex justify-content-between">
    <b-form-input
      id="search-area"
      v-model="searchtext"
      @input="$emit('searchQuery', $event)"
      class="Famefeet-input-field mb-0 mr-2 bg-white"
      placeholder="Search"
    >
    </b-form-input>
    <!-- Modal-User-List -->
    <!-- <div class="user-add" @click="showUsers()"> <i class="fa fa-plus"></i> </div> -->
    <b-modal
      hide-footer
      hide-header
      centered
      id="sub-users-modal"
      header-class="ff-heading-modal darken-3"
      content-class="ff-Sign-modal"
    >
      <section style="background-color: #f7f6f6; border-radius: 12px">
        <h4 class="pt-3 pl-2">Users List</h4>
        <div class="my-3 text-dark">
          <div class="row d-flex justify-content-center pre-scrollable">
            <div class="col-md-12 col-lg-10 col-xl-11">
              <!-- <div class="card mb-3 rounded-pill" v-for="item in 1" @click="createChat(2)"> -->
              <div
                class="card mb-3 rounded-pill"
                v-for="(item, index) in 1"
                :key="index"
              >
                <div class="card-body">
                  <div class="d-flex flex-start">
                    <b-avatar src="https://placekitten.com/320/320"></b-avatar>
                    <div class="w-100">
                      <div
                        class="d-flex justify-content-between align-items-center"
                      >
                        <h6
                          class="ml-2 fw-bold mb-0"
                          style="color: var(--primary)"
                        >
                          Aamir
                        </h6>
                        <!-- <p class="mb-0 small">{{20-20-22 | moment("from", true) }}</p> -->
                      </div>
                      <div class="ml-2">
                        <!-- {{item}} -->
                        <span class="text-dark mt-2">online</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{ paramsReceiverId }}
        <div class="text-center">
          <b-button
            class="mt-3 ff-btn1-pink border-0"
            @click="$bvModal.hide('sub-users-modal')"
            >Close
          </b-button>
        </div>
      </section>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "search",
  props: ["paramsReceiverId", "paramsReceiverMessages", "paramsReceiverCharges"],
  data() {
    return {
      users: [],
      searchtext: "",
    };
  },
  mounted() {
    // if (this.paramsReceiverId == null) {
    //   // alert("no value")
    // } else {
    //   this.createChat(this.paramsReceiverId);
    //   // alert(this.paramsReceiverId)
    // }
  },
  methods: {
    showUsers() {
      // this.$bvModal.show('sub-users-modal')
    },
    async createChat(id) {
      console.log('createChat search');
      var payload = {
        user_two: id,
        message: this.paramsReceiverMessages,
        charges: this.paramsReceiverCharges
      };
      var self = this;
      await this.$axios
        .$post("/auth/createConversation", payload)
        .then((response) => {
          this.$bvModal.hide("sub-users-modal");
          self.$emit("creatConversation", {
            conversation_id: response.conversation_id,
            receiver_id: response.receiver_id,
          });
            window.history.pushState({}, document.title, window.location.pathname);
          // console.log(response.id)
        });
      // self.$emit('creatConversation')
    },
  },
};
</script>

<style>
.user-add i {
  width: 45px;
  height: 45px;
  background: var(--primary);
  color: #ffffff;
  border-radius: 25px;
  text-align: center;
  line-height: 45px;
  font-size: 1.4rem;
  box-shadow: 0 0 4px 2px rgba(80, 80, 80, 0.1);
  cursor: pointer;
  transition: all 0.3s;
}

.user-add i:hover {
  transform: scale(1.05);
}
</style>
