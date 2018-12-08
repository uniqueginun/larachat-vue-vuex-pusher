<template>
    <li @click="setAsSelected" :class="isSelected ? 'active' : ''">
        <div class="d-flex bd-highlight">
            <div class="img_cont">
                <img :src="contact.profile" class="rounded-circle user_img">
                <span :class="[!isOnline ? 'offline' : '', 'online_icon']"></span>
            </div>
            <div class="user_info">
                <span> {{ name }} </span> <span v-if="unread > 0" class="badge badge-danger"> {{ unread }} </span>
                <p v-if="isTyping"> {{ first_name }} is typing...</p>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    props: ['contact'],
    computed: {
        unread() {
            return this.contact.unread_count;
        },
        first_name() {
            let name = this.contact.name;
            return name.split(' ')[0];
        },
        name() {
            let name = this.contact.name.split(' ');
            return name[0] + ' ' + name[1];
        },
        selecteduser() {
            return this.$store.getters.selecteduser;
        },
        isSelected() {
            let selected = this.selecteduser;
            if(!selected) {
                return false;
            }
            return (this.contact.id === selected.id);
        },
        isTyping() {
            let list = this.$store.getters.typingUsers;
            if(list.length == 0) {
                return false;
            }
            let exist = list.find(u => {
                return u.id == this.contact.id
            })
            return exist;
        },
        isOnline() {
            let onlineusers = this.$store.getters.onlineusers;
            if(onlineusers.length == 0) {
                return false;
            }
            let online = onlineusers.find(u => {
                return u.id == this.contact.id
            })
            return online;
        }
    },
    methods: {
        setAsSelected() {
            this.$store.commit('setselecteduser', this.contact);
            this.$store.commit('setconversation', this.contact);
            this.$store.dispatch('unreadmessages', this.contact);
        }
    }
}
</script>

<style>
    li {
        cursor: pointer;
    }
    span.badge-danger {
        font-size: medium !important;
    }
</style>
