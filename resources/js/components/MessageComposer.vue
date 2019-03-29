<template>
    <div>
        <textarea class="textarea" placeholder="Start typing here..."></textarea>
        <a class="button is-info">Info</a>
    </div>
</template>

<script>
    export default {
        props: {
            selectedContact: {
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>