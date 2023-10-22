<script>
import { getDadosUsuarioLocal } from '../config/global.js'
import CardCursos from "../components/CardCursos.vue";
import ModalCadCurso from "../components/ModalCadCurso.vue";
import LadoUsuario from '../components/LadoUsuario.vue'
import ModalInfoCurso from '../components/ModalInfoCurso.vue'

export default {
  name: "PerfilUsuario",
  components: { CardCursos, LadoUsuario, ModalCadCurso, ModalInfoCurso },
  data() {
    return {
      pk_usuarioPerfil: null,
      pk_usuarioLogado: null,
      imagemPerfil: null,
      nomeUsuario: "",
      graduacao: "",
      totalPontos: null,
      totalMoedas: null,
      telefone: "",
      email: "",
      permissaoTelefone: null,
      cursosUsuario: null,
      url: null,
      dadosInfo: {
        pk_curso: null,
        cursoNome: "",
        tipoCurso: "",
        usuarioNome: "",
        totalHoras: null,
        valorCurso: null,
        descricao: ""

      }
    };
  },
  methods: {
    async buscaCursosUsuario(pk_usuario){
      const response = await fetch(this.url+'buscaCursosUsuario.php?buscaCursosUsuario=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuarioLogado: this.pk_usuarioLogado,
          pk_usuarioPerfil: pk_usuario

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log(dados)
        if(dados[0].pk_curso != null){
          this.cursosUsuario = dados

        }else{
          this.cursosUsuario = null

        }
      }
    },
    async buscaDadosUsuario(pk_usuario) {
      const response = await fetch(this.url+'buscaDadosUsuario.php?dadosPreview=1', {
        method: 'POST',
        body: JSON.stringify({
            pk_usuario: pk_usuario

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log("--> ", dados)
        this.nomeUsuario = dados[0].nome
        this.email = dados[0].email
        this.imagemPerfil = dados[0].img
        this.telefone = dados[0].telefone
        this.graduacao = dados[0].graduacao
        this.totalPontos = dados[0].total_pontos
        this.totalMoedas = dados[0].total_moedas
        this.permissaoTelefone = dados[0].permissaoTelefone

      }
    },
    async adicionarFavorito(pk_curso){
      let dadosUsuario = getDadosUsuarioLocal()
      const response = await fetch(this.url+'adicionaDeletaFavorito.php?adicionaFavorito=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_curso: pk_curso,
          fk_usuario: dadosUsuario[0].pk_usuario,
          email: dadosUsuario[0].email

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
      let dadosUsuario = getDadosUsuarioLocal()
      const response = await fetch(this.url+'adicionaDeletaFavorito.php?deletaFavorito=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_curso: pk_curso,
          fk_usuario: dadosUsuario[0].pk_usuario,
          email: dadosUsuario[0].email

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
      //console.log("info curso ", pk_curso)

    } 
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    let dadosUsuario = getDadosUsuarioLocal()
    this.pk_usuarioPerfil = parseInt(this.$route.params.pk)
    this.pk_usuarioLogado = (dadosUsuario == null) ? null : dadosUsuario[0].pk_usuario
    this.buscaCursosUsuario(this.pk_usuarioPerfil)
    this.buscaDadosUsuario(this.pk_usuarioPerfil)
    //console.log("logado-> ", this.pk_usuarioLogado, "perfil-> ",this.pk_usuarioPerfil)

  }
};
</script>

<template>
  <div id="perfil-usuario">
    <ModalInfoCurso
      :pk_curso="dadosInfo.pk_curso"
      :cursoNome="dadosInfo.cursoNome"
      :tipoCurso="dadosInfo.tipoCurso"
      :usuarioNome="dadosInfo.usuarioNome"
      :totalHoras="dadosInfo.totalHoras"
      :valorCurso="dadosInfo.valorCurso"
      :descricao="dadosInfo.descricao" />
    <div class="lado-user">
      <LadoUsuario
        :imagemPerfil="imagemPerfil"
        :nomeUsuario="nomeUsuario"
        :graduacao="graduacao"
        :totalMoedas="totalMoedas"
        :totalPontos="totalPontos"
        :telefone="telefone"
        :email="email"
        :permissaoTelefone="permissaoTelefone" />
    </div>
    <div class="lado-meus-cursos">
      <div class="meus-cursos-header">
        <h4>Cursos de: {{nomeUsuario}}</h4>
      </div>
      <div class="meus-cursos-body">
        <hr />
        <div class="cards-cursos">
          <CardCursos
            v-for="i in cursosUsuario" :key="i"
            :pk_curso="i.pk_curso"
            :cursoNome="i.cursoNome"
            :tipoCurso="i.tipoCurso"
            :usuarioNome="i.usuarioNome"
            :cursoDescricao="i.cursoDescricao"
            :totalFavoritos="i.totalFavoritos"
            :ativarFavorito="((pk_usuarioPerfil != pk_usuarioLogado)&&(pk_usuarioLogado != null)) ? true : false"
            :favoritou="i.favoritou != pk_usuarioLogado ? true : false"
            :desativarBotao="((pk_usuarioPerfil == pk_usuarioLogado)||(pk_usuarioLogado == null)||(i.cursoComprado == pk_usuarioLogado)) ? true : false"
            :ativarDelete="false"
            :tipo="2"
            @infoCurso="infoCurso"
            @adicionarFavorito="adicionarFavorito"
            @deletarFavorito="deletarFavorito" />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#perfil-usuario {
  font-family: "Work Sans", sans-serif;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  padding-bottom: 1rem;

  .lado-user {
    width: 20%;
    //background-color: rebeccapurple;
    
  }
  .lado-meus-cursos {
    width: calc(100vw - 22%);
    padding: 3rem 1rem 0 1rem;
    //background-color: greenyellow;

    .meus-cursos-header {
      //background-color: red;
      display: flex;
      justify-content: space-between;
      padding: 0.2rem;

      h4 {
        font-size: 1.3rem;
        margin: 0;
        padding: 5px 0 2px 0;
      }
      button {
        font-family: "Work Sans", sans-serif;
        border-radius: 5px;
        color: #6b63ff;
        background-color: transparent;
        border: 1px solid #6b63ff;
      }
      button:hover {
        background-color: #6b63ff;
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
        color: white;
      }
    }
    .meus-cursos-body {
      //background-color: blue;

      hr {
        border: 1px solid #6c63ff;
        margin: 0 0 0.5rem 0;
        width: 100%;
        margin-bottom: 1rem;

      }
      .cards-cursos {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.5rem;
        align-items: stretch;
        
      }
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
  #perfil-usuario {
    .lado-meus-cursos {
      .meus-cursos-body {
        .cards-cursos {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: .3rem;

        }
      }
    }
  }
}
@media only screen and (max-width: 992px) {
  #perfil-usuario{  
    .lado-user{
      width: 25%;

    }
    .lado-meus-cursos{
      width: 70%;
      .meus-cursos-body{
        .cards-cursos{
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: .3rem;
          
        }
      }
    }
  }
}
@media only screen and (max-width: 720px) {
  #perfil-usuario{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-bottom: 1rem;

    .lado-user{
      width: 95%;

    }
    .lado-meus-cursos{
      width: 95%;
      padding: 3rem 0 0 0;

      .meus-cursos-body{
        .cards-cursos{
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: .3rem;
          
        }
      }
    }
  }
}
@media only screen and (max-width: 481px) {
  #perfil-usuario{
    .lado-meus-cursos{
      .meus-cursos-body{
        .cards-cursos{
          display: grid;
          grid-template-columns: repeat(1, 1fr);
          gap: .3rem;
          
        }
      }
    }
  }
}
@media only screen and (max-width: 360px) {
}
</style>