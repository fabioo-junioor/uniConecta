<script>
export default {
  name: "ModalInfoCurso",
  data() {
    return {
      url: null

    }
  },
  props: {
    pk_curso: Number,
    cursoNome: String,
    tipoCurso: String,
    usuarioNome: String,
    totalHoras: Number,
    valorCurso: Number,
    descricao: String

  },
};
</script>
<template>
  <div id="modal-informacoes-curso">
    <b-modal
      id="modalInfoCurso"
      size="lg"
      scrollable
      title="Informações do curso">
      <div>
        <h4>Nome curso: </h4>
        <span>{{cursoNome}}</span>
      </div>
      <div>
        <h5>Tipo: </h5>
        <span>{{tipoCurso}}</span>
      </div>
      <div>
        <h5>Criador: </h5>
        <span>{{usuarioNome}}</span>
      </div>
      <div>
        <h5>Duração: </h5>
        <span>{{totalHoras}} Horas</span>
      </div>
      <div>
        <h5>Valor: </h5>
        <span>{{valorCurso}} Moedas</span>
      </div>
      <div>
        <h5>Descrição: </h5>
        <span>{{descricao}}</span>
      </div>
    </b-modal>
  </div>
</template>
<style lang="scss">
@import url('https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#modalInfoCurso{
  font-family: 'Work Sans', sans-serif;
  color: white;
  .modal-content{
    .modal-body{
      display: flex !important;
      align-items: flex-start !important;
      padding: 1rem .5rem;
      
      div{
        width: 100%;
        padding: 1rem .3rem;
        margin: .5rem 0;
        display: flex;
        align-items: center;
        border-left: 3px solid white;
        //box-shadow: 1px 2px 0px 0px white;

        h4, h5{
          margin: 0;
          
        }
        span{
          padding: 0 0 0 .5rem;

        }
      }  
    }
  }
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