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
      const response = await fetch(
        this.url + "buscaRanking.php?maioresPontuacoes=1",
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
    var tempoResponse = setInterval(async () => {
      if (this.configRanking.responseRanking) {
        this.buscarMaioresPontuacoes();
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
      <hr />
      <p>
        Este projeto tem como objetivo ajudar na colaboração entre os estudantes
        da UFSM, através da criação e divulgação de
        <span class="text-bold">unidades de estudo</span>. Cada unidade de
        estudo pode compreender diferentes formas de atividades como: cursos,
        aulas, oficinas, etc, pois os mesmos estarão centralizados em um mesmo
        lugar. A plataforma está baseada em um
        <span class="text-bold">sistema de troca</span> que não envolve
        <span class="text-bold">dinheiro real</span> e sim
        <span class="text-bold">moedas virtuais</span>. A mesma também dispõe de
        alguns elementos de gamificação como: moedas virtuais, pontos e ranking,
        que têm como intuito proporcionar uma maior motivação aos usuários.<br />
        O usuário que quiser compartilhar algum conhecimento específico, poderá
        cadastrar sua “unidade” na plataforma para que outros possam adquiri-la,
        o usuário definirá valor, duração descrição, título, etc. <br />
        <span class="text-bold">Exemplo:</span> O aluno João gostaria de vender
        uma aula de 2 horas de estatística básica no valor de 10 moedas, o mesmo
        cadastra essa aula na plataforma e quem se interessar efetuará a compra
        no valor pré definido. A cada venda desta aula João irá ganhar 10
        moedas, assim, poderá usá-las para comprar a unidade que desejar.<br />
        <span class="text-bold">Observação importante:</span> toda a troca de
        conhecimento acontecerá de forma externa a plataforma, a mesma é somente
        para divulgação e interação dos usuários.
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
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#inicio {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  padding: 0.5rem;
  margin: 5rem 0 1rem 0;

  .inicio-texto {
    width: 40%;
    font-family: "Work Sans", sans-serif;

    h2 {
      color: #6c63ff;
      font-weight: bold;
    }
    hr {
      border: 2px solid #6c63ff;
      width: 100%;
    }
    p {
      text-align: justify;
      font-size: 1rem;
      color: black;

      .text-bold {
        font-weight: bold;
        color: #6c63ff;
      }
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
