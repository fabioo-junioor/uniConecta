<script>
import CardCursos from "../components/CardCursos.vue";
import LadoUsuario from '../components/LadoUsuario.vue'

export default {
  name: "MeusCursos",
  components: { CardCursos, LadoUsuario },
  data() {
    return {
      imagemPerfil: null,
      nomeUsuario: "",
      graduacao: "",
      totalPontos: 626,
      totalMoedas: 515,
      telefone: "",
      email: "",
      permissaoTelefone: null,
      cursos: []

    };
  },
  methods: {
    
  },
  async mounted(){
    

  }
};
</script>

<template>
  <div id="perfil-usuario">
    <div class="lado-user">
      <LadoUsuario
        :imagemPerfil="imagemPerfil"
        :nomeUsuario="nomeUsuario"
        :graduacao="graduacao"
        :totalMoedas="totalMoedas"
        :totalPontos="totalPontos"
        :telefone="telefone"
        :email="email"
        :permissaoTelefone="permissaoTelefone" />
    </div>
    <div class="lado-cursos-usuario">
      <div class="cursos-usuario-header">
        <h4>Cursos</h4>
      </div>
      <div class="cursos-usuario-body">
        <hr />
        <div class="cards-cursos">
          <CardCursos v-for="i in 4" :key="i" />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#perfil-usuario {
  font-family: "Work Sans", sans-serif;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  //background-color: red;

  .lado-user {
    width: 20%;
    //background-color: rebeccapurple;
    
  }
  .lado-meus-cursos {
    width: calc(100vw - 22%);
    padding: 3rem 1rem 0 1rem;
    //background-color: greenyellow;

    .cursos-usuario-header {
      //background-color: red;
      display: flex;
      justify-content: space-between;
      padding: 0.2rem;

      h4 {
        font-size: 1.3rem;
        margin: 0;
        padding: 5px 0 2px 0;
      }
      button {
        font-family: "Work Sans", sans-serif;
        border-radius: 5px;
        color: #6b63ff;
        background-color: transparent;
        border: 1px solid #6b63ff;
      }
      button:hover {
        background-color: #6b63ff;
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
        color: white;
      }
    }
    .cursos-usuario-body {
      //background-color: blue;

      hr {
        border: 1px solid #6c63ff;
        margin: 0 0 0.5rem 0;
        width: 100%;
        margin-bottom: 1rem;
      }
      .cards-cursos {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.5rem;
        align-items: stretch;
      }
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 992px) {
}
@media only screen and (max-width: 720px) {
  #perfil-usuario {
    display: flex;
    flex-direction: column;
    align-items: center;

    .lado-user {
      width: 95%;

      .dados-user {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0;

        h3 {
          text-align: center;
        }
        h2 {
          text-align: center;
        }
        div {
          display: flex;
          flex-direction: row;
          align-items: center;
          justify-content: center;
        }
      }
    }
    .lado-cursos-usuario {
      width: 95%;
      padding: 3rem 0 0 0;

      .cursos-usuario-body {
        .cards-cursos {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 0.3rem;
        }
      }
    }
  }
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>