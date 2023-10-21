<script>
import { getDadosUsuarioLocal } from '../config/global'
import CardCursos from '../components/CardCursos.vue'

export default {
  name: "Cursos",
  components: {CardCursos},
  data() {
    return {
      pk_usuario: null,
      email: "",
      todosCursos: null,
      url: null
      
    }
  },
  methods: {
    async buscaTodosCursos(){
      const response = await fetch(this.url+'buscaCursos.php?buscaTodosCursos=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: this.pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log("->", dados)
        if(dados[0].pk_curso != null){
          this.todosCursos = dados

        }else{
          this.todosCursos = null

        }
      }
    },
    async adicionarFavorito(pk_curso){
      const response = await fetch(this.url+'adicionaDeletaFavorito.php?adicionaFavorito=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_curso: pk_curso,
          fk_usuario: this.pk_usuario,
          email: this.email
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        console.log("adicionou favorito")
        location.reload()
        
      }
    },
    async deletarFavorito(pk_curso){
      const response = await fetch(this.url+'adicionaDeletaFavorito.php?deletaFavorito=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_curso: pk_curso,
          fk_usuario: this.pk_usuario,
          email: this.email
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        console.log("deletou favorito")
        location.reload()
        
      }
    },
    async atualizaDados(dadosUsuario){
      this.pk_usuario = dadosUsuario == null ? null : dadosUsuario[0].pk_usuario
      this.email = dadosUsuario == null ? "" : dadosUsuario[0].email

    }
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    let dadosUsuario = getDadosUsuarioLocal()
    this.atualizaDados(dadosUsuario)
    this.buscaTodosCursos()

  }
}
</script>

<template>
  <div id="cursos">
    <div class="titulo-pagina-cursos">
      <h3>Cursos</h3>
    </div>
    <div class="lado-cursos">
      <CardCursos
        v-for="i in todosCursos" :key="i"
        :pk_curso="i.pk_curso"
        :cursoNome="i.cursoNome"
        :tipoCurso="i.tipoCurso"
        :usuarioNome="i.usuarioNome"
        :cursoDescricao="i.cursoDescricao"
        :totalFavoritos="i.totalFavoritos"
        :ativarFavorito="((i.fk_usuarioCurso != pk_usuario)&&(pk_usuario != null)) ? true : false"
        :favoritou="i.favoritou != pk_usuario ? true : false"
        :ativarDelete="false"
        :desativarBotao="((i.fk_usuarioCurso == pk_usuario)||(pk_usuario == null)||(i.cursoComprado == pk_usuario)) ? true : false"
        :tipo="2"
        @adicionarFavorito="adicionarFavorito"
        @deletarFavorito="deletarFavorito" />
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#cursos {
  font-family: 'Work Sans', sans-serif;
  display: flex;
  flex-direction: column;
  padding: 2rem .5rem 0 .5rem;

  .titulo-pagina-cursos{
    text-align: center;
    padding: 1rem 0;

    h3{
      color: black;
      font-weight: 600;
      font-size: 2rem;

    }
  }
  .lado-cursos{
    padding: .5rem 0;
    display: flex;
    justify-content: center;

    #card-cursos{
      margin: .1rem;
      align-items: stretch;
      width: 15rem;
      
    }
  }
}
/* Responsive */
</style>