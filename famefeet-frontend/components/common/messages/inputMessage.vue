<template>
  <!-- Write Message Area -->
  <div class="writemessage">
    <div class="py-4 px-3 d-flex justify-content-between">
      <!-- {{chatinfo}} -->

      <b-form v-on:keyup.enter="sendMessage(chatinfo.conversation_id)" @submit.stop.prevent class="w-100 mr-2" v-if="chatinfo.deleted_at != null">
        <b-form-input id="writemessage" v-model="message" disabled="true" class="Famefeet-input-field mb-0 mr-2 bg-white" placeholder="This user account has been deleted. You can't send message to this user.">
        </b-form-input>
      </b-form>

      <b-form v-on:keyup.enter="sendMessage(chatinfo.conversation_id)" @submit.stop.prevent class="w-100 mr-2" v-else>
        <b-form-input id="writemessage" v-model="message" :disabled="chatinfo.conversation_id == null"
          class="Famefeet-input-field mb-0 mr-2 bg-white" placeholder="Type your message here...">
        </b-form-input>
      </b-form>


      <b-button class="chat-send-message-btn" @click="sendMessage(chatinfo.conversation_id)" :disabled="isSending || message.length < 1">
        <b-spinner v-if="isSending" small />
        <i class="fa fa-paper-plane" v-else></i>
      </b-button>
    </div>
    <!-- {{ chatinfo.conversation_id }} -->
  </div>
</template>

<script>
export default {

  name: "inputMessage",
  props: ["chatinfo","inputmessageclear"],
  data() {
    return {
      message: "",
      isSending: false,
    };
  },

  created() {
    this.$nuxt.$on('inputmessageclear', (e) => {
      this.message = "";

    })
  },

  methods: {
    async sendMessage(id) {
      if (!id || this.isSending || this.message.length < 1) {
        return;
      }

      this.isSending = true;


      var tempMessage = {
        message: this.message,
        created_at: new Date(),
        conversation_id: id,
        sender: {
          username: this.$auth.user.username,
          avatarURL: this.$auth.user.avatarURL,
        },
      };
      var payload = {
        receiver_id: this.chatinfo.userId,
        conversation_id: this.chatinfo.conversation_id,
        message: this.message,
      };
      var self = this;
      await this.$axios
        .$post("/auth/sendMessage", payload)
        .then(function (response) {
          self.$emit("sendrmessage", tempMessage);
        })
        .catch(function (error) {
          const object = error.response.data;
          for (const property in object) {
            self.$bvToast.toast(object[property], {
              title: "Warning",
              variant: "warning",
              solid: true,
            });
          }
        });
      self.message = "";

      self.$emit("sendMessageEvent");
      self.isSending = false; // Re-enable the button

    },
  },

};

</script>

<style>
.writemessage {
  position: absolute;
  background-color: #f7f8f9;
  border-top: 1px solid rgba(0, 0, 0, 0.125);
  bottom: 0;
  width: 100%;
}

.chat-send-message-btn {
  border-radius: 100%;
  background: var(--primary);
  border: 0;
  padding-left: 14px;
  padding-right: 14px;
}
</style>
