<script>

    export default {
        name: 'complete-profile',
        created() {
            this.loadLanguages();
        },
        data() {
            return {
               userData: [],
               step: 'user-role',
               usernameNotValid: false,
               nameNotValid: false,
               birthdayNotValid: false,
               username: '',
               name: '',
               birthday: '',
               langOptions: [],
               selectedLang: [],
               learning_lang: 'en-gb',
               usernameUnique: '',
            };
        },
        mounted() {
            if (localStorage.userData) {
                    this.userData = JSON.parse(localStorage.getItem('userData'));
            }else{
                this.userData = this.$route.params.data.user;
                localStorage.setItem('userData', JSON.stringify(this.$route.params.data.user));
            }
            this.learning_lang = (this.userData.learning_lang)?this.userData.learning_lang: 'en-gb';
            this.name = this.userData.name;
            this.username = (this.userData.username) ? this.userData.username : '';
            this.birthday = (this.userData.birthday)? this.userData.birthday: '';
            this.step = (this.$route.params.step) ? this.$route.params.step : 'user-role';
            
        },

        computed: {
            user () {
                return this.userData;
            },

            complete() {
                return this.$route.params.status;
            }
        },
        watch: {
            '$route'() {
                this.step = (this.$route.params.step) ? this.$route.params.step : 'user-role';
            }
        },
        methods: {
            setUserRole(role) {
                this.userData['role'] = role;
                localStorage.setItem('userData', JSON.stringify(this.userData));
                this.$router.push({ name: 'complete-profile', params: { status: 'complete', step: 'create-kangoo'} })
            },

            validateUsername(str) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores
                str = str.trim();

                if (str == "") {
                    error = "Please enter a username.";
                    this.usernameUnique = "";
                } else if ((str.length < 5) || (str.length > 15)) {
                    error = "Username must have 5-15 characters.";
                    this.usernameUnique = "";
                } else if (illegalChars.test(str)) {
                    error = "Please enter valid username. Use only numbers and letters.";
                    this.usernameUnique = "";
                } else {
                    Promise.all([
                        this.checkUsername(this.username),
                    ]).then(() => {
                        this.usernameNotValid = (this.usernameUnique != '') ? true: false;
                    });
                    
                }
                
                return (this.usernameUnique != "")? this.usernameUnique : error;
            },

            validate(field) {
                let error = "";

                switch(field) {
                    case 'name':
                        if (this.name.trim() === ''){
                            error = "Please enter your name.";
                        }
                        this.nameNotValid = (error != '') ? true: false;
                        break;
                    case 'username':
                        error = this.validateUsername(this.username);
                        this.usernameNotValid = (error != '') ? true: false;
                        break;
                    case 'birthday':
                        if (this.birthday === ''){
                            error = "Please enter your birthday."
                        }
                        this.birthdayNotValid = (error != '') ? true: false;
                        break;
                }

                return error;
            },

            checkUsername(str) {
                return this.$http.get('/api/check-username/' + str)
                    .then(response => {
                        if(response.data.code == "AlreadyExists"){
                            this.usernameUnique = "Username is already in use.";
                        }else{
                            this.usernameUnique = "";
                        }
                });
            },

            setUsername(username) {
                this.validate('username');
                this.userData['username'] = username.trim();
                localStorage.setItem('userData', JSON.stringify(this.userData));

                setTimeout(() => {
                    if(!this.usernameNotValid){
                        this.$router.push({ name: 'complete-profile', params: { status: 'complete', step: 'fill-info'} });
                    }
                }, 500);
                
            },

            storeInfo() {
                this.userData['name'] = this.name.trim();
                this.userData['birthday'] = this.birthday;
                this.userData['learning_lang'] = this.selectedLang.trans_code;

                localStorage.setItem('userData', JSON.stringify(this.userData));
                
            },

            loadLanguages() {
                return this.$http.get('/api/languages/learning')
                    .then(response => {
                        this.langOptions = response.data;
                        this.selectedLang = this.langOptions.find(x => x.trans_code == this.learning_lang);
                    });
            },

            submitRegister() {
                this.storeInfo();

                if (this.name === '') this.nameNotValid = true;

                if (this.birthday === '') this.birthdayNotValid = true;

                if(!this.usernameNotValid && !this.nameNotValid && !this.birthdayNotValid) {
                    this.$http.post('/api/register', this.userData)
                    .then(response => {
                        if(response.status == 200){
                            window.location.href = "/home";
                        }
                    });
                }

            },
        }
    }
</script>

<template>
    <div class="screen" v-bind:class="{ 'screen-language': this.step == 'user-role' || this.step == 'fill-info', 'screen-login':  this.step == 'create-kangoo'}">
        <div class="header">
            <div class="bg-yellow">
                <h1 v-if="this.step == 'user-role'">
                    <router-link :to="{ name: 'login'}" :class="'text-body mr-4'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="58" viewBox="0 0 42 58">
                            <g id="Group_312" data-name="Group 312" transform="translate(-22 -63)">
                                <rect id="Rectangle_76" data-name="Rectangle 76" width="42" height="58" transform="translate(22 63)" fill="none"/>
                                <path id="iconfinder_left_arrow_back_previous_navigation_3994376" d="M29.765,25.5l11.425-9.52a2.251,2.251,0,1,0-2.883-3.458l-13.5,11.249a2.253,2.253,0,0,0,0,3.458l13.5,11.249a2.251,2.251,0,0,0,2.883-3.458Z" transform="translate(10 66.003)"/>
                            </g>
                        </svg>
                    </router-link>
                </h1>
                <h1 v-else-if="this.step == 'create-kangoo'">
                    <router-link :to="{ name: 'complete-profile', params: {status: 'complete', step: 'user-role'}}" :class="'text-body mr-4'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="58" viewBox="0 0 42 58">
                            <g id="Group_312" data-name="Group 312" transform="translate(-22 -63)">
                                <rect id="Rectangle_76" data-name="Rectangle 76" width="42" height="58" transform="translate(22 63)" fill="none"/>
                                <path id="iconfinder_left_arrow_back_previous_navigation_3994376" d="M29.765,25.5l11.425-9.52a2.251,2.251,0,1,0-2.883-3.458l-13.5,11.249a2.253,2.253,0,0,0,0,3.458l13.5,11.249a2.251,2.251,0,0,0,2.883-3.458Z" transform="translate(10 66.003)"/>
                            </g>
                        </svg>
                    </router-link>{{ $t("Create your Kangoo") }}
                </h1>
                <h1 v-if="this.step == 'fill-info'">
                    <router-link :to="{ name: 'complete-profile', params: {status: 'complete', step: 'create-kangoo'}}" :class="'text-body mr-4'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="58" viewBox="0 0 42 58">
                            <g id="Group_312" data-name="Group 312" transform="translate(-22 -63)">
                                <rect id="Rectangle_76" data-name="Rectangle 76" width="42" height="58" transform="translate(22 63)" fill="none"/>
                                <path id="iconfinder_left_arrow_back_previous_navigation_3994376" d="M29.765,25.5l11.425-9.52a2.251,2.251,0,1,0-2.883-3.458l-13.5,11.249a2.253,2.253,0,0,0,0,3.458l13.5,11.249a2.251,2.251,0,0,0,2.883-3.458Z" transform="translate(10 66.003)"/>
                            </g>
                        </svg>
                    </router-link>
                </h1>
                    <div class="thought" v-if="this.step == 'user-role' || this.step == 'fill-info'">{{ (this.step == 'user-role')? $t("Hi, I'm Kangoo! Who are you?") : $t("What's your name?") }}</div>
                    <img class="kangoo" v-if="this.step == 'user-role' || this.step == 'fill-info'" :src="'/img/Kangoo.svg'" />
            </div>
        </div>
        <div v-if="this.step == 'create-kangoo'" class="icon-lg icon-language grid-mid grid-column-center">
            <img :src="'/img/logo.png'" />
        </div>
        <div v-if="this.step == 'user-role'" class="form grid-column-center justify-content-end">
            <a class="btn btn-lg btn-block btn-primary text-left" @click="setUserRole(0)">
                <div class="w-25 d-inline-block text-center">
                    <img src="/img/icon/child.svg">
                </div>
                {{ $t('child') }}
            </a>
            <a class="btn btn-lg btn-block btn-rose disabled text-left">
                <div class="w-25 d-inline-block text-center">
                    <img src="/img/icon/parent.svg">
                </div>
                {{ $t('parent') }}
            </a>
            <a class="btn btn-lg btn-block btn-secondary disabled text-left">
                <div class="w-25 d-inline-block text-center">
                    <img src="/img/icon/teacher.svg">
                </div>
                {{ $t("teacher") }}
            </a>
        </div>
        <div v-else-if="this.step == 'create-kangoo'" class="form grid-column-center" id="v-model-lang">
            <div class="form-group">
                <label for="username">{{ $t('username') }}:</label>
                <input @blur="validate('username')" type="text" class="form-control" id="username" v-bind:class="{'is-invalid': usernameNotValid }" v-model="username">
                <div v-if="usernameNotValid" class="invalid-feedback">
                    {{ $t(this.validate('username')) }}
                </div>
            </div>
            <a @click="setUsername(username)" class="btn btn-lg btn-primary btn-next"><i class="bi bi-caret-right-fill"></i></a>
        </div>
        <div v-else-if="this.step == 'fill-info'" class="form form-block grid-column-center shadow">
            <div class="form-content">
                <div class="icon-lg avatar grid-mid grid-column-center rounded-circle bg-white shadow">
                    <img :src="this.user.avatar" />
                </div>
                <div class="form-group">
                    <input @blur="validate('name')" type="text" class="form-control" v-bind:class="{'is-invalid': nameNotValid}" id="name" v-model="name" required>
                    <div v-if="nameNotValid" class="invalid-feedback">
                        {{ $t(this.validate('name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="birthday">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path id="iconfinder_birthday-cake_1608875" d="M24,18.857V24H0V18.857a3.421,3.421,0,0,0,1.138-.187,3.312,3.312,0,0,0,.79-.368q.254-.181.629-.5a3.461,3.461,0,0,1,.69-.509A1.666,1.666,0,0,1,4,17.143a1.58,1.58,0,0,1,.743.147,4.44,4.44,0,0,1,.7.509q.388.335.629.509a3.2,3.2,0,0,0,.777.362,3.462,3.462,0,0,0,1.152.188,3.314,3.314,0,0,0,1.138-.194,3.585,3.585,0,0,0,.777-.362q.241-.167.643-.5A4.862,4.862,0,0,1,11,17.438a1.8,1.8,0,0,1,.415-.2A1.715,1.715,0,0,1,12,17.143a1.666,1.666,0,0,1,.757.147,3.461,3.461,0,0,1,.69.509q.375.321.629.5a3.312,3.312,0,0,0,.79.368,3.55,3.55,0,0,0,2.277,0,3.312,3.312,0,0,0,.79-.368q.254-.181.629-.5a3.461,3.461,0,0,1,.69-.509,1.666,1.666,0,0,1,.757-.147,1.631,1.631,0,0,1,.743.147,3.461,3.461,0,0,1,.69.509q.375.321.629.5a3.312,3.312,0,0,0,.79.368A3.421,3.421,0,0,0,24,18.857Zm0-4.286v2.571A1.581,1.581,0,0,1,23.257,17a4.44,4.44,0,0,1-.7-.509q-.388-.335-.629-.509a3.2,3.2,0,0,0-.777-.362,3.421,3.421,0,0,0-1.138-.187,3.462,3.462,0,0,0-1.152.188,3.2,3.2,0,0,0-.777.362q-.241.174-.629.509-.295.254-.442.362a1.635,1.635,0,0,1-.415.2,1.773,1.773,0,0,1-.589.094A1.666,1.666,0,0,1,15.248,17a3.461,3.461,0,0,1-.69-.509q-.388-.335-.629-.509a3.2,3.2,0,0,0-.777-.362A3.462,3.462,0,0,0,12,15.429a3.315,3.315,0,0,0-1.138.194,3.585,3.585,0,0,0-.777.362q-.241.167-.643.5a4.861,4.861,0,0,1-.435.362,1.8,1.8,0,0,1-.415.2,1.715,1.715,0,0,1-.583.094A1.666,1.666,0,0,1,7.252,17a3.461,3.461,0,0,1-.69-.509q-.375-.321-.629-.5a3.312,3.312,0,0,0-.79-.368A3.421,3.421,0,0,0,4,15.429a3.462,3.462,0,0,0-1.152.188,3.2,3.2,0,0,0-.777.362q-.241.174-.629.509A3.461,3.461,0,0,1,.757,17,1.666,1.666,0,0,1,0,17.143V14.571A2.48,2.48,0,0,1,.75,12.75,2.48,2.48,0,0,1,2.571,12h.857V6H6.857v6h3.429V6h3.429v6h3.429V6h3.429v6h.857A2.561,2.561,0,0,1,24,14.571ZM6.857,3a2.35,2.35,0,0,1-.482,1.587,1.558,1.558,0,0,1-1.232.556,1.652,1.652,0,0,1-1.212-.5,1.652,1.652,0,0,1-.5-1.212,1.71,1.71,0,0,1,.127-.683,1.229,1.229,0,0,1,.315-.455q.188-.161.415-.375T4.7,1.493A1.651,1.651,0,0,0,5.016.9,2.883,2.883,0,0,0,5.143,0q.509,0,1.112.991A3.829,3.829,0,0,1,6.857,3Zm6.857,0a2.35,2.35,0,0,1-.482,1.587A1.558,1.558,0,0,1,12,5.143a1.652,1.652,0,0,1-1.212-.5,1.652,1.652,0,0,1-.5-1.212,1.71,1.71,0,0,1,.127-.683,1.229,1.229,0,0,1,.315-.455q.187-.161.415-.375t.415-.422a1.651,1.651,0,0,0,.315-.6A2.883,2.883,0,0,0,12,0q.509,0,1.112.991A3.829,3.829,0,0,1,13.714,3Zm6.857,0a2.35,2.35,0,0,1-.482,1.587,1.558,1.558,0,0,1-1.232.556,1.652,1.652,0,0,1-1.212-.5,1.652,1.652,0,0,1-.5-1.212,1.71,1.71,0,0,1,.127-.683,1.229,1.229,0,0,1,.315-.455q.188-.161.415-.375t.415-.422A1.651,1.651,0,0,0,18.73.9a2.883,2.883,0,0,0,.127-.9q.509,0,1.112.991A3.829,3.829,0,0,1,20.571,3Z"/>
                        </svg>
                        {{ $t('My birthday') }}
                        </label>
                    <input @blur="validate('birthday')" type="date" class="form-control" v-bind:class="{'is-invalid': birthdayNotValid}" id="birthday" v-model="birthday">
                    <div v-if="birthdayNotValid" class="invalid-feedback">
                        {{ $t(this.validate('birthday')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="learning-lang">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="28.577" viewBox="0 0 24 28.577">
                            <g id="reading-book" transform="translate(-41)">
                                <circle id="Ellipse_144" data-name="Ellipse 144" cx="4.744" cy="4.744" r="4.744" transform="translate(48.256)"/>
                                <path id="Path_618" data-name="Path 618" d="M149.168,181.515a6.405,6.405,0,0,1-6.972,0,9.758,9.758,0,0,0-3.035,1.854l6.521,2.445,6.521-2.445A9.757,9.757,0,0,0,149.168,181.515Z" transform="translate(-92.682 -171.384)"/>
                                <path id="Path_619" data-name="Path 619" d="M412.4,310h-.558a.837.837,0,0,0-.837.837v2.233a.837.837,0,0,0,.837.837h.558a1.953,1.953,0,1,0,0-3.907Z" transform="translate(-349.349 -292.698)"/>
                                <path id="Path_620" data-name="Path 620" d="M81.36,231.753a.837.837,0,0,0-.36.688V234.3h.279a2.514,2.514,0,0,1,2.512,2.512v2.233a2.514,2.514,0,0,1-2.512,2.512H81v1.764a.837.837,0,0,0,.543.784l8.387,3.145V234.582l-7.8-2.925A.837.837,0,0,0,81.36,231.753Z" transform="translate(-37.767 -218.677)"/>
                                <path id="Path_621" data-name="Path 621" d="M277.14,239.049v-2.233a2.514,2.514,0,0,1,2.512-2.512h.279v-1.864a.837.837,0,0,0-1.131-.784l-7.8,2.925v12.672l8.387-3.145a.837.837,0,0,0,.543-.784v-1.764h-.279a2.514,2.514,0,0,1-2.512-2.512Z" transform="translate(-217.163 -218.677)"/>
                                <path id="Path_622" data-name="Path 622" d="M44.349,313.07v-2.233a.837.837,0,0,0-.837-.837h-.558a1.953,1.953,0,1,0,0,3.907h.558A.837.837,0,0,0,44.349,313.07Z" transform="translate(0 -292.698)"/>
                            </g>
                        </svg>
                        {{ $t("I'm learning") }}:
                    </label>
                    <multiselect v-model="selectedLang" placeholder="Select language" label="name" track-by="trans_code" :options="langOptions" :max-height="200" :show-labels="false" :searchable="false" :allow-empty="false" @close="storeInfo">
                        <template slot="singleLabel" slot-scope="props"><img class="option__image mr-3" :src="props.option.icon" :alt="props.option.icon" width="40px" /><span class="option__desc"><span class="option__title">{{ props.option.name }}</span></span></template>
                        <template slot="option" slot-scope="props"><img class="option__image mr-3" :src="props.option.icon" :alt="props.option.icon" width="40px">
                        <div class="option__desc"><span class="option__title">{{ props.option.name }}</span></div>
                        </template>
                    </multiselect>
                </div>
                <button @click="submitRegister()" class="btn btn-lg btn-primary btn-next btn-block"><i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>