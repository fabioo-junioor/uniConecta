<script>
import { getDadosUsuarioLocal } from '../config/global.js'
import CardCursos from "../components/CardCursos.vue";
import ModalCadCurso from "../components/ModalCadCurso.vue";
import LadoUsuario from '../components/LadoUsuario.vue'
import ModalInfoCurso from '../components/ModalInfoCurso.vue'
import Alerta from '../components/Alerta.vue'

export default {
  name: "MeusCursos",
  components: { CardCursos, Alerta, ModalCadCurso, LadoUsuario, ModalInfoCurso },
  data() {
    return {
      pk_usuario: null,
      imagemPerfil: null,
      nomeUsuario: "",
      graduacao: "",
      totalPontos: null,
      totalMoedas: null,
      telefone: "",
      email: "",
      permissaoTelefone: null,
      meusCursos: null,
      url: null,
      dadosInfo: {
        pk_curso: null,
        cursoNome: "",
        tipoCurso: "",
        usuarioNome: "",
        totalHoras: null,
        valorCurso: null,
        descricao: ""

      },
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false,
      } 
    };
  },
  methods: {
    async buscaMeusCursos(dadosUsuario){
      const response = await fetch(this.url+'buscaCursos.php?buscaMeusCursos=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log(dados)
        if(dados[0].pk_curso != null){
          this.meusCursos = dados

        }else{
          this.meusCursos = null

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
        //console.log(dados)
        this.dadosInfo.pk_curso = dados[0].pk_curso
        this.dadosInfo.cursoNome = dados[0].cursoNome
        this.dadosInfo.tipoCurso = dados[0].tipoCurso
        this.dadosInfo.usuarioNome = dados[0].usuarioNome
        this.dadosInfo.totalHoras = dados[0].totalHoras
        this.dadosInfo.valorCurso = dados[0].valorCurso
        this.dadosInfo.descricao = dados[0].cursoDescricao
        
      }
    },
    async infoCurso(pk_curso){
      await this.buscaInfoCurso(pk_curso)
      this.$root.$emit('bv::show::modal', 'modalInfoCurso')    

    },
    async deletarCurso(pk_curso){
      const response = await fetch(this.url+'deletarCurso.php?deletarCurso=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_curso: pk_curso,
          pk_usuario: this.pk_usuario

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_avaliacao != null){
          this.mensagemAlerta(2)

        }else{
          await deleteDadosUsuario()
          await dadosUsuarioPreview(this.pk_usuario)
          this.mensagemAlerta(1)

        }        
      }
    },
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Curso apagado!"
        this.alerta.tipo = "info"
        this.alerta.isAlert = true

      }else if(id == 2){
        this.alerta.mensagem = "Avaliação pendente"
        this.alerta.tipo = "info"
        this.alerta.isAlert = true

      }
      this.resetaAlerta(id)

    },
    resetaAlerta(id){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

        return (id != 2) ? location.reload() : false

      }, 4500)
    },
    async atualizaDadosPreview(dadosUsuario) {
      this.pk_usuario = dadosUsuario[0].pk_usuario;
      this.nomeUsuario = dadosUsuario[0].nome;
      this.graduacao = dadosUsuario[0].graduacao;
      this.totalMoedas = dadosUsuario[0].total_moedas;
      this.totalPontos = dadosUsuario[0].total_pontos;
      this.imagemPerfil = dadosUsuario[0].img;
      this.telefone = dadosUsuario[0].telefone
      this.email = dadosUsuario[0].email
      this.permissaoTelefone = dadosUsuario[0].permissaoTelefone

    }
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    let dadosUsuario = getDadosUsuarioLocal()
    await this.atualizaDadosPreview(dadosUsuario)
    this.buscaMeusCursos(dadosUsuario)

  }
};
</script>

<template>
  <div id="meus-cursos">
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
        <h4>Meus Cursos</h4>
        <a v-b-modal.modal-scrollable-curso-lg>
          <b-button> <ModalCadCurso />CADASTRAR CURSO </b-button>
        </a>
      </div>
      <div class="meus-cursos-body">
        <hr />
        <div class="cards-cursos">
          <CardCursos
            v-for="i in meusCursos" :key="i"
            :pk_curso="i.pk_curso"
            :fk_usuarioCurso="pk_usuario"            
            :cursoNome="i.cursoNome"
            :tipoCurso="i.tipoCurso"
            :usuarioNome="i.usuarioNome"
            :cursoDescricao="i.cursoDescricao"
            :totalFavoritos="i.totalFavoritos"
            :ativarFavorito="false"
            :desativarBotao="true"
            :ativarDelete="true"
            :tipo="2"
            @infoCurso="infoCurso"
            @deletarCurso="deletarCurso" />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#meus-cursos {
  font-family: "Work Sans", sans-serif;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  //background-color: red;
  padding: 0 1rem 1rem 0;

  .lado-user {
    width: 20%;
    //background-color: rebeccapurple;
    
  }
  .lado-meus-cursos {
    width: calc(100vw - 22%);
    padding: 3rem 1rem 0 1rem;
    //background-color: greenyellow;

    .meus-cursos-header {
      display: flex;
      justify-content: space-between;
      padding: .2rem .5rem .2rem .2rem;
      //background-color: green;

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
  #meus-cursos {
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
  #meus-cursos{
    padding: 0 0 1rem 0;

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
  #meus-cursos{
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
  #meus-cursos{
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