<script>
import { getDadosUsuarioLocal } from "../config/global.js"
import CardCursos from "../components/CardCursos.vue";
import ModalCadCurso from "../components/ModalCadCurso.vue";
import LadoUsuario from '../components/LadoUsuario.vue'
import ModalInfoCurso from '../components/ModalInfoCurso.vue'
import Alerta from '../components/Alerta.vue'

export default {
  name: "PerfilUsuario",
  components: { CardCursos, Alerta, LadoUsuario, ModalCadCurso, ModalInfoCurso },
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
      emailUsuarioLogado: "",
      emailUsuarioPerfil: "",
      permissaoTelefone: null,
      mediaStars: 0,
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

      },
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false

      },
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
        this.nomeUsuario = dados[0].nome
        this.emailUsuarioPerfil = dados[0].email
        this.imagemPerfil = dados[0].img
        this.telefone = dados[0].telefone
        this.graduacao = dados[0].graduacao
        this.totalPontos = dados[0].total_pontos
        this.totalMoedas = dados[0].total_moedas
        this.permissaoTelefone = dados[0].permissaoTelefone
        this.mediaStars = parseFloat(dados[0].mediaStars).toFixed(2)

      }
    },
    async adicionarFavorito(pk_curso){
      const response = await fetch(this.url+'adicionaDeletaFavorito.php?adicionaFavorito=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_curso: pk_curso,
          fk_usuario: this.pk_usuarioLogado,
          email: this.emailUsuarioLogado

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        await getDadosUsuarioLocal()
        this.mensagemAlerta(2)
        
      }
    },
    async deletarFavorito(pk_curso){
      const response = await fetch(this.url+'adicionaDeletaFavorito.php?deletaFavorito=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_curso: pk_curso,
          fk_usuario: this.pk_usuarioLogado,
          email: this.emailUsuarioLogado

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        await getDadosUsuarioLocal()
        this.mensagemAlerta(3)
        
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

    },
    async comprarCurso(pk_curso, fk_usuarioCurso){
      const response = await fetch(this.url+'compraCurso.php?compraCurso=1', {
        method: 'POST',
        body: JSON.stringify({
          fk_comprador: this.pk_usuarioLogado,
          fk_vendedor: this.pk_usuarioPerfil,
          fk_curso: pk_curso

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_compra_venda != null){
          await getDadosUsuarioLocal()
          this.mensagemAlerta(1)

        }else{
          this.mensagemAlerta(4)

        }        
      }
    },
    async atualizaDados(){
      let dadosUsuario = await getDadosUsuarioLocal()
      this.pk_usuarioLogado = (dadosUsuario == null) ? null : dadosUsuario[0].pk_usuario
      this.emailUsuarioLogado = (dadosUsuario == null) ? "" : dadosUsuario[0].email
      
    },
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Curso comprado!"
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

        return (id != 4) ? location.reload() : false

      }, 4500)
    }
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    this.atualizaDados()
    this.pk_usuarioPerfil = parseInt(this.$route.params.pk)
    this.buscaCursosUsuario(this.pk_usuarioPerfil)
    this.buscaDadosUsuario(this.pk_usuarioPerfil)

  }
};
</script>

<template>
  <div id="perfil-usuario">
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
    <div class="lado-user-pagina-perfil">
      <LadoUsuario
        :imagemPerfil="imagemPerfil"
        :nomeUsuario="nomeUsuario"
        :graduacao="graduacao"
        :totalMoedas="totalMoedas"
        :totalPontos="totalPontos"
        :telefone="telefone"
        :email="emailUsuarioPerfil"
        :permissaoTelefone="permissaoTelefone"
        :mediaStars="mediaStars" />
    </div>
    <div class="lado-cursos-pagina-perfil">
      <div class="meus-cursos-header">
        <h4>Cursos de: {{nomeUsuario}}</h4>
      </div>
      <div class="meus-cursos-body">
        <hr />
        <div class="cards-cursos-pagina-perfil">
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
            :desativarBotao="((pk_usuarioPerfil == pk_usuarioLogado)||(pk_usuarioLogado == null)/*||(i.cursoComprado == pk_usuarioLogado)*/) ? true : false"
            :ativarDelete="false"
            :tipo="2"
            @infoCurso="infoCurso"
            @adicionarFavorito="adicionarFavorito"
            @deletarFavorito="deletarFavorito"
            @comprarCurso="comprarCurso" />
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
  padding: .5rem .2rem .5rem 1rem;

  .lado-user-pagina-perfil {
    width: 20%;
    //background-color: rebeccapurple;
    
  }
  .lado-cursos-pagina-perfil {
    width: calc(100vw - 22%);
    padding: 2rem 2rem 1rem 1rem;

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
      hr {
        border: 1px solid #6c63ff;
        margin: 0 0 0.5rem 0;
        width: 100%;
        margin-bottom: 1rem;

      }
      .cards-cursos-pagina-perfil {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        
      }
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 992px) {
  #perfil-usuario{  
    .lado-user-pagina-perfil{
      width: 30%;

    }
    .lado-cursos-pagina-perfil{
      width: 69%;
      padding: 2rem 1rem 1rem 1rem;

    }
  }
}
@media only screen and (max-width: 720px) {
  #perfil-usuario{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: .5rem .2rem .5rem .2rem;
    

    .lado-user-pagina-perfil{
      width: 95%;

    }
    .lado-cursos-pagina-perfil{
      width: 95%;
      padding: 2rem 0 0 0;

      h4{
        text-align: center;
        width: 95%;

      }
      .meus-cursos-body{
        .cards-cursos-pagina-perfil{
          justify-content: center;
          
        }
      }
    }
  }
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>