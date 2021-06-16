<script>
    export default {
        name: 'register',
        data() {
            return {
               userData: {},
               step: 'user-role',
            };
        },
        mounted() {
            if (localStorage.userData) {
                    this.userData = JSON.parse(localStorage.getItem('userData'));;
            }

            this.step = (this.$route.params.step) ? this.$route.params.step : 'user-role';
            console.log(this.userData);
            
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

                this.$router.push({ name: 'register', params: { step: 'create-kangoo'} })
            }
        }
    }
</script>

<template>
    <div class="screen" v-bind:class="{ 'screen-language': this.step == 'user-role', 'screen-login':  this.step == 'create-kangoo'}">
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
                    <router-link :to="{ name: 'register', params: {step: 'user-role'}}" :class="'text-body mr-4'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="58" viewBox="0 0 42 58">
                            <g id="Group_312" data-name="Group 312" transform="translate(-22 -63)">
                                <rect id="Rectangle_76" data-name="Rectangle 76" width="42" height="58" transform="translate(22 63)" fill="none"/>
                                <path id="iconfinder_left_arrow_back_previous_navigation_3994376" d="M29.765,25.5l11.425-9.52a2.251,2.251,0,1,0-2.883-3.458l-13.5,11.249a2.253,2.253,0,0,0,0,3.458l13.5,11.249a2.251,2.251,0,0,0,2.883-3.458Z" transform="translate(10 66.003)"/>
                            </g>
                        </svg>
                    </router-link>{{ $t("Create your Kangoo") }}
                </h1>
                    <div class="thought" v-if="this.step == 'user-role'">{{ $t("Hi, I'm Kangoo! Who are you?") }}</div>
                    <img class="kangoo" v-if="this.step == 'user-role'" :src="'/img/Kangoo.svg'" />
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
    </div>
</template>