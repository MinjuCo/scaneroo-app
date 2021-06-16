<template>
  <div id="app">
    <div class="view">
      <div class="snap-container">
        <ul>
          <li>
            <div class="active">
              <a href="/profile"
                ><img v-bind:src="'img/profiel.svg'" alt=""
              /></a>
            </div>
          </li>
          <li>
            <a href="/favoriet">
              <img v-bind:src="'img/Favoriet.svg'" alt="" />
            </a>
          </li>
          <li>
            <a href="/"><img v-bind:src="'img/Camera.svg'" alt="" /></a>
          </li>
          <li>
            <a href="/theme"><img v-bind:src="'img/themas.svg'" alt="" /></a>
          </li>
          <li>
            <a href="#"><img v-bind:src="'img/shop.svg'" alt="" /></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Camera from "../components/Camera";

export default {
  name: "app",
  components: {
    Camera,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>

<style lang="scss" scoped>
body {
  margin: 0;
  padding: 0;
}
</style>