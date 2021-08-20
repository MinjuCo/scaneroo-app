<template>
    <div class="screen">
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