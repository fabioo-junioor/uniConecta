<script>
import ListRanking from "../components/ListRanking.vue";

export default {
  name: "Inicio",
  components: { ListRanking },
  data() {
    return {
      configRanking: {
        rankingPontuacao: null,
        rankingCompras: null,
        tituloRanking: "Maior Pontuação",
        tipoRanking: false,
        responseRanking: true,
      },
      tituloButton: "+ COMPRADOS",
      url: null,
    };
  },
  methods: {
    alternaRanking() {
      if (this.configRanking.tituloRanking === "Maior Pontuação") {
        this.buscarMaisComprados();
        this.configRanking.tituloRanking = "Mais Comprados";
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking;
        this.tituloButton = "+ PONTOS";
      } else {
        this.buscarMaioresPontuacoes();
        this.configRanking.tituloRanking = "Maior Pontuação";
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking;
        this.tituloButton = "+ COMPRADOS";
      }
    },
    async buscarMaioresPontuacoes() {
      const response = await fetch(this.url + "buscaRanking.php?maioresPontuacoes=1",{
          method: "POST",
          body: JSON.stringify(),
        }
      ).catch((
        this.configRanking.responseRanking = true
      
      ))
      if (!response.ok) {
        console.log(response.status);

      } else {
        const dados = await response.json();
        if (dados[0].pk_usuario != null) {
          this.configRanking.rankingPontuacao = dados;
          this.configRanking.responseRanking = false;
        
        } else {
          this.configRanking.responseRanking = false;
        
        }
      }
    },
    async buscarMaisComprados() {
      const response = await fetch(
        this.url + "buscaRanking.php?maisComprados=1",
        {
          method: "POST",
          body: JSON.stringify(),
        }
      ).catch((this.configRanking.responseRanking = true));
      if (!response.ok) {
        console.log(response.status);
      } else {
        const dados = await response.json();
        if (dados[0].pk_usuario != null) {
          this.configRanking.rankingCompras = dados;
          this.configRanking.responseRanking = false;
        } else {
          this.configRanking.responseRanking = false;
        }
      }
    },
  },
  mounted() {
    this.url = import.meta.env.VITE_ROOT_API;
    var tempoResponse = setInterval( async () => {
      if (this.configRanking.responseRanking) {
        this.buscarMaioresPontuacoes()

      } else {
        clearInterval(tempoResponse);
        
      }
    }, 3000);
  },
};
</script>

<template>
  <div id="inicio">
    <div class="inicio-texto">
      <h2>UniConecta</h2>
      <hr>
      <p>
        There are many variations of passages of Lorem Ipsum available, but the
        majority have suffered alteration in some form, by injected humour, or
        randomised words which don't look even slightly believable. If you are
        going to use a passage of Lorem Ipsum, you need to be sure there isn't
        anything embarrassing hidden in the middle of text. All the Lorem Ipsum
        generators on the Internet tend to repeat predefined chunks as
        necessary, making this the first true generator on the Internet. It uses
        a dictionary of over 200 Latin words, combined with a handful of model
        sentence structures, to generate Lorem Ipsum which looks reasonable. The
        generated Lorem Ipsum is therefore always free from repetition, injected
        humour, or non-characteristic words etc.
      </p>
    </div>
    <div class="inicio-ranking">
      <b-button
        :disabled="configRanking.responseRanking"
        variant="success"
        v-on:click="alternaRanking()"
        >{{ tituloButton }}</b-button
      >
      <div class="inicio-ranking-likes">
        <ListRanking
          :ranking="
            configRanking.tipoRanking
              ? configRanking.rankingCompras
              : configRanking.rankingPontuacao
          "
          :tituloRanking="configRanking.tituloRanking"
          :tipoRanking="configRanking.tipoRanking"
          :responseRanking="configRanking.responseRanking"
        />
      </div>
    </div>
  </div>
</template>


<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#inicio {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  padding: 0.5rem;
  margin: 5rem 0 1rem 0;

  .inicio-texto {
    width: 40%;
    font-family: 'Work Sans', sans-serif;

    h2{
      color: #6c63ff;
      font-weight: bold;

    }
    hr{
      border: 2px solid #6C63FF;
      width: 100%;
      
    }
    p{
      text-align: justify;
      font-size: 1rem;
      color: black;

    }

  }
  .inicio-ranking {
    width: 40%;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;

    .btn {
      margin-bottom: 0.3rem;
      color: #6c63ff;
      font-size: 0.7rem;
      font-weight: 500;
      border: 1px solid #6c63ff;
      padding: 0.5rem 0.4rem;
      background-color: transparent;
    }
    .btn:hover {
      background-color: #6c63ff;
      color: white;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
    }
    .inicio-ranking-likes,
    .inicio-ranking-best-sellers {
      width: 100%;
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
  #inicio {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0;
    margin: 1rem 0;

    .inicio-texto {
      width: 100%;
      margin: 1rem 0;
      padding: 0 1rem;

    }
    .inicio-ranking {
      width: 90%;
    }
  }
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>
