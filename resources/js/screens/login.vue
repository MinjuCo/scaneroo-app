<script>
    export default {
        name: 'login',
        data() {
            return {
               username: '',
               password: '',
               error: '',
               usernameNotValid: false,
               passwordNotValid: false,
            };
        },
        beforeMount () {
            localStorage.removeItem('userData');
        },
        mounted() {
            //$('#error').modal('show')
        },
        methods: {
            AuthProvider(provider) {
                var self = this;
                this.$auth.authenticate(provider).then(response =>{
                   
                    self.SocialLogin(provider,response)

                }).catch(err => {
                    console.log({err:err})
                })
            },

            SocialLogin(provider, response) {
                this.$http.post('/auth/'+provider, response).then(response => {
                    if(!response.data.completed) this.$router.push({ name: 'complete-profile', params: { status: 'complete', step: 'user-role', data: response.data } });
                    if(response.data.completed){
                        window.authenticated = true;
                        window.location.href = "/home";
                    }

                }).catch(err => {
                    console.log({err:err})
                })
            },

            validate(field) {
                let error = "";

                switch(field) {
                    case 'username':
                        if (this.username.trim() == ""){
                            error = "Please enter a username.";
                        }
                        
                        this.usernameNotValid = (error != '') ? true: false;
                        break;
                    case 'password':
                        if (this.password.trim() == ""){
                            error = "Please enter a password.";
                        }
                        this.passwordNotValid = (error != '') ? true: false;
                        break;
                }

                return error;
            },

            login(){
                let loginInput = {};

                this.validate('username');
                this.validate('password');

                if(!this.usernameNotValid && !this.passwordNotValid) {
                    loginInput['username'] = this.username.trim();
                    loginInput['password'] = this.password.trim();
                    this.$http.post('api/login', loginInput).then(response => {
                        if(response.data == "Logged in"){
                            window.authenticated = true;
                            this.$router.push({ name: 'home'});
                        }else{
                            this.error = "Username and password are incorrect.";
                            $('#error').modal('show')
                        }
                    });
                }
            }
        }
    }
</script>

<template>
    <div class="screen screen-login">
        <div class="header">
            <div class="bg-yellow">
                <h1>
                    <a href="/choose-language" class="text-body mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="58" viewBox="0 0 42 58">
                            <g id="Group_312" data-name="Group 312" transform="translate(-22 -63)">
                                <rect id="Rectangle_76" data-name="Rectangle 76" width="42" height="58" transform="translate(22 63)" fill="none"/>
                                <path id="iconfinder_left_arrow_back_previous_navigation_3994376" d="M29.765,25.5l11.425-9.52a2.251,2.251,0,1,0-2.883-3.458l-13.5,11.249a2.253,2.253,0,0,0,0,3.458l13.5,11.249a2.251,2.251,0,0,0,2.883-3.458Z" transform="translate(10 66.003)"/>
                            </g>
                        </svg>
                    </a>{{ $t('Sign in') }}</h1>
            </div>
        </div>
        <div class="icon-lg icon-language grid-mid grid-column-center">
            <img :src="'/img/logo.png'" />
        </div>
        <div class="modal fade" id="error" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ $t('Attention') }}!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ $t(this.error) }}
                </div>
                </div>
            </div>
        </div>
        <div class="form grid-column-center" id="v-model-lang">
            <div class="form-group">
                <input @blur="validate('username')" type="text" class="form-control" id="username" v-bind:class="{'is-invalid': usernameNotValid }" v-model="username" :placeholder="$t('username')">
                <div v-if="usernameNotValid" class="invalid-feedback">
                    {{ $t(this.validate('username')) }}
                </div>
            </div>
            <div class="form-group mb-5">
                <input @blur="validate('password')" type="password" class="form-control" id="password" v-bind:class="{'is-invalid': passwordNotValid }" v-model="password" :placeholder="$t('password')">
                <div v-if="passwordNotValid" class="invalid-feedback">
                    {{ $t(this.validate('password')) }}
                </div>
            </div>
            <div class="btn-group btn-group-lg w-100" role="group">
                <a class="btn btn-lg btn-primary" @click="login()">{{ $t('Sign in') }}</a>
            <a class="btn btn-lg btn-light" @click="AuthProvider('google')"><img class="icon" src="/img/icon/google.svg" /></a>
            </div>
            
            <a class="btn btn-lg btn-block btn-outline-primary" href="/register">{{ $t("I don't have a Kangoo") }}</a>
        </div>
    </div>
</template>