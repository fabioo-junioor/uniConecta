<script>
import { getDadosUsuarioLocal } from "../config/global.js"
import Alerta from '../components/Alerta.vue'

export default {
  name: "ModalAvaliarCurso",
  components: {Alerta},
  data() {
    return {
      botaoAvaliar: false,
      url: null,
      dadosAvaliacao: {
        pk_compra_venda: null,
        pk_comprador: null,
        nota: null

      },
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false,
      }
    }
  },
  props: {
    pk_compra_venda: Number,
    pk_comprador: Number,
    cursoNome: String,

  },
  methods: {
    async avaliarCursoComprado(pk_compra_venda){
      const response = await fetch(this.url+'avaliarCurso.php?avaliarCursoComprado=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_compra_venda: pk_compra_venda,
          notaAvaliacao: this.dadosAvaliacao.nota

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_compra_venda != null){
          await getDadosUsuarioLocal()
          this.mensagemAlerta(1)
          
        }
      }
    },
    async avaliarCursoVendido(pk_compra_venda){
      const response = await fetch(this.url+'avaliarCurso.php?avaliarCursoVendido=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_compra_venda: pk_compra_venda,
          notaAvaliacao: this.dadosAvaliacao.nota

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_compra_venda != null){
          await getDadosUsuarioLocal()
          this.mensagemAlerta(1)

        }
      }
    },
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Curso avaliado!"
        this.alerta.tipo = "success"
        this.alerta.isAlert = true

      }
      this.resetaAlerta()

    },
    resetaAlerta(){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

        return location.reload()

      }, 4500)
    } 
  },
  mounted(){
    this.url = import.meta.env.VITE_ROOT_API

  },
  watch:{
    'dadosAvaliacao.nota': function (){
      this.botaoAvaliar = (this.dadosAvaliacao.nota) > 0 ? true : false

    }
  }
};
</script>
<template>
  <div id="modal-avaliar-curso">
    <Alerta
      v-if="alerta.isAlert"
      :mensagem="alerta.mensagem"
      :tipo="alerta.tipo" />
    <b-modal
      id="modalAvaliarCurso"
      size="lg"
      scrollable
      title="Avaliar curso">
      <div>
        <i class='bx bx-edit-alt'></i>
        <h4>Titulo curso: </h4>
        <span>{{cursoNome}}</span>
      </div>
      <div>
        <b-form-rating
          v-model="dadosAvaliacao.nota"
          show-value></b-form-rating>
      </div>
      <div class="button-avaliar">
        <b-button
          @click="(pk_comprador != null) ? avaliarCursoVendido(pk_compra_venda) : avaliarCursoComprado(pk_compra_venda)"
          variant="success"
          :disabled="!botaoAvaliar" >Avaliar</b-button>
          </div>
    </b-modal>
  </div>
</template>
<style lang="scss">
@import url('https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#modalAvaliarCurso{
  font-family: 'Work Sans', sans-serif;
  color: white;

  .modal-content{
    .modal-body{
      display: flex !important;
      align-items: center !important;
      padding: 1rem .5rem;
      
      div{
        width: 100%;
        padding: 1rem .3rem;
        margin: .5rem 0;
        display: flex;
        align-items: center;

        i{
          color: white;
          font-size: 1.3rem;
          padding-right: .5rem;

        }

        h4, h5{
          margin: 0;
          font-size: 1rem;
          font-weight: bold;
          
        }
        span{
          padding: 0 0 0 .5rem;
          font-size: 1rem;

        }
        .b-rating{
          background-color: transparent;
          border: 2px solid white;
          color: white;

          .b-rating-icon{
            font-size: 1.5rem;

          }
        }
      }  
    }
    .button-avaliar {
      display: flex;
      flex-direction: row;
      justify-content: center;
      padding: 1rem;
      width: 100%;

      button {
        font-family: 'Work Sans', sans-serif;
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.5);
        width: 90%;
        height: 3.5rem;
        border-radius: 5px;
        color: white;
        
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