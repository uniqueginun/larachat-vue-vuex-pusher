<template>
    <div>
        <div v-if="!amITheSender" class="d-flex justify-content-start mb-4">
            <div class="img_cont_msg">
                <img :src="selecteduser.profile" class="rounded-circle user_img_msg">
            </div>
            <div class="msg_cotainer">
                {{msg.body}}
                <span class="msg_time">{{msg.created_at}}</span>
            </div>
        </div>


        <div v-else class="d-flex justify-content-end mb-4">
            <div class="msg_cotainer_send">
                {{msg.body}}
                <span class="msg_time_send">{{msg.created_at}}</span>
            </div>
            <div class="img_cont_msg">
                <img :src="authuser.profile" class="rounded-circle user_img_msg">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['msg'],
    computed: {
        amITheSender() {
            let authuser = this.$store.getters.authuser;
            return (this.msg.from === authuser.id);
        },
        selecteduser() {
            return this.$store.getters.selecteduser;
        },
        authuser() {
            return this.$store.getters.authuser;
        }
    }
}
</script>

<style>
    
</style>
