<script>
export default {
  name: "CardCursos",
  data() {
    return {
      favorito: false,
      totalFavoritos: 15
    };
  },
  props: {
    pk_curso: Number,
    cursoNome: String,
    usuarioNome: String,
    cursoDescricao: String,
    desativarBotao: Boolean,
    tipo: Number,
    ativarFavorito: Boolean

  },
  methods: {
    adicionarFavorito(){
      this.favorito = !this.favorito
      this.totalFavoritos += 1

    },
    removerFavorito(){
      this.favorito = !this.favorito
      this.totalFavoritos -= 1

    },
    avaliarCurso(){
      console.log("avaliar ")

    },
    infoCurso(pk_curso){
      this.$emit('infoCurso', pk_curso)

    }
  },
};
</script>

<template>
  <div id="card-cursos">
     <div class="header-status">
        <div class="total-favoritos">
          <span>{{totalFavoritos}}</span>
        </div>
        <div
          v-if="ativarFavorito"
          class="favoritar-curso">
            <b-button
              v-if="!favorito"
              @click="adicionarFavorito()" >
                <i class="bx bx-heart" />
            </b-button>
            <b-button
              v-else
              @click="removerFavorito()" >
                <i class="bx bxs-heart" />
            </b-button>
        </div>
    </div>
    <b-card
      tag="div"
      class="mb-2">
      <b-card-title>{{cursoNome}}</b-card-title>
      <b-card-text>{{usuarioNome}}</b-card-text>
      <b-card-text>{{cursoDescricao}}</b-card-text>
      <div>
        <b-button
          @click="infoCurso(pk_curso)"
          variant="outline-info">
            <i class="bx bx-info-circle"/>
        </b-button>
        <b-button
          v-if="tipo == 1"
          :disabled="desativarBotao"
          @click="avaliarCurso()"
          variant="outline-success">Avaliar  
        </b-button>
        <b-button
          v-else-if="tipo == 2"
          :disabled="desativarBotao"
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
    padding: .2rem 1rem;
    border-bottom: 1px solid #6C63FF;
    //background-color: blue;

    .total-favoritos{
      font-weight: 600;
      font-size: .9rem;
      padding: 5px;
      color: black;

    }
    .favoritar-curso{
      .btn{
        background-color: transparent;
        border: none;
        padding: .2rem;

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
