<script>
export default {
    props: {
        item: {
            type: Object,
        },
    },
    name:'favorite-word',
    data() {
        return {
            toggle:false,
        };
    },
    computed: {
        userData() {
            let user = "";
            this.$http.get('/api/user')
                    .then(response => {
                        console.log(response);
                    });
            return user;
        }
    },

    methods: {
        playSound(word) {
            this.toggle = !this.toggle;
            let key = this.$voiceKey;
            let hl = this.$user.learning_lang;
            let src = word;
            

            let sound = 'https://api.voicerss.org/?key='+ key +'&hl=' + hl + '&src=' + src;

            let audio = new Audio(sound);
            audio.play();
                    
        }
    },
}
</script>

<template>
  <div @click="toggle = !toggle" class="card mb-3" :class="{'show': toggle}">
                <div class="card-body favorite">
                    <div class="media">
                        <img src="/img/wortel.svg" class="icon-img align-self-start mr-3" alt="Carotte">
                        <div class="media-body">
                            <h4 class="word">{{ this.item.name }}</h4>
                            
                        </div>
                        <div @click="playSound(item.trans)" class="px-3 py-1 ml-3 m-auto"><img src="/img/sound.svg" class="icon align-self-start" alt="Play"></div>
                        
                    </div>
                    <div class="word-info">
                                <h4 class="mt-4">{{ this.item.trans }}</h4>
                                <p>{{ this.item.exampleSentence }}</p>
                        </div>
                </div>
            </div>
</template>