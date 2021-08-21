<template>
    <div class="screen">
        <div class="sticky-top top shadow-sm">
            <h1>{{$t('Profile')}}</h1>
        </div>
        <div class="content">
            
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
            };
        },
        beforeMount () {
            localStorage.removeItem('userData');
        },
    }
</script>

<style lang="scss" scoped>
    body {
        margin: 0;
        padding: 0;
    }
</style>