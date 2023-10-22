<script>
import { getDadosUsuarioLocal } from '../config/global'
import CardCursos from '../components/CardCursos.vue'
import ModalInfoCurso from '../components/ModalInfoCurso.vue'

export default {
  name: "Cursos",
  components: {CardCursos, ModalInfoCurso},
  data() {
    return {
      pk_usuario: null,
      email: "",
      todosCursos: null,
      url: null,
      dadosInfo: {
        pk_curso: null,
        cursoNome: "",
        tipoCurso: "",
        usuarioNome: "",
        totalHoras: null,
        valorCurso: null,
        descricao: "",
        totalFavoritos: null,
        pk_favorito: null

      }       
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
    async buscaInfoCurso(pk_curso){
      const response = await fetch(this.url+'buscaInfoCurso.php?buscaInfoCurso=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_curso: pk_curso
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        this.dadosInfo.pk_curso = dados[0].pk_curso
        this.dadosInfo.cursoNome = dados[0].cursoNome
        this.dadosInfo.tipoCurso = dados[0].tipoCurso
        this.dadosInfo.usuarioNome = dados[0].usuarioNome
        this.dadosInfo.totalHoras = dados[0].totalHoras
        this.dadosInfo.valorCurso = dados[0].valorCurso
        this.dadosInfo.descricao = dados[0].cursoDescricao
        this.dadosInfo.totalFavoritos = dados[0].totalFavorito
        this.dadosInfo.pk_favorito = dados[0].pk_favorito
        
      }
    },
    async infoCurso(pk_curso){
      await this.buscaInfoCurso(pk_curso)
      this.$root.$emit('bv::show::modal', 'modalInfoCurso')    
      console.log("info curso ", pk_curso)

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
    <ModalInfoCurso
      :pk_curso="dadosInfo.pk_curso"
      :cursoNome="dadosInfo.cursoNome"
      :tipoCurso="dadosInfo.tipoCurso"
      :usuarioNome="dadosInfo.usuarioNome"
      :totalHoras="dadosInfo.totalHoras"
      :valorCurso="dadosInfo.valorCurso"
      :descricao="dadosInfo.descricao" />
    <div class="titulo-pagina-cursos">
      <h3>Cursos</h3>
      <hr>
    </div>
    <div class="lado-cursos">
      <CardCursos
        v-for="i in todosCursos" :key="i"
        :pk_curso="i.pk_curso"
        :fk_usuarioCurso="i.fk_usuarioCurso"
        :fk_comprador="i.fk_comprador"
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
        @infoCurso="infoCurso"
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
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem 0;

    h3{
      color: black;
      font-weight: 500;
      font-size: 2.5rem;

    }
    hr{
      border: 1px solid #6C63FF;
      margin: .5rem 0 1rem 0;
      width: 80%;
        
    }
  }
  .lado-cursos{
    padding: .5rem 0;
    display: flex;
    justify-content: center;

    #card-cursos{
      margin: .2rem;
      width: 15rem;
      
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 990px) {
}
@media only screen and (max-width: 720px) {
}
@media only screen and (max-width: 481px) {
  #cursos{
    .lado-cursos{
      padding: .5rem 0;
      display: flex;
      flex-direction: column;
      align-items: center;

      #card-cursos{
        margin: .3rem 0;
        width: 20rem;
        
      }
    }
  }
}
@media only screen and (max-width: 360px) {
  #cursos{
    .lado-cursos{
      #card-cursos{
        margin: .3rem 0;
        width: 15rem;
        
      }
    }
  }
}
</style>