<template>
    <div>

        <div class="field">
            <label class="label">Username</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-success" type="text" placeholder="Text input" value="" v-model="user.username">
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
                            <span class="icon is-small is-right">
                  <i class="fas fa-check"></i>
                </span>
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-success" type="text" placeholder="Enter password" value="" v-model="user.password">
                <span class="icon is-small is-left">
                    <i class="fas fa-unlock-alt"></i>
                </span>
                <span class="icon is-small is-right">
                  <i class="fas fa-unlock-alt"></i>
                </span>
            </div>
        </div>

        <div class="field">
            <label class="label">Repeat password</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-success" type="text" placeholder="Repeat password" value="" v-model="user.password_confirmation">
                <span class="icon is-small is-left">
                  <i class="fas fa-unlock-alt"></i>
                </span>
                <span class="icon is-small is-right">
                 <i class="fas fa-unlock-alt"></i>
                </span>
            </div>
        </div>


        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link" @click="register">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data()
        {
            return {
                user: {
                    username: "",
                    password: "",
                    password_confirmation: ""
                }
            }
        },

        methods:{
            register()
            {
                let self = this;
                axios.post('api/users', {
                    user: self.user
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }

    }
</script>

<style scoped>

</style>