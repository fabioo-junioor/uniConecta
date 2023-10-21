<script>
export default {
  name: "CardCursos",
  data() {
    return {
      favorito: false,
      
    };
  },
  props: {
    pk_curso: Number,
    cursoNome: String,
    tipoCurso: String,
    usuarioNome: String,
    compradorNome: String,
    cursoDescricao: String,
    totalFavoritos: Number,
    favoritou: Boolean,
    desativarBotao: Boolean,
    tipo: Number,
    ativarFavorito: Boolean,
    ativarDelete: Boolean

  },
  methods: {
    adicionarFavorito(pk_curso){
      this.$emit('adicionarFavorito', pk_curso)

    },
    deletarFavorito(pk_curso){
      this.$emit('deletarFavorito', pk_curso)

    },
    avaliarCurso(){
      console.log("avaliar ")

    },
    infoCurso(pk_curso){
      this.$emit('infoCurso', pk_curso)

    },
    deletarCurso(pk_curso){
      this.$emit('deletarCurso', pk_curso)

    },
    avaliarCurso(pk_curso){
      this.$emit('avaliarCurso', pk_curso)

    },
    comprarCurso(pk_curso){
      this.$emit('comprarCurso', pk_curso)

    }
  },
  mounted(){

  }
};
</script>

<template>
  <div id="card-cursos">
     <div class="header-status">
      <div class="favorito">
        <div
          v-if="ativarFavorito"
          class="favoritar-curso">
            <b-button
              v-if="favoritou"
              @click="adicionarFavorito(pk_curso)" >
                <i class="bx bx-heart" />
            </b-button>
            <b-button
              v-else
              @click="deletarFavorito(pk_curso)" >
                <i class="bx bxs-heart" />
            </b-button>
        </div>
        <div class="total-favoritos">
          <span>{{totalFavoritos}}</span>
        </div>
      </div>
      <div
        v-if="ativarDelete"
        class="deletar-curso">
        <b-button
          @click="deletarCurso(pk_curso)" >
          <i class="bx bx-trash" />
        </b-button>
      </div>
    </div>
    <b-card
      tag="div"
      class="mb-2">
      <b-card-title>Titulo: {{cursoNome}}</b-card-title>
      <b-card-text>Tipo: {{tipoCurso}}</b-card-text>
      <b-card-text>Autor: {{usuarioNome}}</b-card-text>
      <b-card-text
        v-if="compradorNome">Comprador: {{compradorNome}}</b-card-text>
      <b-card-text>Descrição: {{cursoDescricao}}</b-card-text>
      <div>
        <b-button
          @click="infoCurso(pk_curso)"
          variant="outline-info">
            <i class="bx bx-info-circle"/>
        </b-button>
        <b-button
          v-if="tipo == 1"
          :disabled="desativarBotao"
          @click="avaliarCurso(pk_curso)"
          variant="outline-success">Avaliar  
        </b-button>
        <b-button
          v-else-if="tipo == 2"
          :disabled="desativarBotao"
          @click="comprarCurso(pk_curso)"
          variant="outline-success">Comprar  
        </b-button>
        <b-button
          v-else-if="tipo == 3"
          :disabled="desativarBotao"
          variant="outline-success">Avaliado  
        </b-button>
      </div>
    </b-card>
  </div>
</template>

<style lang="scss" scoped>
@import url('https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#card-cursos {
  display: flex;
  flex-direction: column;
  font-family: 'Work Sans', sans-serif;
  background-color: white;

  //padding: 1rem 0 1rem 1rem;
  border: 1px solid #6C63FF;
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
  border-radius: 5px;

  .header-status{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .2rem;
    border-bottom: 1px solid #6C63FF;

    .favorito{
      width: 70%;
      display: flex;
      align-items: center;

      .total-favoritos{
        font-weight: 600;
        font-size: .9rem;
        padding: 5px;
        color: #6C63FF;

      }
      .favoritar-curso{
        padding-right: .5rem;
        
        .btn{
          background-color: transparent;
          border: none;
          padding: 2px;

          i{
            color: #6C63FF;
            font-size: 1.7rem;
            font-weight: 500;
            
          }
        }
        .btn:hover i{
          font-weight: 600;
      
        }
      }
    }
    .deletar-curso{
      display: flex;
      justify-content: flex-end;
      align-items: center;
      width: 30%;
      padding: 2px;

      .btn{
        background-color: transparent;
        border: none;
        padding: 2px;

        i{
          color: black;
          font-size: 1.7rem;
          font-weight: 500;
            
        }
      }
      .btn:hover i{
        color: rgba(0, 0, 0, 0.6);
      
      }
    }
  }
  .card{
    background-color: transparent;
    border-radius: 0px !important;
    border: none;
    min-height: 10rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    img{
      border-radius: 0px !important;
      min-height: 100px;
      
    }
    div{
      display: flex;
      justify-content: space-between;
      padding: .2rem;
      //background-color: red;

    }
    .card-body{
      h4, p{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
      
      }
      h4::first-letter, p::first-letter{
        text-transform: uppercase;

      }
    }
  }  
}
/* Responsive */
</style>
