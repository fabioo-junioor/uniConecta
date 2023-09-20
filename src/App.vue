<script>
import NavMenu from "./components/NavMenu.vue"
import Rodape from './components/Rodape.vue'
import Alerta from "./components/Alerta.vue"

export default {
  name: "App",
  components: {NavMenu, Rodape, Alerta},
  data() {
    return {}

  }
};
</script>

<template>
  <div id="app">
    <div class="app-nav-corpo">
      <NavMenu />
      <router-view />
    </div>
    <div class="app-rodape">
      <Rodape />
    </div>
  </div>
</template>

<style lang="scss" scoped>
#app{
  min-height: 100vh;
  min-width: 100vw;
  background-color: rgba(0, 0, 0, .04);
  display: flex;
  flex-direction: column;
  justify-content: space-between;

}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 990px) {
}
@media only screen and (max-width: 720px) {
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>
