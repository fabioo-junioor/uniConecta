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
    fk_usuarioCurso: Number,
    fk_comprador: Number,
    pk_compra_venda: Number,
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
    infoCurso(pk_curso){
      this.$emit('infoCurso', pk_curso)

    },
    deletarCurso(pk_curso){
      this.$emit('deletarCurso', pk_curso)

    },
    avaliarCurso(pk_compra_venda, fk_comprador, cursoNome){
      this.$emit('avaliarCurso', pk_compra_venda, fk_comprador, cursoNome)

    },
    comprarCurso(pk_curso, fk_usuarioCurso){
      this.$emit('comprarCurso', pk_curso, fk_usuarioCurso)

    },
    editarCurso(pk_curso){
      this.$emit('editarCurso', pk_curso)

    },
    perfilUsuario(pk_curso){
      this.$router.push({name: 'perfilUsuario'})
      
    }
  },
  mounted(){

  }
};
</script>

<template>
  <div id="card-curso">
     <div class="header-status">
      <div class="favorito">
        <div class="total-favoritos">
          <span>{{totalFavoritos}}</span>
        </div>
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
      <b-card-text>Autor: 
        <router-link
          :to="{name: 'perfilUsuario', params:{ pk: fk_usuarioCurso } }">{{usuarioNome}}
        </router-link>
      </b-card-text>
      <b-card-text
        v-if="compradorNome">Comprador:
        <router-link 
          :to="{name: 'perfilUsuario', params:{ pk: fk_comprador } }">{{compradorNome}}
        </router-link>
      </b-card-text>
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
          @click="avaliarCurso(pk_compra_venda, fk_comprador, cursoNome)"
          variant="outline-success">Avaliar  
        </b-button>
        <b-button
          v-else-if="tipo == 2"
          :disabled="desativarBotao"
          @click="comprarCurso(pk_curso, fk_usuarioCurso)"
          variant="outline-success">Comprar  
        </b-button>
        <b-button
          v-else-if="tipo == 3"
          :disabled="desativarBotao"
          variant="outline-success">Avaliado  
        </b-button>
        <b-button
          v-else-if="tipo == 4"
          @click="editarCurso(pk_curso)"
          variant="outline-success">Editar  
        </b-button>
      </div>
    </b-card>
  </div>
</template>

<style lang="scss">
@import url('https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#card-curso {
  display: flex !important;
  flex-direction: column !important;
  font-family: 'Work Sans', sans-serif;
  border-bottom: 2px solid white;
  border-right: 2px solid white;
  box-shadow: 1px 1px 1px 1px #6C63FF;
  border-radius: 5px;
  padding: 0 !important;
  width: 18rem;
  margin: .5rem;
  background-color: white !important;

  .header-status{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .3rem 0;
    border-bottom: 1px solid #6C63FF;
    margin: .2rem;
    background-color: transparent;

    .favorito{
      width: 70%;
      display: flex;
      align-items: center;

      .total-favoritos{
        font-weight: 600;
        font-size: .9rem;
        padding: .2rem .8rem .2rem .8rem;
        margin: .1rem;
        color: black;
        border-radius: 5px;
        border: 1px solid #6C63FF;
        box-shadow: 1px 1px 0px 0px #6C63FF;
        
      }
      .favoritar-curso{
        padding: .2rem .5rem 0 .5rem;
        
        .btn{
          background-color: transparent;
          border: none;
          padding: 0;

          i{
            color: #6C63FF;
            font-size: 1.5rem;
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
        color: rgba(0, 0, 0, .6);
      
      }
    }
  }
  .card{
    border-radius: 0px !important;
    border: none;
    min-height: 10rem;
    display: flex;
    flex-direction: column;
    height: 100%;
    background-color: transparent;

    .card-body{
      display: flex !important;
      flex-direction: column !important;
      justify-content: space-between !important;

      h4{
        font-size: 1.3rem;

      }
      p{
        font-size: 1rem;

      }
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
      a{
        text-decoration: none;
        color: #6C63FF;
        text-decoration: underline;
        font-size: 1rem;
        
      }
      a:hover{
        font-weight: bold;

      }
      div{
        display: flex;
        justify-content: space-between;
        padding: .2rem;

      }
    }
  }  
}
#card-curso:hover{
  border-bottom: 2px solid #6C63FF;
  border-right: 2px solid #6C63FF;

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
  #card-curso{
    width: 95%;

  }
}
@media only screen and (max-width: 360px) {
}
</style>
