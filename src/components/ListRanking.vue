<script>
import cursos from '../js/dados.js'

export default{
  name: 'ListRanking',
  data(){
    return{
      tituloList: "sdas"

    }
  }
}
</script>

<template>
  <div id="list-ranking">
    <b-list-group>
      <h3>{{tituloList}}</h3>
      <b-list-group-item v-for="curso in cursos" :key="curso">
        <div>
          <b-card no-body class="overflow-hidden">
            <b-row no-gutters>
              <b-col md="2" class="img-logo">
                <b-card-img
                  src="https://picsum.photos/400/400/?image=20"
                  alt="Image"
                  class="rounded-0"
                ></b-card-img>
              </b-col>
              <b-col md="8" class="nome-criador">
                <b-card-body :title="curso.nome">
                  <b-card-text>
                    {{curso.criador}}
                  </b-card-text>
                </b-card-body>
              </b-col>
              <b-col md="2" class="posicao">
                {{curso.pontos}}
              </b-col>
            </b-row>
          </b-card>
        </div>
      </b-list-group-item>
    </b-list-group>
  </div>
</template>


<style lang="scss" scoped>
#list-ranking {
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
  border-radius: 5px;

  .list-group-item{
    padding: .1rem;
    border: none;

    .img-logo{
      display: flex;
      align-items: center;
      justify-content: center;
      
      img{
        width: 100%;
        border-radius: 50px !important;

      }
    }
    .nome-criador{
      display: flex;
      align-items: center;
      padding: 0;

      .card-body{
        padding: 0;

        h4{
          color: blue !important;
          font-size: 1rem;
          background-color: aquamarine;

        }

      }
    }
    .posicao{
      display: flex;
      align-items: center;
      justify-content: flex-start;
      padding: 1px;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      font-size: .8rem;
      background-color: red;
      color: black;

    }
  }

}
</style>
