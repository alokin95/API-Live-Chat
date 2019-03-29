<template>
    <div>
        <textarea @keydown.enter="sendMessage" v-model="message" class="textarea" placeholder="Start typing here..."></textarea>
        <a class="button is-info" @click="sendMessage">Send</a>
    </div>
</template>

<script>
    export default {
        props: {
            selectedContact: {
                type: Object
            }
        },

        data()
        {
            return {
                message: "",
            }
        },

        methods:{

            sendMessage()
            {
                let self = this;

                axios.post('api/messages', {
                    message: self.message,
                    user: self.selectedContact
                })
                    .then(function(response)
                    {
                        console.log(response);
                    })
                    .catch(function(error)
                    {
                        console.log(error);
                    });

                this.message = "";
            }

        }
    }
</script>

<style scoped>

</style>