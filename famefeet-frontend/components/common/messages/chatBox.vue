<template>
  <div class="box-body px-3 pt-3" ref="feed" v-if="loading">
      Loading....
  </div>
  <div class="box-body px-3 pt-3" ref="feed" v-else>
    <div class="direct-chat-messages" :class="!message_charges ? 'direct-chat-message-padding-12-rem' : 'direct-chat-message-padding-16-rem'" v-for="(messageGroup, date) in sortedMessages" :key="date">
      <div class="date-separator">
        <span>{{ date }}</span>
      </div>
      <div v-for="(message, index) in messageGroup" :key="index">
        <div class="direct-chat-msg left" v-if="message.receiver_id == user.id">
          <b-avatar class="direct-chat-img" :src="message.sender.avatarURL"></b-avatar>
          <div class="direct-chat-text">
            {{ message.message}}
          </div>
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp float-left mt-2 ml-2">
              {{ message.created_at | formatTime }}
            </span>
          </div>
        </div>
        <div class="mb-2" v-else>
          <div class="direct-chat-msg right">
            <b-avatar class="direct-chat-img" :src="message.sender.avatarURL"></b-avatar>
            <div class="direct-chat-text">
              {{ message.message }}
            </div>
          </div>
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp float-right mr-5">
              {{ message.created_at | formatTime }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import { mapState } from "vuex";
import moment from "moment";

export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
    sortedMessages() {
      let groupedMessages = {};
      this.messages.messages?.forEach((message) => {
  let createdAt = moment(message.created_at);
  let date;

  if (createdAt.isSame(moment(), 'day')) {
    // If the date is today, show only the time
    date = "Today";
  } else if (createdAt.isSame(moment().subtract(1, 'day'), 'day')) {
    // If the date is yesterday, show "Yesterday"
    date = "Yesterday";
  } else {
    // Otherwise, show the date
    date = createdAt.format("DD MMMM YYYY");
  }

  if (!groupedMessages[date]) {
    groupedMessages[date] = [];
  }
  groupedMessages[date].push(message);
});

      let sortedDates = Object.keys(groupedMessages).sort((a, b) =>
        moment(a, "MMMM Do, YYYY").diff(moment(b, "MMMM Do, YYYY"))
      );

      let sortedMessages = {};
      sortedDates?.forEach((date) => {
        sortedMessages[date] = groupedMessages[date];
      });

      return sortedMessages;
    },
  },
  name: "chatBox",
  // props: ["messages", "scrollevent","userInfo"],
  props: {
    messages: {
      type: Object,
    },
    userInfo: {
      type: Object,
      default: () => ({})
    },
    scrollevent:{
      type:Boolean
    },
    loading:{
      type:Boolean
    }
  },
  data() {
    return {
      message_charges:0
    };
  },
  mounted() {
    this.scrollToBottom();
    this.getCelebrityMessagePrice();
    let self = this;
    this.$nuxt.$on('updateMessagePriceEventCallback', (e) => {
      if(self.userInfo.userId == e.data.userId){
        self.message_charges = e.data.messagePrice;
      }
    });

  },
  methods: {
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.feed.scrollTop =
          this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
      }, 10);
    },
    async getCelebrityMessagePrice(){
      var self = this;
      await this.$axios
        .$get("/getCelebrityMessagePrice?cu_id="+self.userInfo.userId)
        .then(function (response) {
          self.message_charges = response;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        }); 
    },
  },
  watch: {
    messages(messages) {
      this.scrollToBottom();
    },
    scrollevent(scrollevent) {
      this.scrollToBottom();
    },
    userInfo: {
      handler(newVal, oldVal) {
        this.getCelebrityMessagePrice();
      },
      deep: true
    }
  },
};
</script>

<style>
.box-body {
  overflow-y: auto;
  overflow-x: hidden;
  max-height: 100%;
}

.right.direct-chat-msg {
  margin-bottom: 7px;
}

.direct-chat-messages:last-child {
  padding-bottom: 12rem;
}

.direct-chat-msg,
.direct-chat-text {
  display: block;
}

.direct-chat-info {
  display: block;
  /* margin-bottom: 2px; */
  font-size: 12px;
}

.direct-chat-timestamp {
  color: #999;
}

.direct-chat-img {
  border-radius: 50%;
  float: left;
  width: 40px;
  height: 40px;
}

.direct-chat-text {
  border-radius: 5px;
  position: relative;
  padding: 5px 10px;
  background: #d2d6de;
  border: 1px solid #d2d6de;
  margin: 5px 0 0 50px;
  color: #444;
  max-width: 50%;
}

.direct-chat-msg,
.direct-chat-text {
  display: block;
}

.direct-chat-text:after,
.direct-chat-text:before {
  position: absolute;
  right: 100%;
  top: 15px;
  border: solid transparent;
  border-right-color: #d2d6de;
  content: " ";
  height: 0;
  width: 0;
  pointer-events: none;
}

.direct-chat-msg:after {
  clear: both;
}

.direct-chat-msg:after {
  content: " ";
  display: table;
}

.right .direct-chat-img {
  float: right;
}

.right>.direct-chat-text {
  background: var(--primary);
  border-color: var(--primary);
  color: #fff;
  float: right;
}

.right>.direct-chat-text:after,
.right>.direct-chat-text:before {
  position: absolute;
  left: 100%;
  top: 15px;
  border: solid transparent;
  border-right-color: var(--primary);
  content: " ";
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  transform: rotate(180deg);
  height: 0;
  width: 0;
  pointer-events: none;
}

.right .direct-chat-text {
  margin-right: 10px;
  margin-left: 0;
}

 @media (max-width: 992px) {
  .direct-chat-message-padding-12-rem:last-child {
    padding-bottom: 12rem !important;

  }
  
  .direct-chat-message-padding-16-rem:last-child {
    padding-bottom: 16rem;
  }
}

.date-separator {
  text-align: center;
  margin: 10px 0;
  font-weight: bold;
  color: #555;
}
/* @media (max-width: 640px) {
  .box-body {
    max-height: 66vh;
  }
}
@media (min-width: 640px) {
  .box-body {
    max-height: 66vh;
  }
}

@media (min-width: 768px) {
  .box-body {
    max-height: 66vh;
  }
}

@media (min-width: 1024px) {
  .box-body {
    max-height: 9;
  }
}

@media (min-width: 1280px) {
  .box-body {
    max-height: 9;
  }
} */
</style>
