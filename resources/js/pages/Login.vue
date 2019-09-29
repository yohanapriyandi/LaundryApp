<template>
        <body class="login-page">
            <div class="login-box">
                <div class="login-logo">
                    <router-link :to="{ name: 'home' }"><b>YOHAN LAUNDRY</b></router-link>
                </div>
                <div class="login-box-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <div class="form-group has-feedback" :class="{'has-error': errors.email}">
                        <input type="email" class="form-control" placeholder="Email" v-model="data.email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                    </div>
                    <div class="form-group has-feedback" :class="{'has-error': errors.password}">
                        <input type="password" class="form-control" placeholder="Password" v-model="data.password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <p class="text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                    </div>
                    <div class="alert alert-danger" v-if="errors.invalid">{{ errors.invalid }}</div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" v-model="data.remember_me"> Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" @click.prevent="postLogin">Login</button>
                        </div>
                    </div>

                    <div class="social-auth-links text-center">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-social btn-google btn-flat">
                            <i class="fa fa-google"></i>
                            Sign in using Google
                        </a>
                        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat">
                            <i class="fa fa-facebook"></i>
                            Sign in using Facebook
                        </a>
                    </div>
                        <a href="#">I forgot my password</a><br>
                        <a href="#">Register a new membership</a>
                </div>
            </div>
        </body>


</template>

<script>
import { mapActions, mapMutations, mapGetters, mapState } from 'vuex';
export default {
    data() {
        return {
            data: {
                email: '',
                password: '',
                remember_me: false
            }
        }
    },
    created() {
        if (this.isAuth) {
            this.$router.push({ name: 'home'})
        }
    },
    computed: {
        ...mapGetters(['isAuth']),
        ...mapState(['errors'])
    },
    methods: {
        ...mapActions('auth', ['submit']),
        ...mapActions('user', ['getUserLogin']),
        ...mapMutations(['CLEAR_ERRORS']),
        postLogin() {
            this.submit(this.data).then(() => {

                if (this.isAuth) {
                    console.log(this.isAuth)
                    this.CLEAR_ERRORS()
                    this.$router.push({ name: 'home' })
                }
            })
        }
    },
    destroyed() {
        this.getUserLogin()
    }
}
</script>