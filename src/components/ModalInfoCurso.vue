<script>
export default {
  name: "ModalInfoCurso",
  data() {
    return {

    }
  },
  props: {
    pk_curso: Number,
    cursoNome: String,
    tipoCurso: String,
    usuarioNome: String,
    totalHoras: Number,
    valorCurso: Number,
    dataCurso: String,
    horario: String,
    localCurso: String,
    descricao: String,
    linkMaterial: String

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
      <div>
        <i class='bx bx-edit-alt'></i>
        <h4>Titulo curso: </h4>
        <span>{{cursoNome}}</span>
      </div>
      <div>
        <i class='bx bxl-discourse'></i>
        <h5>Tipo: </h5>
        <span>{{tipoCurso}}</span>
      </div>
      <div>
        <i class='bx bx-user'></i>
        <h5>Criador: </h5>
        <span>{{usuarioNome}}</span>
      </div>
      <div>
        <i class='bx bx-stopwatch' ></i>
        <h5>Duração: </h5>
        <span>{{totalHoras}} Horas</span>
      </div>
      <div>
        <i class='bx bx-coin'></i>
        <h5>Valor: </h5>
        <span>{{valorCurso}} Moedas</span>
      </div>
      <div v-if="dataCurso">
        <i class='bx bxs-calendar'></i>
        <h5>Data: </h5>
        <span>{{dataCurso}}</span>
      </div>
      <div v-if="horario">
        <i class='bx bxs-watch'></i>
        <h5>Horario: </h5>
        <span>{{horario}}</span>
      </div>
      <div v-if="localCurso">
        <i class='bx bxs-map'></i>
        <h5>Local: </h5>
        <span>{{localCurso}}</span>
      </div>
      <div>
        <i class='bx bx-book-open'></i>
        <h5>Descrição: </h5>
        <span>{{descricao}}</span>
      </div>
      <div v-if="linkMaterial">
        <i class='bx bx-link-alt'></i>
        <h5>Material extra: </h5>
        <span><a target="_blank" :href="linkMaterial">Material extra</a></span>
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
      align-items: center !important;
      padding: 1rem .5rem;
      
      div{
        width: 100%;
        padding: .5rem .3rem;
        margin: .5rem 0;
        display: flex;
        align-items: center;
        border-radius: 5px;
        border: 1px solid white;
        box-shadow: 1px 1px 3px 1px rgba(255, 255, 255, 0.2);

        i{
          color: white;
          font-size: 1.4rem;
          padding-right: .5rem;

        }

        h4, h5{
          margin: 0;
          font-size: 1.1rem;
          
        }
        span{
          padding: 0 0 0 .5rem;
          font-size: 1rem;

          a{
            color: white;
            text-decoration: underline;
            font-size: .9rem;
          
          }
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