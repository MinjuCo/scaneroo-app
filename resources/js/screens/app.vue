<template>
    <div class="screen">
        <camera @eventname="updateVideo" :video="showVideo" />
        <main-menu :video="showVideo" />
    </div>
</template>

<script>
import Camera from '../components/Camera';
import MainMenu from '../components/Main-menu';

    export default {
        name: 'app',
        components: {
            Camera,
            MainMenu,
        },
        data() {
            return {
                showVideo: true,
            };
        },
        beforeMount () {
            localStorage.removeItem('userData');
        },
        methods: {
            updateVideo(variable) {
                this.showVideo = variable;
            },
        }
    }
</script>

<style lang="scss" scoped>
    body {
        margin: 0;
        padding: 0;
    }
</style>