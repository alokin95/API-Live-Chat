<template>
    <div>
    <form @submit.prevent>

        <h1 class="title">Register</h1>
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
            <input class="input is-success" type="password" placeholder="Enter password" value="" v-model="user.password">
            <span class="icon is-small is-left">
                    <i class="fas fa-unlock-alt"></i>
                </span>
            <span class="icon is-small is-right">
                  <i class="fas fa-unlock-alt"></i>
                </span>
        </div>
    </div>

    <div class="field">
        <label class="label">Confirm password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-success" type="password" placeholder="Repeat password" value="" v-model="user.password_confirmation">
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

    </form>
    <Login/>
</div>
</template>

<script>

    import Login from './Login';

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
                        $cookies.set('token', response.data.token);
                        self.$router.push('home');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },

        components: {
            Login
        }

    }
</script>

<style scoped>

</style>