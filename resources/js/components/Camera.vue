<template>
    <div class="camera">
        <video v-show="showVideo" autoplay class="feed" :class="facingMode === 'user' ? 'front': ''" ref="video"></video>
        <canvas v-show="!showVideo" class="preview" ref="canvas" />
        <div v-if="!hideBtns" class="snap-container">
            <div v-show="objectScanned" class="thought">
                <div class="ml-auto p-1 invisible"></div>
                {{ this.capturedObject.name }}
                <div @click="playSound()" class="btn px-3 py-1 ml-auto float-right"><img src="/img/sound.svg" class="icon align-self-start" alt="Play"></div>
            </div>
            <button v-if="!showVideo"
                class="bg-transparent back"
                @click="startRecording(facingMode)"
            >
                <i class="bi bi-chevron-left"></i>
            </button>
            <button 
                v-if="videoDevices.length > 1 && showVideo"
                class="btn rounded-circle switch-button"
                @click="switchCamera"
                :disabled="switchingCamera"
            >
                <b-icon pack="fas" icon="sync-alt" />
            </button>
        </div>
    </div>
</template>

<script>

export default{
    name: "camera",
    props: ['video'],
    data () {
        return {
            stream: null,
            videoDevices: [],
            facingMode: "environment",
            switchingCamera: false,
            hideBtns: false,
            capturedObject: [],
            objectScanned: false,
            showVideo: this.video,
        }
    },
    created(){
        this.$root.$refs.camera = this;
    },
    methods: {
        // Reference: https://github.com/pierresaid/vue-pwa-camera
        /* To switch the camera between front and back **/
        async switchCamera() {
            this.switchingCamera = true;
            const tracks = this.stream.getVideoTracks();
            tracks.forEach((track) => {
                track.stop();
            });

            await this.startRecording(
                this.facingMode === "environment" ? "user" : "environment"
            );
            this.switchingCamera = false;
        },
        /* Stream the camera on the video tag **/
        async startRecording(facingMode) {
            this.capturedObject = [];
            this.showVideo = true;
            this.$emit('eventname', true);
            this.objectScanned = false;
            this.facingMode = facingMode;
            let videoPlayer = document.querySelector("video");
            this.stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: facingMode },
            });
            videoPlayer.srcObject = this.stream;
            return await videoPlayer.play();
        },
        // End reference

        // Reference: https://github.com/YovelBecker/vue-media-recorder
        async capture() {
            this.showVideo = false;
            this.$emit('eventname', false);
            let image = this.$refs.canvas;
            image.width = this.$refs.video.videoWidth;
            image.height = this.$refs.video.videoHeight;

            let context = image.getContext("2d");
            
            if(this.facingMode === "user") {
                context.translate(image.width, 0);
                context.scale(-1, 1);
            }
            
            context.drawImage(this.$refs.video, 0, 0);
            
            this.stopRecording();

            console.log("Picture taken");
            this.sendToAPI(image);
        },
        //Stop the video recording
        async stopRecording(){
            if(!(this.$refs.video && this.$refs.video.srcObject)) return;
            return this.$refs.video.srcObject.getVideoTracks().forEach(stream => {
                stream.stop();
            });
        },
        /* Send the picture to google api and get the name of the object **/
        async sendToAPI(canvas){
            let data = new FormData();
            let http = this.$http;
            //Send the canvas as image
            canvas.toBlob(blob => {
                data.append('picture', blob);

                http.post('/api/object/detect-labels', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                    .then(response => {
                        console.log(response.data);
                        this.capturedObject = response.data;
                        this.objectScanned = true;
                    });
            });
        },
        // End reference
        async playSound() {
            this.toggle = !this.toggle;
            let key = this.$voiceKey;
            let hl = this.$user.learning_lang;
            let src = this.capturedObject.name;
            

            let sound = 'https://api.voicerss.org/?key='+ key +'&hl=' + hl + '&src=' + src;

            let audio = new Audio(sound);
            audio.play();
                    
        }
    },
    async mounted () {
        const devices = await navigator.mediaDevices.enumerateDevices();
        this.videoDevices = devices.filter((d) => d.kind === "videoinput");
        //Start Recording
        await this.startRecording(
            this.videoDevices.length === 1 ? "user" : "environment"
        );
    },
}
</script>
