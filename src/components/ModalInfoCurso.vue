<script>
export default {
  name: "ModalInfoCurso",
  data() {
    return {
      url: null

    }
  },
  methods: {
    
  },
  mounted(){
    //this.url = import.meta.env.VITE_ROOT_API
    
  }
};
</script>
<template>
  <div id="modal-informacoes-curso">
    <b-modal
      id="modalInfoCurso"
      size="lg"
      scrollable
      title="Informações do curso">
      <p>teste</p>
    </b-modal>
  </div>
</template>
<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#modal-informacoes-curso{
  background-color: red;

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