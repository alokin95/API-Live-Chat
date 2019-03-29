<template>
    <div>
        <h1>Chat App</h1>
        <ContactList :contacts="contacts"/>
        <MessageComposer :selectedContact="selected"/>
    </div>
</template>

<script>

    import ContactList from './ContactList';
    import MessageComposer from './MessageComposer';

    export default {

        data()
        {
            return {
                contacts: [],
                selected: {}
            }
        },

        methods: {

            loadContacts() {
                let self = this;
                axios.get('api/contacts', {
                    token: $cookies.get('token')
                })
                    .then(function (response) {
                        self.contacts = response.data.contacts;

                        self.selected = response.data.contacts[0];
                    })
            },

        },

        created()
        {
          this.loadContacts();
          Event.$on('contact-selected', (selected) => {
              this.selected = selected;
          })
        },


        components: {
            ContactList,
            MessageComposer
        }
    }
</script>

<style scoped>

</style>