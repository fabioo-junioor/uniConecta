<script>
export default {
  name: "Dashboard",
  data() {
    return {
      nomeUser: "Fabio Junior",
      totalPontos: 626,
      totalCoins: 515
      
    }
  }
}
</script>

<template>
  <div id="dashboard">
    <div class="lado-user">
      <div class="foto-user">
        <img src="../assets/img/person1.png">
      </div>
      <div class="dados-user">
        <h3>{{ nomeUser }}</h3>
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
    <div class="lado-cursos">
      <div class="cursos-comprados">
        <h4>Comprados</h4>
        <hr>
        <div class="cards-cursos"></div>
      </div>
      <div class="cursos-vendidos">
        <h4>Vendidos</h4>
        <hr>
        <div class="cards-cursos"></div>
      </div>
      <div class="cursos-avaliados">
        <h4>Avaliados</h4>
        <hr>
        <div class="cards-cursos"></div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
#dashboard {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  display: flex;
  flex-direction: row;
  justify-content: center;
  //background-color: red;
  
  .lado-user{
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3rem 2rem 0 0;
    //background-color: brown;

    .foto-user{
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 10px;
      padding: 1rem .2rem 0 .2rem;
      margin: 0 0 1rem 0;
      background-color: white;
      box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.3);

      img{
        max-height: 15rem;
        max-width: 15rem;
        padding: 0;

      }
    }
    .dados-user{
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      padding: 1rem 0 1rem 1rem;
      background-color: white;
      border: 1px solid rgba(0, 0, 0, 0.6);
      border-radius: 10px;

      h3{
        padding: 1rem 0;
        font-size: 1.2rem;
        width: 100%;

      }
      div{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        padding: .5rem 0;
        font-size: .9rem;
        //background-color: gray;
       
        img{
          height: 2rem;
          margin: .1rem;
          //background-color: red;
          
        }
      }
    }    
  }
  .lado-cursos{
    width: 70%;
    padding: 3rem 0 0 0;
    //background-color: red;

    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
      //background-color: blue;
      margin-bottom: 2rem;

      h4{
        font-size: 1.3rem;
        margin: 0;
        padding: 5px 0 2px 0;
        //background-color: blue;

      }
      hr{
        border: 1px solid black;
        margin: 0 0 .5rem 0;
        width: 100%;
        
      }
      .cards-cursos{
        background-color: white;
        height: 15rem;
        
      }
    }
  }
}
</style>