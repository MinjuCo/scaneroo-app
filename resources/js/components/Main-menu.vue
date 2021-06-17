<template>
    <div class="menu">
        <ul class="nav">
            <li class="nav-item">
                <router-link :to="{ name: 'profile'}" :class="'nav-link'">
                    <div class="bg-icon">
                        <img src="/img/icon/profiel.svg" />
                    </div>
                    <span class="nav-text">{{ $t('Profile') }}</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{ name: 'favorite'}" :class="'nav-link'">
                    <div class="bg-icon">
                        <img src="/img/icon/Favoriet.svg" />
                    </div>
                    <span class="nav-text">{{ $t('Favourites') }}</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link v-if="this.currentRoute != 'home' " :to="{ name: 'home'}" :class="'nav-link'">
                    
                        <div class="bg-icon">
                            <img src="/img/icon/Camera.svg" />
                        </div>
                    <span class="nav-text">{{ $t('Scan') }}</span>
                </router-link>
                <a v-else @click="snap()" class="nav-link snap" :class="{'router-link-exact-active': this.currentRoute == 'home'}">
                    <div class="outline" :class="{'border-0': captured}">
                        <div class="bg-icon">
                            <img src="/img/icon/Camera.svg" />
                        </div>
                    </div>
                    <span class="nav-text">{{ $t('Scan') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <router-link :to="{ name: 'theme'}" :class="'nav-link'">
                    <div class="bg-icon">
                        <img src="/img/icon/themas.svg" />
                    </div>
                    <span class="nav-text">{{ $t('Themes') }}</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{ name: 'shop'}" :class="'nav-link'">
                    <div class="bg-icon">
                        <img src="/img/icon/shop.svg" />
                    </div>
                    <span class="nav-text">{{ $t('Shop') }}</span>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>

export default{
    name: "main-menu",
    data () {
        return {
            
        }
    },
    computed: {
        currentRoute() {
            return this.$route.name;
        },
        captured() {
            return !this.$root.$refs.camera.showVideo;
        }
    },
    methods: {
        snap() {
            if(this.$root.$refs.camera.showVideo){
                this.$root.$refs.camera.capture();
            }
        }
    },
}
</script>