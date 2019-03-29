<template>
    <div>
        <ul>
            <li v-for="contact in contacts" @click="startConversationWith(contact)">
                {{contact.username}}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {

        props: {
            contacts: {
                type: Array,
                required: true
            }
        },

        data()
        {
            return {

            }
        },

        methods: {


            startConversationWith(contact)
            {
                this.selectedContact = contact;
                Event.$emit('contact-selected', contact);
            }

        }
    }
</script>

<style scoped>

</style>