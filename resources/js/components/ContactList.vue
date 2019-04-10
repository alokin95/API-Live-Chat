<template>

    <div class="container">
        <h3 class="username_user text-center">{{currentUser.username}}</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Contacts</h4>
                        </div>
                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar" placeholder="Search" @keyup="search" v-model="searchUser">
                                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span>
                            </div>
                        </div>
                    </div>

                    <div class="inbox_chat">
                        <div v-for="contact in contacts" class="chat_list" :class="{ active_chat : contact.id == selected.id}" @click="startConversationWith(contact)">
                            <div class="chat_people">
                                <div class="chat_ib">
                                    <h5>{{contact.username}}<span v-if="contact.sent_messages_count > 0"class="chat_unread">{{contact.sent_messages_count}}</span></h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <h1 class="chatting_with">{{selected.username}}</h1>
                <div class="mesgs">
                    <MessageFeed :selectedContact="selected" :messages="messages"/>
                </div>
            </div>


        </div>
    </div>
</template>

<script>

    import MessageFeed from './MessageFeed';

    export default {

        data()
        {
            return {
                currentUser: {},
                contacts: [],
                selected: {},
                messages: [],
                searchUser: ""
            }
        },

        methods: {

            search()
            {
                let self = this;

                axios.get('api/contacts?q='+self.searchUser, {
                })
                    .then(function (response)
                    {
                        self.contacts = response.data.contacts;
                    })
                    .catch(function (error){

                    });
            },

            getAuthUser()
            {
                let self = this;

                axios.get('api/auth', {
                    token: $cookies.get('token')
                })
                .then(function (response) {
                    self.currentUser = response.data.user;

                    self.listenChannel();
                })
            },

            loadContacts() {
                let self = this;

                axios.get('api/contacts?token='+$cookies.get('token'), {

                })
                    .then(function (response) {
                        self.contacts = response.data.contacts;

                        self.selected = response.data.contacts[0];

                        self.updateReadCount(self.selected.id, true);

                        self.loadMessages(self.selected.id);

                    })
            },

            startConversationWith(contact)
            {
                this.selected = contact;

                this.updateReadCount(contact.id, true);

                this.loadMessages(contact.id);
            },

            loadMessages(contactId)
            {
                let self = this;


                axios.get('api/messages?user='+contactId+'&token='+$cookies.get('token'), {

                })
                    .then(function (response) {
                        self.messages = response.data.messages;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },

            playSound ()
            {
                let audio = new Audio('http://soundbible.com/mp3/Air Plane Ding-SoundBible.com-496729130.mp3');
                audio.play();
            },

            saveNewMessage(message)
            {
                this.messages.push(message);
            },

            handleIncomingMessages(message)
            {
                this.playSound();
                if (message.from == this.selected.id)
                {
                    this.saveNewMessage(message);
                    return;
                }

                this.updateReadCount(message.from);
            },

            updateReadCount(sender, reset = false)
            {
              this.contacts = this.contacts.map((singleContact) => {
                  if (singleContact.id != sender)
                  {
                      return singleContact;
                  }

                  if (reset)
                  {
                      singleContact.sent_messages_count = 0;
                      return singleContact;
                  }

                  singleContact.sent_messages_count+=1;
                  return singleContact;
              })
            },

            listenChannel()
            {
                window.Echo.private(`messages.${this.currentUser.id}`)
                    .listen('MessageSent', e => {
                        this.handleIncomingMessages(e.message);
                    });
            }

        },

        created() {

            let self = this;


            Event.$on('message-sent', function(e)
            {
                self.messages.push(e);
            });

            this.loadContacts();
            this.getAuthUser();

        },

        components:{
            MessageFeed
        }
    }
</script>

<style scoped>
    .username_user {
        height: 50px;
        text-align: center;
        padding-top: 1%;
        font-weight: bold;
        width: 40%;
    }

    .chatting_with{
        height: 50px;
        background-color: skyblue;
        text-align: center;
        padding-top: 1%;
        font-weight: bold;
    }

    .chat_unread {
        background-color: green;
        border-radius: 100px;
        width: 20px;
        height: 20px;
        text-align: center;
        font-weight: bold;
        color: blanchedalmond;
    }
    .container{max-width:1170px; margin:auto;}
    img{ max-width:100%;}
    .inbox_people {
        background: white none repeat scroll 0 0;
        float: left;
        overflow: hidden;
        width: 40%; border-right:1px solid #c4c4c4;
    }
    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }


    .recent_heading {float: left; width:40%;}
    .srch_bar {
        display: inline-block;
        text-align: right;
        width: 60%; padding:
    }
    .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

    .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
    }
    .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
    .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
    }
    .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

    .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
    .chat_ib h5 span{ font-size:13px; float:right;}
    .chat_ib p{ font-size:14px; color:#989898; margin:auto}
    .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
    }

    .chat_people{ overflow:hidden; clear:both; cursor: pointer;}
    .chat_list {
        cursor: pointer;
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
    }
    .inbox_chat { height: 550px; overflow-y: scroll;}

    .received_withd_msg p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }
    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 60%;
    }

</style>