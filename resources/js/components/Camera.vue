<template>
    <div class="camera">
        <video v-show="showVideo" autoplay class="feed" :class="facingMode === 'user' ? 'front': ''" ref="video"></video>
        <canvas v-show="!showVideo" class="preview" ref="canvas" />
        <div v-if="!hideBtns" class="snap-container">
            <div class="object-name" v-show="objectScanned">
                {{ this.capturedObject.name }}
            </div>
            <button 
                class="snap" 
                v-on:click="capture"
                v-if="showVideo"
            >SNAP</button>
            <button v-else
                class="btn bg-transparent back"
                @click="startRecording(facingMode)"
            >
                <b-icon pack="fas" icon="chevron-left" />
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
    data () {
        return {
            stream: null,
            videoDevices: [],
            facingMode: "environment",
            switchingCamera: false,
            hideBtns: false,
            showVideo: true,
            capturedObject: [],
            objectScanned: false,
        }
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
        }
        // End reference
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

<style lang="scss" scoped>
    .camera {
        background-color: black;
        display: grid;
        width: 100vw;
        height: 100vh;
        grid-template-columns: [left] 5vw [lm] 5vw [le] 80vw [middle] 5vw [rm] 5vw [right];
        grid-template-rows: [top] 5vh [bs] 5vh [es] 80vh [middle] 5vh [bottom] 5vh [end];
        justify-items: center;
        overflow: hidden;

        .feed, .preview {
            object-fit: cover;
            height: 100%;
            grid-column: left/right;
            grid-row: top / end;
            user-select: none;
            max-width: unset;

            &.front{
                -webkit-transform: scaleX(-1);
                transform: scaleX(-1);
            }
        }

        .snap-container {
            grid-column: left / right;
            grid-row: bs/middle;
            grid-template-columns: [left] 5vw [lm] 5vw [le] 80vw [middle] 5vw [rm] 5vw [right];
            grid-template-rows: [top] 5vh [bs] 5vh [es] auto [middle] 5vh [bottom] 5vh [end];
            z-index: 5;
            width: 100vw;
            height: 100%;
            display: grid;

            .object-name {
                grid-row: top/es;
                grid-column: le/middle;
                margin: auto;
                width: 300px;
                height: auto;
                padding: 1em;
                text-align: center;
                box-sizing: border-box;
                background-color: white;
                border: 2px solid black;
                border-radius: 15px;
            }

            .snap {
                border-radius: 100%;
                grid-column: le;
                grid-row: middle;
                margin: auto;
                width: 5vh;
                height: 5vh;
            }

            .switch-button {
                grid-column: middle/rm;
                grid-row: top/bs;
                z-index: 5;
                border-radius: 100%;
                width: 5vh;
                height: 5vh;
                font-size: 1.5em;
            }

            .btn.back {
                width: 5vh;
                height: 5vh;
                grid-column: lm/le;
                grid-row: top/bs;
                z-index: 5;
            }
        }

    }
</style>
