<template>
    <div>

    <div class="msg_history" ref="feed">
        <div class="incoming_msg" v-for="message in messages">
            <div class="received_msg">
                <div :class="{received_withd_msg : message.from == selectedContact.id, 'received_withd_msg_mine' : message.from != selectedContact.id}">
                    <p>{{message.message}}</p>
                    <span class="time_date"> {{message.created_at}}</span></div>
            </div>
        </div>

    </div>
    <div class="type_msg">
        <div class="input_msg_write">
            <input type="text" v-model="newMessage" class="write_msg"  @keydown.enter="sendMessage" placeholder="Type a message" />
            <button @click="sendMessage" class="msg_send_btn" type="button"><i class="far fa-paper-plane"></i></button>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: {
            selectedContact:{
                type: Object,
                required: true
            },
            messages: {
                type: Array,
                required: true
            }
        },

        data()
        {
            return {
                newMessage: ""
            }
        },

        methods: {

            scrollFeed()
            {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            },

            sendMessage()
            {
                let self = this;

                axios.post('api/messages', {
                    message: self.newMessage,
                    user: self.selectedContact
                })
                    .then(function(response)
                    {
                        Event.$emit('message-sent', response.data.message);
                    })
                    .catch(function(error)
                    {
                        console.log(error);
                    });

                this.newMessage = "";

            }
        },

        watch: {

            messages()
            {
                this.scrollFeed();
            },

            contact()
            {
                this.scrollFeed();
            }
        },
    }
</script>

<style scoped>


    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }
    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }
    .received_withd_msg p, .received_withd_msg_mine p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }
    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
        text-align: center;
    }
    .received_withd_msg { width: 57%; }
    .received_withd_msg_mine { width: 57%; float: right; }
    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 60%;
    }

    .sent_msg p {
        background: #05728f none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0; color:#fff;
        padding: 5px 10px 5px 12px;
        width:100%;
    }
    .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
    .sent_msg {
        float: right;
        width: 46%;
    }
    .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
    }

    .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
    .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
    }
    .messaging { padding: 0 0 50px 0;}
    .msg_history {
        height: 516px;
        overflow-y: auto;
    }
</style>