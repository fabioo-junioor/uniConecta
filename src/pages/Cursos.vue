<script>
import { getDadosUsuarioLocal } from "../config/global.js"
import CardCursos from '../components/CardCursos.vue'
import Alerta from '../components/Alerta.vue'
import ModalInfoCurso from '../components/ModalInfoCurso.vue'

export default {
  name: "Cursos",
  components: {CardCursos, ModalInfoCurso, Alerta},
  data() {
    return {
      pk_usuario: null,
      email: "",
      todosCursos: null,
      url: null,
      spinner: true,
      search: "",
      dadosInfo: {
        pk_curso: null,
        cursoNome: "",
        tipoCurso: "",
        usuarioNome: "",
        totalHoras: null,
        valorCurso: null,
        dataCurso: "",
        horario: "",
        localCurso: "",
        descricao: "",
        linkMaterial: "",
        totalFavoritos: null,
        pk_favorito: null

      },
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false,
      },     
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
      .catch(
        this.spinner = true

      )
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_curso != null){
          this.todosCursos = dados
          this.spinner = false

        }else{
          this.todosCursos = null
          this.spinner = false

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
        this.dadosInfo.dataCurso = dados[0].dataCurso
        this.dadosInfo.localCurso = dados[0].localCurso
        this.dadosInfo.horario = dados[0].horario
        this.dadosInfo.descricao = dados[0].cursoDescricao
        this.dadosInfo.linkMaterial = dados[0].linkMaterial
        this.dadosInfo.totalFavoritos = dados[0].totalFavorito
        this.dadosInfo.pk_favorito = dados[0].pk_favorito
        
      }
    },
    async infoCurso(pk_curso){
      await this.buscaInfoCurso(pk_curso)
      this.$root.$emit('bv::show::modal', 'modalInfoCurso')

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
        this.mensagemAlerta(2)
        
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
        this.mensagemAlerta(3)
        
      }
    },
    async comprarCurso(pk_curso, fk_usuarioCurso){
      const response = await fetch(this.url+'compraCurso.php?compraCurso=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_comprador: this.pk_usuario,
          fk_vendedor: fk_usuarioCurso,
          fk_curso: pk_curso

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_compra_venda != null){
          this.mensagemAlerta(1)

        }else{
          this.mensagemAlerta(4)

        }        
      }
    },
    async atualizaDados(){
      let dadosUsuario = await getDadosUsuarioLocal()
      this.pk_usuario = dadosUsuario == null ? null : dadosUsuario[0].pk_usuario
      this.email = dadosUsuario == null ? "" : dadosUsuario[0].email

    },
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Compra realizada. Fale com o vendedor!"
        this.alerta.tipo = "success"
        this.alerta.isAlert = true

      }else if(id == 2){
        this.alerta.mensagem = "Favoritou curso!"
        this.alerta.tipo = "info"
        this.alerta.isAlert = true

      }else if(id == 3){
        this.alerta.mensagem = "Desfavoritou curso!"
        this.alerta.tipo = "info"
        this.alerta.isAlert = true

      }else if(id == 4){
        this.alerta.mensagem = "Moedas insuficientes!"
        this.alerta.tipo = "warning"
        this.alerta.isAlert = true

      }
      this.resetaAlerta(id)

    },
    resetaAlerta(id){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

        return (id != 4) ? location.reload() : false

      }, 4500)
    }
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    this.atualizaDados()
    var tempoResponse = setInterval(() => {
      if(this.spinner){
        this.buscaTodosCursos()

      }else{
        clearInterval(tempoResponse)

      }
    }, 1500)
  },
  computed: {
    filtrarLista(){
      if(this.todosCursos != null){
        return this.todosCursos.filter(i => {
          return i.cursoNome.toLowerCase().includes(this.search.toLocaleLowerCase())
  
        })
      }else{
        return null

      }
    }
  }
}
</script>

<template>
  <div id="cursos">
    <Alerta
      v-if="alerta.isAlert"
      :mensagem="alerta.mensagem"
      :tipo="alerta.tipo" />
    <ModalInfoCurso
      :pk_curso="dadosInfo.pk_curso"
      :cursoNome="dadosInfo.cursoNome"
      :tipoCurso="dadosInfo.tipoCurso"
      :usuarioNome="dadosInfo.usuarioNome"
      :totalHoras="dadosInfo.totalHoras"
      :valorCurso="dadosInfo.valorCurso"
      :dataCurso="dadosInfo.dataCurso"
      :horario="dadosInfo.horario"
      :localCurso="dadosInfo.localCurso"
      :descricao="dadosInfo.descricao"
      :linkMaterial="dadosInfo.linkMaterial" />
    <div class="titulo-pagina-cursos">
      <h3>Cursos</h3>
      <hr>
      <div class="input-buscar-pagina-cursos">
        <b-form-input
          debounce="500"
          v-model="search"
          type="text"
          placeholder="Buscar pelo titulo... "
          ></b-form-input>
      </div>
    </div>
    <div class="cursos-pagina-cursos">
      <div
        class="cards-pagina-cursos"
        v-if="!spinner">
        <CardCursos
          v-for="i in filtrarLista" :key="i"
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
          :desativarBotao="((i.fk_usuarioCurso == pk_usuario)||(pk_usuario == null)/*||(i.cursoComprado == pk_usuario)*/) ? true : false"
          :tipo="2"
          @infoCurso="infoCurso"
          @adicionarFavorito="adicionarFavorito"
          @deletarFavorito="deletarFavorito"
          @comprarCurso="comprarCurso" />
      </div>
      <div
        class="spinner-pagina-curso" 
        v-else>
        <b-spinner variant="primary"></b-spinner>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#cursos {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem .5rem 0 .5rem;

  .titulo-pagina-cursos{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem 0;
    width: 100%;

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
    .input-buscar-pagina-cursos{
      width: 30%;

      input{
        height: 3rem;
        border: 1px solid #6c63ff;
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 0px 0px #6C63FF;
        color: black;
        
      }
    }
  }
  .cursos-pagina-cursos{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;

    .cards-pagina-cursos{
      padding: .5rem 0;
      display: flex;
      justify-content: flex-start;
      flex-wrap: wrap;
  
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 990px) {
  #cursos {
    .titulo-pagina-cursos{
      .input-buscar-pagina-cursos{
        width: 60%;

      }
    }
    .cursos-pagina-cursos{
      .cards-pagina-cursos{
        justify-content: center;
    
      }
    }
  }
}
@media only screen and (max-width: 720px) {
  #cursos {
    .titulo-pagina-cursos{
      .input-buscar-pagina-cursos{
        width: 70%;

      }
    }
  }
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>