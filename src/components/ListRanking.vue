<script>
export default {
  name: "ListRanking",
  data() {
    return {};
  },
  props: {
    titulo: String,
    tituloTipo: String,
    cursos: Array,
  },
};
</script>

<template>
  <div id="list-ranking">
    <h3>{{ titulo }}</h3>
    <v-table>
      <thead>
        <tr>
          <th class="text-left">#</th>
          <th class="text-left">NOME CURSO</th>
          <th class="text-left">AUTOR</th>
          <th class="text-left">{{ tituloTipo }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="curso in cursos" :key="curso.codigo">
          <td>
            <b-avatar
              variant="info"
              size="50"
              :src="curso.src"
              ></b-avatar>
          </td>
          <td>{{ curso.nome }}</td>
          <td>{{ curso.autor }}</td>
          <td>{{ curso.pontos }}</td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>


<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#list-ranking {
  font-family: 'Work Sans', sans-serif;
  display: flex;
  flex-direction: column;
  align-items: stretch;
  width: 100%;
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
  border-radius: 5px;
  border: 2px solid #6C63FF;
  background-color: #6C63FF;

  h3 {
    color: white;
    font-size: 1rem;
    font-weight: bold;
    padding: .1rem;
    margin: 1.5rem 0;
    text-align: center;
  
  }
  .v-table{
    th, td{
      padding: .7rem .5rem;

    }
  }
}
</style>
