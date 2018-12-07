<template>
     <div class="col-md-8 col-xl-6 chat">
        <div class="card">
            <div class="card-header msg_head">
                <div class="d-flex bd-highlight">
                    <div v-if="selecteduser" class="img_cont">
                        <img :src="selecteduser.profile" class="rounded-circle user_img">
                        <span class="online_icon"></span>
                    </div>
                    <div v-if="selecteduser" class="user_info">
                        <span>Chat with {{selecteduser.name}}</span>
                        <p> {{ conversation.length }} Messages</p>
                    </div>
                </div>
                <span v-if="selecteduser" @click="showDropDown" id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                <div v-if="dropdown" class="action_menu">
                    <ul>
                        <li><i class="fas fa-user-circle"></i> View profile</li>
                        <li><i class="fas fa-users"></i> Add to close friends</li>
                        <li><i class="fas fa-plus"></i> Add to group</li>
                        <li><i class="fas fa-ban"></i> Block</li>
                    </ul>
                </div>
            </div>
            <div ref="feed" class="card-body msg_card_body">
                <msg v-if="selecteduser" v-for="con in conversation" :key="con.id" :msg="con"></msg>
                <h4 v-if="!selecteduser" class="no-user">Select user to start chat</h4>
            </div>
            <span v-if="isTyping" class="typing-span">{{ selecteduser.name }} is typing...</span>
           <composer v-if="selecteduser"></composer>
        </div>
    </div>
</template>

<script>
import composer from './Composer';
import msg from './Msg';

export default {
    data() {
        return {
            dropdown: false
        }
    },
    computed: {
        conversation() {
            return this.$store.getters.conversation;
        },
        selecteduser() {
            return this.$store.getters.selecteduser;
        },
        isTyping() {
            let list = this.$store.getters.typingUsers;
            if(list.length == 0 || !this.selecteduser) {
                return false;
            }
            let exist = list.find(u => {
                return u.id == this.selecteduser.id
            })
            return exist;
        }
    },
    watch: {
        selecteduser(val) {
            this.scrollToBottom();
        },
        conversation(val) {
            this.scrollToBottom();
        }
    },
    methods: {
        showDropDown() {
            this.dropdown = !this.dropdown;
        },
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
            }, 50);
        }
    },
    components: {
        composer, msg
    },
    mounted() {
        
    }
}
</script>

<style>
    .no-user {
        font-size: 1.9rem;
        font-weight: 400;
        line-height: 1.6;
        color: aliceblue;
        text-align: -webkit-center;
    }
    .typing-span {
        color: yellow;
        padding: 14px;
    }
</style>
