<template>
  <div class="h-100 mt-0 chat-main-screen">
    <!-- <div class="h-100"> -->
      <Loader v-if="is_Show"></Loader>
      <section class="h-100" v-if="!is_Show">
        <div class="h-100">
          <div class="chat-section card h-100">
            <div class="row m-0 h-100">
              <div
                class="col-12 col-lg-4 py-3 chat-users-area h-100"
                :class="{ userslistshow: opened }"
              >
                <Search
                  @searchQuery="searchQuery"
                >
                </Search>
                <Users
                  :selectedConversationId="paramsConversation"
                  :allUsers="allUsers"
                  :textsearch="textsearch"
                  @userinfo="userinfocallback"
                >
                </Users>
              </div>
              <div></div>
              <div
                class="col col-lg-8 px-0 messege-area h-100"
                :class="{ userslistshow: !opened && is_show_message }"
              >
                <div
                  class="d-flex justify-content-center align-items-center h-100"
                  v-if="messages_show"
                >
                  <div class="chat-right-side">
                    <i class="fi fi-rr-comment-alt"></i>
                    <h2 class="chat-right-heading">Your Messages</h2>
                    <p class="chat-right-text">Send messages to Celebrities.</p>
                  </div>
                </div>
                <TopHeader
                  :userInfo="userInfo"
                  :sideUsers="opened"
                  @sidebarHideShowEvent="sideBarHideShow"
                  v-if="!messages_show"
                ></TopHeader>

                <ChatBox
                  :messages="allMessages"
                  :scrollevent="scroll"
                  :userInfo="userInfo"
                  v-if="!messages_show"
                  :loading="loadingMessages"
                ></ChatBox>

                <WriteMsg
                  :chatinfo="userInfo"
                  v-if="!messages_show"
                  @sendrmessage="sendrmessage"
                >
                </WriteMsg>
              </div>
            </div>
          </div>
        </div>
      </section>

  </div>
</template>

<script>
import Loader from "@/components/common/loader";
import Search from "@/components/common/messages/search";
import ChatBox from "@/components/common/messages/chatBox";
import Users from "@/components/common/messages/usersList";
import TopHeader from "@/components/common/messages/headerArea";
import WriteMsg from "@/components/common/messages/inputMessage";

export default {
  name: "messages",
  layout: "fan",
  components: { Search, Users, TopHeader, WriteMsg, ChatBox, Loader },

  data() {
    return {
      allUsers: [],
      scroll: false,
      allMessages: {},
      userInfo: {
        is_online: false,
        avatarURL: null,
        userName: "",
        userId: null,
        conversation_id: null,
        receiver_id: null,
        message_charges: null,
        deleted_at: null
      },
      opened: false,
      messages_show: true,
      loadingMessages:false,
      is_Show: true,
      textsearch: "",
      is_show_message: true,
      paramsConversation:0
    };
  },
  beforeMount() {
    let params = new URLSearchParams(window.location.search);
    this.paramsConversation = params.get("conversation");
  },

  mounted() {

    window.addEventListener("resize", this.myEventHandler);
    this.getUsers();
        this.$nuxt.$on('userMessageEventCallback', (e) => {
          if (this.allMessages.id == e.message.conversation_id) {
            for (var i = 0; i < this.allUsers.length; i++) {
              if (e.message.conversation_id == this.allUsers[i].id) {
                this.allUsers[i].lastMessage.message = e.message.message;
                this.allUsers[i].lastMessage.created_at = e.message.created_at;
                this.allMessages.messages.push(e.message);
                break;
              }
            }
          } else {
            let foundFlag = false; 
            for (var i = 0; i < this.allUsers.length; i++) {
              if (e.message.conversation_id == this.allUsers[i].id) {
                foundFlag = true;
                this.allUsers[i].unreadcount++;
                this.allUsers[i].lastMessage.message = e.message.message;
                this.allUsers[i].lastMessage.created_at = e.message.created_at;
                break;
              }
            }
            if(!foundFlag){
              this.allUsers.push({
                id:e.message.conversation_id,
                unreadcount:1,
                lastMessage:{
                  message:e.message.message,
                  created_at:e.message.created_at
                },
                user:{
                  id:e.message.sender.id,
                  avatarURL:e.message.sender.avatarURL,
                  username:e.message.sender.username
                }
              });
            }
          }
          this.scroll = !this.scroll;
    })

    if (window.innerWidth >= 992) {
      this.is_show_message = false;
    }
  },
  methods: {
    myEventHandler() {
      if (window.innerWidth >= 992) {
        this.is_show_message = false;
        this.opened = false;
      } else {
        this.is_show_message = true;
        this.opened = true;

      }
    },
    sendrmessage(e) {
      this.allMessages.messages.push(e);
      for (var i = 0; i < this.allUsers.length; i++) {
        if (e.conversation_id == this.allUsers[i].id) {
          if(!this.allUsers[i].lastMessage){
            this.allUsers[i].lastMessage = {};
          }
          this.allUsers[i].lastMessage.message = e.message;
          this.allUsers[i].lastMessage.created_at = e.created_at;
        }
      }
      this.scroll = !this.scroll;
    },
    searchQuery(e) {
      this.textsearch = e;
    },

    sideBarHideShow(event) {
      this.opened = event;
    },
    
    userinfocallback(e) {
      if (this.is_show_message == true) {
        this.opened = true;
      }
      this.userInfo.is_online = e.is_online;
      this.userInfo.avatarURL = e.avatarURL;
      this.userInfo.userName = e.userName;
      this.userInfo.userId = e.userId;
      this.userInfo.conversation_id = e.conversation_id;
      this.userInfo.deleted_at = e.deleted_at;
      this.getMessages(e.conversation_id, e.usersArryIndex);     
    },

    resetQueryParams(){
      window.history.pushState({}, document.title, window.location.pathname);
      var params = new URLSearchParams(window.location.search);
      params.delete("conversation");
    },

    async getUsers() {
      var self = this;
      await this.$axios
        .$get("/auth/getAllConversation")
        .then(function (response) {
          self.is_Show = false;
          self.allUsers = response;
          if (self.paramsConversation != 0) {
            for (let index = 0; index < self.allUsers.length; index++) {
              if (self.paramsConversation == self.allUsers[index].id) {
                self.getMessages(self.paramsConversation);
                self.resetQueryParams();
                break;
              }
            }
          }
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
    async getMessages(id, index) {
      var newid = id;
      var self = this;
      this.allMessages = {};
      this.loadingMessages = true;

      await this.$axios
        .$get("/auth/getConversationMessages/" + newid)
        .then(function (response) {
          self.allMessages = response;
          self.messages_show = false;
          self.loadingMessages = false;

        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
      self.$nuxt.$emit("updateMsgCount");
      if (self.allUsers && self.allUsers[index]) {
          self.allUsers[index].unreadcount = "";
        }
    },
  },
};
</script>

<style>
.chat-right-side {
  display: flex;
  /* justify-content: center; */
  flex-direction: column;
  align-items: center;
}

.chat-right-side .fi {
  font-size: 40px;
  line-height: 1.2;
}

.chat-right-heading {
  font-size: 22px;
}

.chat-right-text {
  color: gray;
}

.userslistshow {
  display: none !important;
}

.chat-section {
  /* border-top: 4px solid var(--primary); */
  box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
}

.chat-users-area {
  background-color: #f7f8f9;
  /* border-radius: 20px 0px 0px 20px; */
  border-right: 1px solid rgba(0, 0, 0, 0.125);
  overflow: hidden;
}

.messege-area {
  border-radius: 0px 15px 0px 0px !important;
  overflow: hidden;
}

.messege-area .navbar {
  border-radius: 0px 15px 0px 0px !important;
}

.topbar {
  background-color: #f7f8f9;
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.messege-area .navbar h6 {
  font-weight: 700;
  font-size: 1.2rem;
}

.messege-area .navbar p {
  color: #6c757d;
  font-size: 14px;
}
.chat-main-screen {
  /* padding-top: 3.7rem; */
}
@media (max-width: 767px) {
  .chat-main-screen {
    /* padding-top: 4rem; */
  }
}
</style>
