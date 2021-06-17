<template>
  <div id="app">
    <div class="view">
        <h1>Favoris</h1>
        <div id="test" class="favoris">
            <img class="floatleft" src="img/wortel.svg" alt="">
            <h3 class="inline">Carrote</h3>
            <button class="floatright"><img src="img/sound.svg" alt=""></button>
            <h3 id="vertaling" >Wortel</h3>
            <p id="text" style="dispaly:none" >Les chevaux aiment manger "een wortel"?</p>
        </div>
      <div class="snap-container">
        <ul>
          <li>
            <a href="/profile"><img v-bind:src="'img/profiel.svg'" alt="" /></a>
          </li>
          <li>
            <a href="/favoriet">
              <div class="active">
                <img v-bind:src="'img/Favoriet.svg'" alt="" />
              </div>
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

export default {
  name: "app",
  
  data() {
    return {};
  },
  methods: {
      toggleIcon:function(){
      this.showIcon = !this.showIcon;}
  },
};
</script>

<style lang="scss" scoped>
body {
  margin: 0;
  padding: 0;
}
</style>