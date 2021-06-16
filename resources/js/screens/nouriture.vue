<template>
  <div id="app">
    <div class="view">
      <h1>Nourriture</h1>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      <a class="themeContainer" href="#">
        <div >
            <h3>Carotte</h3>
            <img src="img/active.svg" alt="">
        </div>
      </a>
      
      <div class="snap-container">
        <ul>
          <li>
            <a href="/profile"><img v-bind:src="'img/profiel.svg'" alt="" /></a>
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
            <div class="active">
              <a href="/theme"><img v-bind:src="'img/themas.svg'" alt="" /></a>
            </div>
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