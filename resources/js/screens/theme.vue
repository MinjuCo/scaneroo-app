<template>
    <div class="screen">
        <div class="sticky-top top d-flex align-items-center justify-content-between">
            <div class="btn icon-md p-0 d-flex flex-row justify-content-center align-items-center back" 
            :class="{'invisible': !showWordList}"
            @click="toggleThemeList"
            >
                <i class="bi bi-chevron-left"></i>
            </div>
            <h1>{{$t('Themes')}}</h1>
            <div class="btn p-0 d-flex flex-row justify-content-center align-items-center icon-md rounded-circle text-white bg-secondary"
            :class="{'invisible': !showWordList}"
            >
                <i class="bi bi-info"></i>
            </div>
        </div>
        <div class="content">
            
        </div>
        <main-menu :video="showVideo" />
    </div>
</template>

<script>
import MainMenu from '../components/Main-menu';

    export default {
        name: 'theme',
        components: {
            MainMenu,
        },
        data() {
            return {
                showVideo: false,
                showWordList: false,
            };
        },
        beforeMount () {
            localStorage.removeItem('userData');
        },
        methods: {
            toggleThemeList() {
                this.showWordList = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
    body {
        margin: 0;
        padding: 0;
    }
</style>