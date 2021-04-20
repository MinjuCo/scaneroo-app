<template>
    <div class="camera">
        <video autoplay class="feed" :class="facingMode === 'user' ? 'front': ''" ref="video"></video>
        <canvas style="display: none" ref="photo"/>
        <div class="snap-container">
            <button class="snap" v-on:click="capture">SNAP</button>
        </div>
    </div>
</template>

<script>

export default{
    name: "camera",
    data () {
        return {
            stream: null,
            photos: [],
            videoDevices: [],
            facingMode: "environment",
            switchingCamera: false,
        }
    },
    methods: {
        async startRecording(facingMode) {
            this.facingMode = facingMode;
            let videoPlayer = document.querySelector("video");
            this.stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: facingMode },
            });
            videoPlayer.srcObject = this.stream;
            return await videoPlayer.play();
        },
        async capture() {
            let videoPlayer = document.querySelector("video");
            let photo = this.$refs.photo;
            let width = videoPlayer.width;
            let height = videoPlayer.height;
            photo.width = width;
            photo.height = height;
            let context = photo.getContext("2d");
            context.save();

            if(this.facingMode === "user") {
                context.scale(-1, 1);
                context.drawImage(videoPlayer, width * -1, 0, width, height);
            }else{
                context.drawImage(videoPlayer, 0, 0);
            }

            context.restore();

            this.photos.push({
                id: 1,
                src: photo.toDataURL("image/png"),
            });
            console.log("Picture taken");
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

<style lang="scss" scoped>
    .camera {
        background-color: black;
        display: grid;
        width: 100vw;
        height: 100vh;
        grid-template-columns: [left] 90vw [bs] 5vw [es] 5vw [right];
        grid-template-rows: [top] 5vh [bs] 5vh [es] 80vh [middle] 5vh [bottom] 5vh [end];
        justify-items: center;
        overflow: hidden;

        .feed {
            height: 100%;
            box-shadow: 4px 4px 12px 0px rgba(0, 0, 0, 0.25);
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
            grid-row: middle/bottom;
            z-index: 5;
            width: 100vw;
            height: 5vh;
            display: flex;
            justify-content: center;

            .snap {
                border-radius: 100%;
            }
        }
    }
</style>
