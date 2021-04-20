<template>
    <div id="app">
        <camera />
    </div>
</template>

<script>
import Camera from '../components/Camera';

    export default {
        name: 'app',
        components: {
            Camera,
        },
        data() {
            return {

            };
        },
        methods: {
        }
    }
</script>

<style lang="scss" scoped>
    body {
        margin: 0;
        padding: 0;
    }
</style>