<script>
export default {
  name: "LadoUsuario",
  data() {
    return {
      
    }
  },
  props: {
    imagemPerfil: String,
    nomeUsuario: String,
    graduacao: String,
    totalMoedas: Number,
    totalPontos: Number

  }
};
</script>
<template>
    <div id="lado-user">
        <div class="foto-user">
        <img
            v-if="!imagemPerfil"
            src="../assets/img/person1.png" />
        <img
            v-else
            :src="imagemPerfil" />
        </div>
        <div class="dados-user">
        <h3>{{ nomeUsuario }}</h3>
        <h2>{{ graduacao }}</h2>
        <div>
            <img src="../assets/gifs/coin.gif" />
            {{ totalMoedas }}
        </div>
        <div>
            <img src="../assets/img/trophy.png" />
            {{ totalPontos }}
        </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#lado-user {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3rem 0 0 0;
    height: 100%;

    .foto-user {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0 1rem 0;
      border: 1px solid #6c63ff;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      padding: .3rem;
      
      max-width: 16rem !important;
      max-height: 16rem !important;
      min-width: 15rem !important;
      min-height: 15rem !important;

      img {
        border-radius: 5px;
        max-width: 15.5rem;
        max-height: 15.5rem;
        min-width: auto;
        min-height: auto;

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
      h3::first-letter, h2::first-letter{
        text-transform: uppercase;
        
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
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
    #lado-user{
      .foto-user{
        max-width: 13rem !important;
        max-height: 13rem !important;
        min-width: 12rem !important;
        min-height: 12rem !important;

        img{
          max-height: 12.5rem;
          max-width: 12.5rem;

        }
      }
      .dados-user {
        width: 95%;

        div {
          display: flex;
          flex-direction: row;
          align-items: center;
          justify-content: flex-start;

        }
      }
    }
}
@media only screen and (max-width: 992px) {
  #lado-user{
      .foto-user{
        max-width: 12rem !important;
        max-height: 12rem !important;
        min-width: 11rem !important;
        min-height: 11rem !important;

        img{
          max-height: 11.5rem;
          max-width: 11.5rem;

        }
      }
      .dados-user {
        width: 95%;

        div {
          display: flex;
          flex-direction: row;
          align-items: center;
          justify-content: flex-start;

        }
      }
    }
}
@media only screen and (max-width: 720px) {
  #lado-user{
      .dados-user {
        width: 70%;
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
}
@media only screen and (max-width: 481px) {
  #editar-perfil{
    .lado-user{
      .dados-user {
        width: 80%;

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
    .lado-edicao{
      width: 95%;

      form{
        padding: 0;

      }
    }
  }
}
@media only screen and (max-width: 360px) {
  #editar-perfil{
    .lado-edicao{
      .preview-imagem{
        max-width: 16rem !important;
        max-height: auto !important;
        min-width: 15rem !important;
        min-height: 15rem !important;

        img{
          max-height: 15rem;
          max-width: 15rem;

        }
      }
    }
  }
}
</style>