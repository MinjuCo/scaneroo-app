<template>
    <div class="screen">
        <div class="sticky-top top d-flex align-items-center justify-content-between">
            
            <router-link 
                :to="{ name: 'profile'}" event
                class="btn icon-md p-0 d-flex flex-row justify-content-center align-items-center back"
                :class="{'invisible': !showSettings}"
                @click.native.prevent="toggleProfile"
            >
                <i class="bi bi-chevron-left"></i>
            </router-link>
            <h1 v-if="showSettings">{{$t('Settings')}}</h1>
            <h1 v-else>{{$t('Profile')}}</h1>
            
            <router-link 
                :to="{ name: 'profile-screen', params: {screen: 'settings'}}" 
                class="btn p-0 d-flex flex-row justify-content-center align-items-center icon-md rounded-circle text-white bg-secondary"
                :class="{'invisible': showSettings}"
            >
                    <i class="bi bi-pencil-fill"></i>
            </router-link>
        </div>
        <div class="content">
            <div class="icon-lg avatar grid-mid grid-column-center rounded-circle bg-white shadow">
                <img :src="this.user.avatar" />
            </div>
            <h3 v-if="showSettings" class="text-center my-4">{{ this.user.username }}</h3>
            <h3 v-else class="text-center my-4">{{ this.user.xp }} XP</h3>
            <div class="card bg-primary mt-3">
                <div v-if="showSettings" class="card-body">
                    <div class="form-group">
                        <label for="name">{{ $t('My name') }}:</label>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 64 64">
                                <g id="_1" data-name="1" transform="translate(-54.14 -48)">
                                    <path id="Path_475" data-name="Path 475" d="M103.471,112a2.388,2.388,0,0,1-1.8-.816L89.063,96.771H64.409A10.281,10.281,0,0,1,54.14,86.5V58.27A10.281,10.281,0,0,1,64.409,48h43.463A10.281,10.281,0,0,1,118.14,58.27V86.5a10.281,10.281,0,0,1-10.269,10.27h-2.012v12.841A2.388,2.388,0,0,1,103.471,112ZM64.409,52.776a5.5,5.5,0,0,0-5.493,5.494V86.5a5.5,5.5,0,0,0,5.493,5.494H90.146a2.388,2.388,0,0,1,1.8.816l9.14,10.448V94.382a2.388,2.388,0,0,1,2.388-2.388h4.392a5.5,5.5,0,0,0,5.493-5.494V58.27a5.5,5.5,0,0,0-5.486-5.494Z"/>
                                    <path id="Path_476" data-name="Path 476" d="M186.993,238.779a2.409,2.409,0,0,1-1.692-.7c-.054-.056-.107-.115-.159-.175a2.284,2.284,0,0,1-.139-.188,2.127,2.127,0,0,1-.119-.2c-.037-.068-.07-.14-.1-.212s-.056-.146-.08-.22-.041-.159-.057-.228a2.181,2.181,0,0,1-.035-.231,2.336,2.336,0,0,1-.011-.236,2.283,2.283,0,0,1,.011-.234c.008-.078.021-.159.035-.232a1.952,1.952,0,0,1,.057-.226c.022-.067.049-.15.08-.221s.064-.142.1-.21a2.328,2.328,0,0,1,.119-.2c.043-.064.089-.127.139-.188a2.352,2.352,0,0,1,.159-.175,2.412,2.412,0,0,1,1.923-.688c.078.008.159.021.232.035a1.96,1.96,0,0,1,.226.057c.067.022.15.049.221.08s.142.064.21.1.137.076.2.119a2.281,2.281,0,0,1,.188.139,2.055,2.055,0,0,1,.174.159c.054.056.108.115.159.175a2.188,2.188,0,0,1,.139.188,2.328,2.328,0,0,1,.119.2q.056.1.1.21c.03.072.056.146.08.221a2.24,2.24,0,0,1,.057.226c.016.076.027.159.035.232a2.284,2.284,0,0,1,.011.234,1.68,1.68,0,0,1-.011.236c-.011.076-.021.159-.035.231a2.169,2.169,0,0,1-.057.228c-.022.068-.049.148-.08.22s-.064.143-.1.212-.076.135-.119.2-.091.127-.139.188a2.047,2.047,0,0,1-.159.175c-.056.056-.113.108-.174.159a2.188,2.188,0,0,1-.188.139,2.317,2.317,0,0,1-.2.119q-.1.055-.21.1c-.072.03-.146.056-.221.08a2.245,2.245,0,0,1-.226.057c-.076.016-.159.027-.232.035A2.189,2.189,0,0,1,186.993,238.779Z" transform="translate(-109.69 -156.391)"/>
                                    <path id="Path_477" data-name="Path 477" d="M298.02,238.761a1.624,1.624,0,0,1-.234-.011c-.075-.011-.159-.021-.232-.035a2.064,2.064,0,0,1-.228-.057c-.068-.022-.148-.049-.22-.08s-.142-.064-.21-.1a2.33,2.33,0,0,1-.2-.119c-.064-.043-.127-.089-.188-.139a2.353,2.353,0,0,1-.175-.159c-.056-.056-.108-.115-.159-.175a2.184,2.184,0,0,1-.138-.188,2.31,2.31,0,0,1-.119-.2q-.056-.1-.1-.21c-.03-.072-.056-.146-.08-.22s-.041-.159-.057-.228a2.177,2.177,0,0,1-.035-.231,2.276,2.276,0,0,1-.011-.236,1.669,1.669,0,0,1,.011-.236c.011-.076.021-.159.035-.231a2.171,2.171,0,0,1,.057-.228c.022-.068.049-.148.08-.22s.064-.143.1-.212.076-.135.119-.2a2.283,2.283,0,0,1,.138-.188,2.366,2.366,0,0,1,.159-.175c.056-.056.115-.108.175-.159a2.182,2.182,0,0,1,.188-.139,2.33,2.33,0,0,1,.2-.119q.1-.054.21-.1c.072-.03.146-.056.22-.08s.159-.041.228-.057a2.148,2.148,0,0,1,.232-.035,2.571,2.571,0,0,1,.47,0c.076.008.159.021.231.035a2.169,2.169,0,0,1,.228.057c.068.022.148.049.22.08s.142.064.21.1a2.325,2.325,0,0,1,.2.119c.064.043.127.089.188.139a2.362,2.362,0,0,1,.175.159c.056.056.108.115.159.175a2.283,2.283,0,0,1,.138.188q.064.1.119.2c.037.068.07.14.1.212s.056.146.08.22.041.159.057.228a2.177,2.177,0,0,1,.035.231,2.5,2.5,0,0,1,0,.478c-.008.076-.021.159-.035.231a2.169,2.169,0,0,1-.057.228c-.022.068-.049.148-.08.22s-.064.142-.1.21a2.31,2.31,0,0,1-.119.2c-.043.064-.089.127-.138.188s-.1.119-.159.175-.115.108-.175.159a2.185,2.185,0,0,1-.188.138,2.322,2.322,0,0,1-.2.119q-.1.054-.21.1c-.072.03-.146.056-.22.08a2.156,2.156,0,0,1-.228.057c-.076.016-.159.027-.231.035A2.293,2.293,0,0,1,298.02,238.761Z" transform="translate(-203.044 -156.373)"/>
                                    <path id="Path_478" data-name="Path 478" d="M242.518,238.759a2.323,2.323,0,0,1-.234-.011c-.078-.008-.159-.021-.232-.035s-.151-.035-.226-.057a2.122,2.122,0,0,1-.22-.08c-.072-.03-.143-.064-.212-.1a2.483,2.483,0,0,1-.39-.258,2.053,2.053,0,0,1-.174-.159,2.334,2.334,0,0,1-.159-.175c-.049-.06-.1-.124-.14-.188a2.328,2.328,0,0,1-.119-.2q-.054-.1-.1-.21c-.029-.072-.056-.146-.078-.221a2.14,2.14,0,0,1-.057-.226,2.3,2.3,0,0,1-.046-.466,2.332,2.332,0,0,1,.011-.236,2.306,2.306,0,0,1,.035-.231,2.274,2.274,0,0,1,.057-.228c.022-.073.049-.148.078-.22a2.114,2.114,0,0,1,.1-.21,2.325,2.325,0,0,1,.119-.2c.043-.064.091-.127.14-.188a2.337,2.337,0,0,1,.159-.175c.054-.054.113-.108.174-.159a2.481,2.481,0,0,1,.39-.258c.068-.037.14-.07.212-.1s.145-.056.22-.08.151-.041.226-.057.159-.027.232-.035a2.569,2.569,0,0,1,.478,0c.078.008.159.021.231.035a2.166,2.166,0,0,1,.228.057c.068.022.148.049.22.08s.143.064.212.1.135.076.2.119a2.31,2.31,0,0,1,.189.139,2.055,2.055,0,0,1,.174.159,2.337,2.337,0,0,1,.159.175c.049.061.1.124.14.188a2.322,2.322,0,0,1,.119.2,2.1,2.1,0,0,1,.1.21,2.27,2.27,0,0,1,.08.22c.022.075.041.159.057.228a2.38,2.38,0,0,1,0,.933,2.133,2.133,0,0,1-.057.226,2.164,2.164,0,0,1-.08.221,2.1,2.1,0,0,1-.1.21c-.037.068-.076.137-.119.2a2.3,2.3,0,0,1-.14.188,2.334,2.334,0,0,1-.159.175c-.054.054-.113.108-.174.159a2.313,2.313,0,0,1-.189.138q-.1.064-.2.119c-.068.037-.14.07-.212.1s-.145.056-.22.08a2.266,2.266,0,0,1-.228.057c-.076.016-.159.027-.231.035A2.335,2.335,0,0,1,242.518,238.759Z" transform="translate(-156.38 -156.371)"/>
                                </g>
                            </svg>
                            {{ $t("I'm speaking") }}:
                        </label>
                        <multiselect v-model="selectedInterface" placeholder="Select language" label="name" track-by="lang_code" :options="interfaceOptions" :max-height="200" :show-labels="false" :searchable="false" :allow-empty="false">
                            <template slot="singleLabel" slot-scope="props"><img class="option__image mr-3" :src="props.option.icon" :alt="props.option.icon" width="40px" /><span class="option__desc"><span class="option__title">{{ props.option.name }}</span></span></template>
                            <template slot="option" slot-scope="props"><img class="option__image mr-3" :src="props.option.icon" :alt="props.option.icon" width="40px">
                            <div class="option__desc"><span class="option__title">{{ props.option.name }}</span></div>
                            </template>
                        </multiselect>
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
                        <multiselect v-model="selectedLearning" placeholder="Select language" label="name" track-by="trans_code" :options="learningOptions" :max-height="200" :show-labels="false" :searchable="false" :allow-empty="false">
                            <template slot="singleLabel" slot-scope="props"><img class="option__image mr-3" :src="props.option.icon" :alt="props.option.icon" width="40px" /><span class="option__desc"><span class="option__title">{{ props.option.name }}</span></span></template>
                            <template slot="option" slot-scope="props"><img class="option__image mr-3" :src="props.option.icon" :alt="props.option.icon" width="40px">
                            <div class="option__desc"><span class="option__title">{{ props.option.name }}</span></div>
                            </template>
                        </multiselect>
                    </div>
                    <button @click="update()" class="btn btn-lg btn-primary btn-block">{{ $t('Change') }}</button>
                </div>
                <div v-else class="card-body">
                    <div class="badge-group">
                        <div v-for="badge in userBadges" class="achievement-badge" v-bind:key="badge.id">
                            <img :src="badge.picture" :alt="badge.title">
                        </div>
                        <div v-for="index in 12 - userBadges.length" class="achievement-badge" v-bind:key="index + 'e'">
                            <img src="/img/Kangoo_-_gray.svg" alt="Badge">
                        </div>
                    </div>
                </div>
            </div>

            <a v-if="showSettings" :href="'/logout'" class="btn btn-lg btn-outline-primary btn-block mt-4">{{ $t("Sign out") }}</a>
        </div>
        <main-menu :video="showVideo" />
    </div>
</template>

<script>
import MainMenu from '../components/Main-menu';

    export default {
        name: 'profile',
        components: {
            MainMenu,
        },
        data() {
            return {
                showVideo: false,
                user: this.$user,
                showSettings: false,
                name: '',
                birthday: '',
                emailNotValid: false,
                nameNotValid: false,
                birthdayNotValid: false,
                selectedInterface: [],
                interfaceOptions: [],
                selectedLearning: [],
                learningOptions: [],
                userBadges: [],
            };
        },
        beforeMount () {
            localStorage.removeItem('userData');
        },
        mounted () {
            this.loadLanguages();
            this.name = this.user.name;
            this.birthday = this.user.birthday;
            this.loadUserBadges();
            this.showSettings = (this.$route.params.screen == "settings") ? true : false;
        },
        watch: {
            '$route'() {
                this.showSettings = (this.$route.params.screen == "settings") ? true : false;
            }
        },
        methods: {
            loadLanguages() {
                this.$http.get('/api/languages/interface')
                    .then(response => {
                        this.interfaceOptions = response.data;
                        this.selectedInterface = this.interfaceOptions.find(x => x.lang_code == this.user.interface_lang);
                    });

                this.$http.get('/api/languages/learning')
                    .then(response => {
                        this.learningOptions = response.data;
                        this.selectedLearning = this.learningOptions.find(x => x.trans_code == this.user.learning_lang);
                    });
            },

            loadUserBadges(){
                this.$http.get('/api/user/badges/' + this.user.id)
                    .then(response => {
                        this.userBadges = response.data;
                    });
            },

            toggleProfile() {
                if(this.name != this.user.name){
                    if (confirm("Changes will be lost. Want to go back?")) {
                        this.showSettings = false;
                        this.name = this.user.name;
                        this.birthday = this.user.birthday;
                        this.selectedLearning = this.learningOptions.find(x => x.trans_code == this.user.learning_lang);
                        this.selectedInterface = this.interfaceOptions.find(x => x.lang_code == this.user.interface_lang);
                        this.$router.push('/profile')
                    }
                }else{
                    this.showSettings = false;
                    this.$router.push('/profile')
                }
            },

            toggleSettings() {
                this.showSettings = true;
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
                    case 'email':
                        var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                        if (!this.email.trim().match(emailRegex)){
                            error = "Please enter a valid email.";
                        }
                        this.emailNotValid = (error != '') ? true: false;
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

            update() {
                this.validate('name');
                this.validate('birthday');
                let data = {
                    name: this.name,
                    birthday: this.birthday,
                    learning_lang: this.selectedLearning.trans_code,
                    interface_lang: this.selectedInterface.lang_code
                };

                if(!this.nameNotValid && !this.birthdayNotValid) {
                    this.$http.post('/api/user/update/'+this.user.id, data)
                    .then(response => {
                        if(response.status == 200){
                            alert(response.data);
                            this.$router.push('/profile/settings')
                        }else{
                            alert(response.data.message);
                        }
                    }).catch(error => {
                        alert("There was an servor error!");
                        console.log(error);
                    });
                }

            },
        }
    }
</script>