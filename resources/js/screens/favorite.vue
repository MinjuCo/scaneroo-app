<template>
    <div class="screen">
        <div class="sticky-top top shadow-sm">
            <h1>{{$t('Favourites')}}</h1>
        </div>
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h4>Carotte</h4>
                    <div class="media">
                        <img src="..." class="align-self-start mr-3" alt="...">
                        <div class="media-body">
                            <h4 class="mt-0">Carotte</h4>
                            <p>I’m gon’ put her in a coma. You give a hundred reasons why, and you say you're really gonna try. So I sat quietly, agreed politely. Suiting up for my crowning battle. And on my 18th Birthday we got matching tattoos. So très chic, yeah, she's a classic. I am ready for the road less traveled.</p>
                            <p>I'm walking on air (tonight). But down to earth. You're original, cannot be replaced. But in another life I would be your girl. We drove to Cali and got drunk on the beach. We can dance, until we die, you and I, will be young forever. Saw you downtown singing the Blues.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4>Carotte</h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Carotte</h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Carotte</h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Carotte</h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Carotte</h4>
                </div>
            </div>
        </div>
        <main-menu :video="showVideo" />
    </div>
</template>

<script>
import MainMenu from '../components/Main-menu';

    export default {
        name: 'favorite',
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