<template>
     <div class="card-footer">
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text attach_btn"></span>
            </div>
            <input type="text" class="form-control type_msg" v-model="text" @blur="stopped" @keydown.enter="send" placeholder="say somthing to {{selectedUser.name}}"/>
            <div class="input-group-append">
                <span class="input-group-text send_btn"><i @click="send" class="fas fa-location-arrow"></i></span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            text: ''
        }
    },
    computed: {
        selecteduser() {
            return this.$store.getters.selecteduser;
        }
    },
    methods: {
        send(e) {
            e.preventDefault();
            if(this.text) {
                this.$store.dispatch('sendnewmessage', this.text);
                this.text = '';
                setTimeout(() => {
                    this.fireTypingEvent(2); 
                }, 90);
            }
        },
        stopped() {
            this.fireTypingEvent(2); 
        },
        fireTypingEvent(type) {
            if(!this.selecteduser) {
                return;
            }
            let channel = Echo.private(`typing.${this.selecteduser.id}`);
            setTimeout(() =>
                channel.whisper('typing', {
                    user: this.$store.getters.authuser.id,
                    type: type
                })
            , 1000)
        }
    },
    watch: {
        text(val) {
            if(val.length > 2 && this.selecteduser) {
              this.fireTypingEvent(1);
            }
        }
    }
}
</script>

<style>

</style>
