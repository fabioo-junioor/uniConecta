<script>
import ListRanking from '../components/ListRanking.vue'
import { url } from '../config/global.js'

export default{
  name: 'Inicio',
  components:{ListRanking},
  data(){
    return{
      configRanking: {
        ranking: [],
        titulo: "Maior Pontuação",
        tituloTipo: "TOTAL",
        tipoRanking: false

      },
      tituloButton: "+ COMPRADOS"

    }
  },
  methods: {
    alternaRanking(){
      this.tipoRanking = !this.tipoRanking
      if(this.configRanking.titulo === "Maior Pontuação"){
        this.configRanking.titulo = "Mais Comprados"
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking
        this.tituloButton = "+ PONTOS"
        this.buscarMaisComprados()

      }else{
        this.configRanking.titulo = "Maior Pontuação"
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking
        this.tituloButton = "+ COMPRADOS"
        this.buscarMaioresPontuacoes()

      }
    },
    buscarMaioresPontuacoes(){
      fetch(url+'buscaRanking.php?maioresPontuacoes=1', {
        method: "POST",
        body: JSON.stringify()
      })
      .then((res) => res.json())
      .then((dados) => {
        if(dados[0].pk_usuario != null){
          console.log(dados)
          this.configRanking.ranking = []
          this.configRanking.ranking = dados

        }
      })
    },
    buscarMaisComprados(){
      fetch(url+'buscaRanking.php?maisComprados=1', {
        method: "POST",
        body: JSON.stringify()
      })
      .then((res) => res.json())
      .then((dados) => {
        if(dados[0].pk_usuario != null){
          console.log(dados)
          this.configRanking.ranking = []
          this.configRanking.ranking = dados

        }
      })
    }
  },
  created(){
    console.log("criou ranking")
    this.buscarMaioresPontuacoes()

  }
}
</script>

<template>
  <div id="inicio">
    <div class="inicio-img-draw">
      <img src="../assets/draw/sharing_knowledge.svg">
    </div>
    <div class="inicio-ranking">
      <b-button
        variant="success"
        v-on:click="alternaRanking()">{{tituloButton}}</b-button>
      <div
        v-if="tipoRanking"
        class="inicio-ranking-likes">
        <ListRanking
          :ranking=configRanking.ranking
          :titulo=configRanking.titulo
          :tituloTipo=configRanking.tituloTipo
          :tipoRanking=configRanking.tipoRanking />      
      </div>
      <div 
        v-else
        class="inicio-ranking-best-sellers">
        <ListRanking
          :ranking=configRanking.ranking
          :titulo=configRanking.titulo 
          :tituloTipo=configRanking.tituloTipo
          :tipoRanking=configRanking.tipoRanking />     
      </div>
    </div>
  </div>
</template>


<style lang="scss" scoped>
#inicio {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: .5rem;
  margin: .5rem 0 1rem 0;

  .inicio-img-draw{
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;

  }
  .inicio-ranking{
    width: 40%;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;

    .btn{
      margin-bottom: .3rem;
      color: #6C63FF;
      font-size: .7rem;
      font-weight: 500;
      border: 1px solid #6C63FF;
      padding: .5rem .4rem;
      background-color: transparent;

    }
    .btn:hover{
      background-color: #6C63FF;
      color: white;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);

    }
    .inicio-ranking-likes,
    .inicio-ranking-best-sellers{
      width: 100%;

    }
  }
}
/*################################################*/
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

  .inicio-img-draw{
    width: 100%;
    margin: 1rem 0;

    img{
      max-width: 15rem;

    }
  }
  .inicio-ranking{
    width: 90%;
    
  }
}
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>
