<script>
import ListRanking from '../components/ListRanking.vue'
import dadosTemp from '../config/dadosTemp.js'

export default{
  name: 'Inicio',
  components:{ListRanking},
  data(){
    return{
      configRanking: {
        ranking: [],
        titulo: "Maior Pontuação",
        tituloTipo: "Total",
        tipoRanking: false,
        responseRanking: true

      },
      tituloButton: "+ COMPRADOS",
      url: null

    }
  },
  methods: {
    alternaRanking(){
      if(this.configRanking.titulo === "Maior Pontuação"){
        this.buscarMaisComprados()
        this.configRanking.titulo = "Mais Comprados"
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking
        this.tituloButton = "+ PONTOS"
        this.tipoRanking = !this.tipoRanking
 
      }else{
        this.buscarMaioresPontuacoes()
        this.configRanking.titulo = "Maior Pontuação"
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking
        this.tituloButton = "+ COMPRADOS"
        this.tipoRanking = !this.tipoRanking

      }
    },
    async buscarMaioresPontuacoes(){
      const response = await fetch(this.url+'buscaRanking.php?maioresPontuacoes=1', {
        method: "POST",
        body: JSON.stringify()
      }).catch(
        this.configRanking.responseRanking = true

      )
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_usuario != null){
          this.configRanking.ranking = []
          this.configRanking.ranking = dados
          this.configRanking.responseRanking = false

        }
      } 
    },
    async buscarMaisComprados(){
      const response = await fetch(this.url+'buscaRanking.php?maisComprados=1', {
        method: "POST",
        body: JSON.stringify()
      }).catch(
        this.configRanking.responseRanking = true

      ) 
      if(!response.ok){
        console.log(response.status)
        
      }else{
        const dados = await response.json()
        if(dados[0].pk_usuario != null){
          this.configRanking.ranking = []
          this.configRanking.ranking = dados
          this.configRanking.responseRanking = false

        }
      }        
    }
  },
  mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    //this.configRanking.ranking = dadosTemp
    var tempoResponse = setInterval(() => {
      if(this.configRanking.responseRanking){
        console.log("buscando")
        this.buscarMaioresPontuacoes()

      }else{
        clearInterval(tempoResponse)
        console.log("achou")

      }
    }, 3000)
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
        :disabled="configRanking.responseRanking"
        variant="success"
        v-on:click="alternaRanking()">{{tituloButton}}</b-button>
      <div
        v-if="tipoRanking"
        class="inicio-ranking-likes">
        <ListRanking
          :ranking=configRanking.ranking
          :titulo=configRanking.titulo
          :tituloTipo=configRanking.tituloTipo
          :tipoRanking=configRanking.tipoRanking
          :responseRanking="configRanking.responseRanking" />      
      </div>
      <div 
        v-else
        class="inicio-ranking-best-sellers">
        <ListRanking
          :ranking=configRanking.ranking
          :titulo=configRanking.titulo 
          :tituloTipo=configRanking.tituloTipo
          :tipoRanking=configRanking.tipoRanking
          :responseRanking="configRanking.responseRanking" />     
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
  margin: 2rem 0 0 0;
  
  .inicio-img-draw{
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;

    img{
      width: 70%;

    }
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
