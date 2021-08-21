<template>
    <div class="screen">
        <div class="sticky-top top shadow-sm">
            <h1>{{$t('Favourites')}}</h1>
        </div>
        <div class="content">
            <favorite-word v-for='word in list' v-bind:item="word" v-bind:key="word.name"></favorite-word>
        </div>
        <main-menu :video="showVideo" />
    </div>
</template>

<script>
import MainMenu from '../components/Main-menu';
import FavoriteWord from '../components/FavoriteWord.vue';

    export default {
        name: 'favorite',
        components: {
            MainMenu,
            FavoriteWord,
        },
        data() {
            return {
                toggle: false,
                showVideo: false,
                list: [
                    {name: 'la carotte', trans: 'de wortel', exampleSentence: 'Les chevaux aiment manger "een wortel"?'},
                    {name: 'le livre', trans: 'het boek', exampleSentence: 'J\'adore lire des livres'},
                ],
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