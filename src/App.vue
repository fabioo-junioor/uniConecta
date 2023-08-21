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
  height: 100vh;

}
</style>
