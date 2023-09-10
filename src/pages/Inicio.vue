<script>
import ListRanking from '../components/ListRanking.vue'
import cursos from '../js/dados.js'

export default{
  name: 'Inicio',
  components:{ListRanking},
  data(){
    return{
      configRanking: {
        cursos,
        titulo: "MAIS CURTIDOS",
        tituloTipo: "TOTAL",
        tipoRanking: false

      },
      tituloButton: "+ COMPRADOS"

    }
  },
  methods: {
    alternaRanking(){
      console.log("clicou")
      this.tipoRanking = !this.tipoRanking
      if(this.configRanking.titulo === "MAIS CURTIDOS"){
        this.configRanking.titulo = "MAIS COMPRADOS"
        //this.configRanking.tituloTipo = "COMPRAS"
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking
        this.tituloButton = "+ CURTIDOS"

      }else{
        this.configRanking.titulo = "MAIS CURTIDOS"
        //this.configRanking.tituloTipo = "LIKES"
        this.configRanking.tipoRanking = !this.configRanking.tipoRanking
        this.tituloButton = "+ COMPRADOS"

      }
    }
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
          :cursos=configRanking.cursos
          :titulo=configRanking.titulo
          :tituloTipo=configRanking.tituloTipo />      
      </div>
      <div 
        v-else
        class="inicio-ranking-best-sellers">
        <ListRanking
          :cursos=configRanking.cursos
          :titulo=configRanking.titulo 
          :tituloTipo=configRanking.tituloTipo />     
      </div>
    </div>
  </div>
</template>


<style lang="scss" scoped>
#inicio {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 3rem .5rem 0 .5rem;
  height: 100%;

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
      color: white;
      font-size: .7rem;
      font-weight: 500;
      border: none;
      padding: .5rem .4rem;
      background-color: #6C63FF;

    }
    .btn:hover{
      background-color: #6b63ffcc;

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
      max-width: 20rem;

    }
  }
  .inicio-ranking{
    width: 95%;

  }
}
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>
