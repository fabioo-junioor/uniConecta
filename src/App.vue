<script setup>
import NavMenu from "./components/NavMenu.vue"
</script>

<template>
  <div id="app">
    <NavMenu />
    <router-view />
  </div>
</template>

<style lang="scss" scoped>
#app{
  min-height: 100vh;
  min-width: 100vw;
  background-color: rgba(0, 0, 0, .04);
  
}
</style>
