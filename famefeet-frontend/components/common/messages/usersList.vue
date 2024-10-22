<template>
  <div class="user-list">
    <div
      class="single-User px-3 py-3 active d-flex justify-content-between w-100 "
      :class="{ activeuser: singleUser.isActive }"
      v-for="(singleUser, index) in filteredList"
      @click="singleUserData(singleUser,index)"
      :key="index"
    >
      <div class="d-flex single_user">
        <b-avatar
          :src="singleUser.user.avatarURL"
          badge
          badge-variant="success"
          class="mr-2 user_avater"
          size="4rem"
          variant="dark"
          v-if="isUserActive(singleUser.user.id)"
        >
        </b-avatar>
        <b-avatar
          :src="singleUser.user.avatarURL"
          badge
          badge-variant="danger"
          class="mr-2 user_avater"
          size="4rem"
          variant="dark"
          v-else
        >
        </b-avatar>
        <div class="d-flex flex-column w-100">
          <div class="d-flex">
            <div class="user_name">
              <h6 class="mt-2 mb-1">{{ singleUser.user.username }}</h6>
            </div>

            <div class="align-self-center float-right ml-2">
              <b-badge
                pill
                variant="primary"
                v-if="singleUser.unreadcount != ''"
              >
                {{ singleUser.unreadcount }}
              </b-badge>
            </div>
          </div>
          <div>
            <p class="text-muted text-break">
              {{ singleUser.lastMessage ? lastMessage(singleUser.lastMessage.message) : '' }}
            </p>
          </div>
        </div>
      </div>
       <div class="user-action-area" v-if="singleUser.lastMessage && singleUser.lastMessage.created_at">
         {{ singleUser.lastMessage.created_at | formatConverationTime }}
       </div>
      <div class="user-action-area" v-else>
        {{ singleUser.lastMessage ? singleUser.lastMessage.created_at : 'No message' }}
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    lastMessage: function () {
      return function (value) {
        if (value && value.length > 20) {
          value = value.substring(0, 20) + "...";
        }
        return value;
      };
    },

    filteredList() {
      return this.allUsers.filter((user) => {
        return user?.user?.username
          ?.toLowerCase()
          .includes(this.textsearch.toLowerCase());
      });
    },
  },
  name: "usersList",
  props: ["allUsers", "textsearch","selectedConversationId"],
  data() {
    return {
      isactive: false,

    };
  },
  mounted(){
    if(this.selectedConversationId !== null && this.selectedConversationId !== 0){
       for (let index = 0; index < this.allUsers.length; index++) {
        if (this.selectedConversationId == this.allUsers[index]?.id) {
                this.singleUserData(this.allUsers[index],index);
               break;
              }
            }
    }
  },
  watch: {
    allUsers: {
      handler(val, oldVal) {
        this.filteredList.sort(function compare(a, b) {
          var dateA = a.lastMessage ? new Date(a.lastMessage.created_at) : new Date(a.created_at);
          var dateB = b.lastMessage ? new Date(b.lastMessage.created_at) : new Date(b.created_at);
          return dateB - dateA;
        });
      },
      deep: true,
    },
  },
  methods: {
    singleUserData(conversation, index) {
      var is_online = conversation.user.is_online;
      var avatarURL = conversation.user.avatarURL;
      var userName = conversation.user.username;
      var userId = conversation.user.id;
      var usersArryIndex = index;
      var conversation_id = conversation.id;
      var deleted_at = deleted_at;
      localStorage.setItem("selectedConversationId", conversation.id);
      this.$emit("userinfo", {
        is_online,
        avatarURL,
        userName,
        conversation_id,
        userId,
        usersArryIndex,
        deleted_at
      });
      this.$nuxt.$emit("inputmessageclear", true);
      var vm = this;
      for (var i = 0; i < vm.allUsers.length; i++) {
        if (vm.allUsers[i]?.id == conversation?.id) {
          vm.allUsers[i].isActive = true;
        } else {
          vm.allUsers[i].isActive = false;
        }
      }
    },
  },
};
</script>

<style>
.user-action-area .btn {
  padding-left: 0px;
  padding-right: 0px;
  font-size: 12px;
}
.user-action-area{
  text-align: end;
  width: 35%;
  margin-top: 10px;
}
.single_user{
  width: 65%;
}

.activeuser {
  color: black;
  background-color: #d2d6de;
  border-radius: 5px;
  /* transition: 0.3s; */
  box-shadow: rgb(28 27 27 / 45%) 0px 4px 29px -6px;
}

.user-list {
  overflow-y: auto !important;
  height: 92% !important;
}

/* Hide scrollbar for Chrome, Safari and Opera */
/* .user-list::-webkit-scrollbar {
  display: none;
} */

/* Hide scrollbar for IE, Edge and Firefox */
.user-list {
  /* -ms-overflow-style: none; */
  /* IE and Edge */
  /* scrollbar-width: 50px; */
  /* Firefox */
}

.single-User {
  border: 1 px solid pink;
  box-shadow: inset 0px 0px 0px 1px transparent;
  margin-top: 3px;
  cursor: pointer;
  height:100px;
  overflow: hidden;
}

/* .chat-hr {
	margin-bottom: 3px;
	border-bottom: 2px solid#6c757d36;
  } */

.single-User p {
  color: #6c757d;
}

.single-User h6 {
  font-weight: 700;
  font-size: 1.2rem;
}

.single-User .b-avatar .b-avatar-badge {
  position: absolute;
  min-height: 1em;
  min-width: 1em;
  padding: 0.25em;
}
.user_name{
  word-break: break-word;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.b-avatar .b-avatar-badge{
  z-index: 0 !important;
}
@media only screen and (min-width: 320px) {
  .user_avater{
    width: 3rem !important;
    height: 3rem !important;

  }
  .single-User{
    padding-left: 0.5rem !important;
  }
}

</style>
