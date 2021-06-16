<template>
  <div class="camera">
    <video
      autoplay
      class="feed"
      :class="facingMode === 'user' ? 'front' : ''"
      ref="video"
    ></video>
    <canvas style="display: none" ref="photo" />
    <div class="snap-container">
      <ul>
        <li>
          <a href="/profile"><img v-bind:src="'img/profiel.svg'" alt="" /></a>
        </li>
        <li>
          <a href="/favoriet"><img v-bind:src="'img/Favoriet.svg'" alt="" /></a>
        </li>
        <li>
          <button class="snap" v-on:click="capture">
            <div class="outline">
              <img v-bind:src="'img/Camera.svg'" alt="" />
            </div>
          </button>

          
        </li>
        <li>
          <a href="#"><img v-bind:src="'img/themas.svg'" alt="" /></a>
        </li>
        <li>
          <a href="#"><img v-bind:src="'img/shop.svg'" alt="" /></a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "camera",
  data() {
    return {
      stream: null,
      photos: [],
      videoDevices: [],
      facingMode: "environment",
      switchingCamera: false,
    };
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

      if (this.facingMode === "user") {
        context.scale(-1, 1);
        context.drawImage(videoPlayer, width * -1, 0, width, height);
      } else {
        context.drawImage(videoPlayer, 0, 0);
      }

      context.restore();

      this.photos.push({
        id: 1,
        src: photo.toDataURL("image/png"),
      });
      console.log("Picture taken");
    },
  },
  async mounted() {
    const devices = await navigator.mediaDevices.enumerateDevices();
    this.videoDevices = devices.filter((d) => d.kind === "videoinput");
    //Start Recording
    await this.startRecording(
      this.videoDevices.length === 1 ? "user" : "environment"
    );
  },
};
</script>


