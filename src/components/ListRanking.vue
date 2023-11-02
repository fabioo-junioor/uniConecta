<script>
export default {
  name: "ListRanking",
  data() {
    return {

    }
  },
  methods: {
    perfilUsuario(){
      this.$router.push({name: 'perfilUsuario'})
      
    }
  },
  props: {
    ranking: Array,
    tituloRanking: String,
    tipoRanking: Boolean,
    responseRanking: Boolean,
  },
};
</script>

<template>
  <div id="list-ranking">
    <h3>{{ tituloRanking }}</h3>
    <b-spinner v-if="responseRanking" variant="light"></b-spinner>
    <div v-if="!tipoRanking">
      <v-table>
        <thead>
          <tr>
            <th class="text-left">Posição</th>
            <th class="text-left">Usuário</th>
            <th class="text-left">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(r, i) in ranking" :key="r">
            <td>{{ i + 1 }}º</td>
            <td>
              <router-link :to="{name: 'perfilUsuario', params:{ pk: r.pk_usuario } }">
                {{ r.nomeUsuario }}
              </router-link>
            </td>
            <td>{{ r.totalPontos }}</td>
          </tr>
        </tbody>
      </v-table>
    </div>
    <div v-else>
      <v-table>
        <thead>
          <tr>
            <th class="text-left">Posição</th>
            <th class="text-left">Titulo</th>
            <th class="text-left">Criador</th>
            <th class="text-left">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(r, i) in ranking" :key="r">
            <td>{{ i + 1 }}º</td>
            <td>{{ r.nomeCurso }}</td>
            <td>
              <router-link :to="{name: 'perfilUsuario', params:{ pk: r.pk_usuario } }">
                {{ r.nomeUsuario }}
              </router-link>
            </td>
            <td>{{ r.totalCompras }}</td>
          </tr>
        </tbody>
      </v-table>
    </div>
  </div>
</template>


<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#list-ranking {
  font-family: "Work Sans", sans-serif;
  display: flex;
  padding: 0;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  box-shadow: 2px 2px 1px 1px rgba(0, 0, 0, 0.3);
  border-radius: 5px;
  border: 1px solid #6c63ff;
  background-color: #6c63ff;

  h3 {
    color: white;
    font-size: 1rem;
    font-weight: bold;
    padding: 0.1rem;
    margin: 1.5rem 0;
    text-align: center;

  }
  div{
    width: 100%;

    .v-table {
      width: 100%;
      margin-top: 0.5rem;

      th {
        font-weight: bold;
        color: black;
      }
      td:nth-child(1) {
        padding-left: 1.2rem;
        font-weight: bold;
        color: black;
      }
      th, td {
        padding: 0.7rem 0.5rem;

        a{
          text-decoration: none;
          color: #6c63ff;
          text-decoration: underline;

        }
        a:hover{
          font-weight: bold;
          
        }
      }
      td::first-letter {
        text-transform: uppercase;
      }
    }
  }
}
/* Responsive */
</style>
