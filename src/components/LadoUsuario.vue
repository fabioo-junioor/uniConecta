<script>
export default {
  name: "LadoUsuario",
  data() {
    return {
      urlWp: "https://wa.me/",
      msgWp: "?text=Ola"
      
    }
  },
  props: {
    imagemPerfil: String,
    nomeUsuario: String,
    graduacao: String,
    totalMoedas: Number,
    totalPontos: Number,
    email: String,
    telefone: String,
    permissaoTelefone: Number,
    mediaStars: Number

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
          <div class="identificacao">
            <h2>{{ nomeUsuario }}</h2>
            <h3 
              v-if="graduacao">{{ graduacao }}</h3>
            <h4
              v-if="email">{{ email }}</h4>
            <h4 
            v-if="(permissaoTelefone == 1)&&(telefone)" >
            <a :href="urlWp+telefone+msgWp" target="_blank">Whatsapp</a></h4>
            <div
              v-if="totalMoedas">
                <img src="../assets/gifs/coin.gif" />
                {{ totalMoedas }} - Moedas
            </div>
            <div>
                <img src="../assets/gifs/points.gif" />
                {{ totalPontos }} - Pontos
            </div>
          </div>
          <div class="stars">
            <span>{{ mediaStars }}</span>
            <i class='bx bx-star'></i>
          </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#lado-user {
    font-family: 'Work Sans', sans-serif;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem 0 1rem 0;
    height: 100%;

    .foto-user {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0 1rem 0;
      border: 1px solid #6c63ff;
      box-shadow: 1px 1px 1px 1px #6c63ff;
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
      flex-direction: row;
      border: 1px solid #6c63ff;
      box-shadow: 1px 1px 1px 1px #6c63ff;
      border-radius: 5px;
      background-color: white;

      .identificacao{
        width: 80%;
        padding: 1rem 0 0 .5rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;

      }
      .stars{
        width: 20%;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        font-size: .9rem;

        i{
          color: #6c63ff;
          font-size: 1.2rem;
          padding-left: .3rem;

        }
      }
      h2 {
        padding: .2rem 0;
        font-size: 1rem;
        width: 100%;
      }
      h3 {
        padding: .2rem 0;
        font-size: 0.9rem;
        width: 100%;
      }
      h4{
        padding: .2rem 0;
        font-size: .8rem;

        a{
          text-decoration: none;
          color: #6c63ff;
          font-weight: 600;

        }
        a:hover{
          text-decoration: underline;
          
        }
        
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

        img {
          max-height: 1.8rem;
          max-width: 1.8rem;
          margin: .1rem .5rem .1rem 0;
          
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
        
        .identificacao{
          width: 75%;

        }
        .stars{
          width: 25%;
          font-size: .8rem;

          i{
            font-size: 1.1rem;

          }
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

        .identificacao{
          width: 70%;

        }
        .stars{
          width: 30%;

        }
      }
    }
}
@media only screen and (max-width: 720px) {
  #lado-user{
    .foto-user {        
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
      width: 85%;
      flex-direction: column-reverse;
      align-items: center;
      padding: .2rem;

      .identificacao{
        width: 95%;
        padding: 0;
        align-items: center;

      }
      .stars{
        width: 95%;
        justify-content: flex-end;
        font-size: .9rem;

        i{
          font-size: 1.2rem;
          padding-left: .3rem;

        }
      }
      h2, h3, h4 {
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
  #lado-user{
    .foto-user {        
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
      width: 90%;
      padding: .2rem 0;

    }
  }
}
@media only screen and (max-width: 360px) {
  #lado-user{
    .foto-user {        
      max-width: 15rem !important;
      max-height: 15rem !important;
      min-width: 14rem !important;
      min-height: 14rem !important;

      img {
        max-width: 14.5rem;
        max-height: 14.5rem;
        min-width: auto;
        min-height: auto;

      }
    }
  }
}
</style>