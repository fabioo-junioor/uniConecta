<script>
import CardCursos from '../components/CardCursos.vue'
import ModalCadCurso from '../components/ModalCadCurso.vue'

export default {
  name: "MeusCursos",
  components: {CardCursos, ModalCadCurso},
  data() {
    return {
      nomeUser: "Fabio Junior",
      curso: "Sistemas de informação",
      totalPontos: 626,
      totalCoins: 515

    }
  }
};
</script>

<template>
  <div id="meus-cursos">
    <div class="lado-user">
      <div class="foto-user">
        <img src="../assets/img/person1.png" />
      </div>
      <div class="dados-user">
        <h3>{{ nomeUser }}</h3>
        <h2>{{ curso }}</h2>
        <div>
          <img src="../assets/gifs/coin.gif" />
          {{ totalCoins }}
        </div>
        <div>
          <img src="../assets/img/trophy.png" />
          {{ totalPontos }}
        </div>
      </div>
    </div>
    <div class="lado-meus-cursos">
      <div class="meus-cursos-header">
        <h4>Meus Cursos</h4>
          <a v-b-modal.modal-scrollable-curso-lg>
            <b-button>
              <ModalCadCurso />CADASTRAR CURSO
            </b-button>
          </a>
      </div>
      <div class="meus-cursos-body">
        <hr>
        <div class="cards-cursos">
          <CardCursos 
            v-for="i in 6" :key="i" />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#meus-cursos {
  font-family: "Work Sans", sans-serif;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  margin: .5rem 0 1rem 0;

  .lado-user {
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3rem 0 0 0;
    //background-color: brown;

    .foto-user {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0 1rem 0;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
      border-radius: 5px;

      img {
        max-height: 15rem;
        max-width: 15rem;
        padding: 0;
      }
    }
    .dados-user {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      padding: 1rem 0 1rem 1rem;
      background-color: white;
      border: 1px solid #6c63ff;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
      border-radius: 5px;

      h3 {
        padding: 1rem 0 0 0;
        font-size: 1.2rem;
        width: 100%;
      }
      h2 {
        font-size: 0.9rem;
        width: 100%;
      }
      div {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        padding: 0.5rem 0;
        font-size: 0.8rem;
        font-weight: bold;
        //background-color: gray;

        img {
          height: 2rem;
          margin: 0.1rem;
          //background-color: red;
        }
      }
    }
  }
  .lado-meus-cursos {
    width: calc(100vw - 30%);
    padding: 3rem 0 0 0;
    //background-color: red;

    .meus-cursos-header{
      //background-color: red;
      display: flex;
      justify-content: space-between;
      padding: .2rem;

      h4{
        font-size: 1.3rem;
        margin: 0;
        padding: 5px 0 2px 0;

      }
      button{
        font-family: 'Work Sans', sans-serif;
        border-radius: 5px;
        color: #6b63ff;
        background-color: transparent;
        border: 1px solid #6b63ff;

      }
      button:hover{
        background-color: #6b63ff;
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
        color: white;
        
      }
    }
    .meus-cursos-body{
      //background-color: blue;
      
      hr{
        border: 1px solid #6C63FF;
        margin: 0 0 .5rem 0;
        width: 100%;
        margin-bottom: 1rem;
        
      }
      .cards-cursos{
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: .5rem;
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
#meus-cursos{
  display: flex;
  flex-direction: column;
  align-items: center;

  .lado-user{
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
  .lado-meus-cursos{
    width: 95%;
    padding: 3rem 0 0 0;

    .meus-cursos-body{
      .cards-cursos{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .3rem;
        
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