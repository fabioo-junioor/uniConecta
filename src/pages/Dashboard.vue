<script>
import { getDadosUsuarioLocal } from "../config/global.js"
import CardCursos from '../components/CardCursos.vue'
import LadoUsuario from '../components/LadoUsuario.vue'
import ModalInfoCurso from '../components/ModalInfoCurso.vue'
import ModalAvaliarCurso from '../components/ModalAvaliarCurso.vue'
import Alerta from '../components/Alerta.vue'

export default {
  name: "Dashboard",
  components: {CardCursos, Alerta, LadoUsuario, ModalInfoCurso, ModalAvaliarCurso},
  data() {
    return {
      pk_usuario: null,
      nomeUsusario: "",
      graduacao: "",
      totalPontos: null,
      totalMoedas: null,
      imagemPerfil: null,
      email: "",
      telefone: "",
      permissaoTelefone: null,
      mediaStars: 0,
      url: null,
      cursosVendidos: null,
      cursosComprados: null,
      cursosAvaliados: null,
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

      },
      dadosAvaliacao: {
        pk_compra_venda: null,
        pk_comprador: null,
        cursoNome: ""

      },
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false,
      }     
    }
  },
  methods: {
    async buscaCursosVendidos(){
      let dadosUsuario = await getDadosUsuarioLocal()
      const response = await fetch(this.url+'buscaCursos.php?buscaCursosVendidos=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log("vendido-> ", dados)
        if(dados[0].pk_curso != null){
          this.cursosVendidos = dados

        }else{
          this.cursosVendidos = null

        }
      }
    },
    async buscaCursosComprados(){
      let dadosUsuario = await getDadosUsuarioLocal()
      const response = await fetch(this.url+'buscaCursos.php?buscaCursosComprados=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log("comprado-> ", dados)
        if(dados[0].pk_curso != null){
          this.cursosComprados = dados

        }else{
          this.cursosComprados = null

        }
      }
    },
    async buscaCursosAvaliados(){
      let dadosUsuario = await getDadosUsuarioLocal()
      const response = await fetch(this.url+'buscaCursos.php?buscaCursosAvaliados=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log("avaliado-> ", dados)
        if(dados[0].pk_curso != null){
          this.cursosAvaliados = dados

        }else{
          this.cursosAvaliados = null

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
    async avaliarCurso(pk_compra_venda, fk_comprador, cursoNome){
      this.dadosAvaliacao.pk_compra_venda = pk_compra_venda
      this.dadosAvaliacao.pk_comprador = fk_comprador
      this.dadosAvaliacao.cursoNome = cursoNome

      this.$root.$emit('bv::show::modal', 'modalAvaliarCurso')    

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
        await this.atualizaDadosPreview()
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
        await this.atualizaDadosPreview()
        this.mensagemAlerta(3)
        
      }
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
          this.mensagemAlerta(5)

        }else{
          await this.atualizaDadosPreview()
          this.mensagemAlerta(4)

        }        
      }
    },
    async atualizaDadosPreview(){
      let dadosUsuario = await getDadosUsuarioLocal()
      this.pk_usuario = dadosUsuario[0].pk_usuario
      this.nomeUsuario = dadosUsuario[0].nome
      this.graduacao = dadosUsuario[0].graduacao
      this.totalMoedas = dadosUsuario[0].total_moedas
      this.totalPontos = dadosUsuario[0].total_pontos
      this.imagemPerfil = dadosUsuario[0].img
      this.email = dadosUsuario[0].email
      this.telefone = dadosUsuario[0].telefone
      this.permissaoTelefone = dadosUsuario[0].permissaoTelefone
      this.mediaStars = parseFloat(dadosUsuario[0].mediaStars).toFixed(2)

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
        this.alerta.mensagem = "Curso apagado!"
        this.alerta.tipo = "info"
        this.alerta.isAlert = true

      }else if(id == 5){
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

        return (id != 5) ? location.reload() : false

      }, 4500)
    }
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    await this.atualizaDadosPreview()
    await this.buscaCursosVendidos()
    await this.buscaCursosComprados()
    await this.buscaCursosAvaliados()

  }
}
</script>

<template>
  <div id="dashboard">
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
    <ModalAvaliarCurso
      :pk_compra_venda="dadosAvaliacao.pk_compra_venda"
      :pk_comprador="dadosAvaliacao.pk_comprador"
      :cursoNome="dadosAvaliacao.cursoNome" />
    <div class="lado-user-pagina-dashboard">
      <LadoUsuario
        :imagemPerfil="imagemPerfil"
        :nomeUsuario="nomeUsuario"
        :graduacao="graduacao"
        :totalMoedas="totalMoedas"
        :totalPontos="totalPontos"
        :telefone="telefone"
        :email="email"
        :permissaoTelefone="permissaoTelefone"
        :mediaStars="mediaStars" />
    </div>
    <div class="lado-cursos-pagina-dashboard">
      <div
        class="cursos-vendidos"
        v-if="cursosVendidos != null">
        <h4>Vendidos</h4>
        <hr>
        <div class="cards-cursos-pagina-dashboard">
          <CardCursos 
            v-for="i in cursosVendidos" :key="i"
            :pk_curso="i.pk_curso"
            :fk_usuarioCurso="i.fk_usuarioCurso"
            :fk_comprador="i.fk_comprador"
            :pk_compra_venda="i.pk_compra_venda"
            :cursoNome="i.cursoNome"
            :tipoCurso="i.tipoCurso"
            :usuarioNome="i.usuarioNome"
            :compradorNome="i.compradorNome"
            :cursoDescricao="i.cursoDescricao"
            :totalFavoritos="i.totalFavoritos"
            :tipo="1"
            :desativarBotao="false"
            :ativarFavorito="false"
            :ativarDelete="true"
            @infoCurso="infoCurso"
            @deletarCurso="deletarCurso"
            @avaliarCurso="avaliarCurso" />
        </div>
      </div>
      <div
        class="cursos-comprados"
        v-if="cursosComprados != null">
        <h4>Comprados</h4>
        <hr>
        <div class="cards-cursos-pagina-dashboard">
          <CardCursos 
            v-for="i in cursosComprados" :key="i"
            :pk_curso="i.pk_curso"
            :fk_usuarioCurso="i.fk_usuarioCurso"
            :fk_comprador="i.fk_comprador"
            :pk_compra_venda="i.pk_compra_venda"
            :cursoNome="i.cursoNome"
            :tipoCurso="i.tipoCurso"
            :usuarioNome="i.usuarioNome"
            :cursoDescricao="i.cursoDescricao"
            :totalFavoritos="i.totalFavoritos"
            :favoritou="i.favoritou != pk_usuario ? true : false"
            :tipo="1"
            :desativarBotao="false"
            :ativarFavorito="true"
            :ativarDelete="false"
            @infoCurso="infoCurso"
            @adicionarFavorito="adicionarFavorito"
            @deletarFavorito="deletarFavorito"
            @avaliarCurso="avaliarCurso" />
        </div>
      </div>
      <div
        class="cursos-avaliados"
        v-if="cursosAvaliados != null">
        <h4>Avaliados</h4>
        <hr>
        <div class="cards-cursos-pagina-dashboard">
          <CardCursos 
            v-for="i in cursosAvaliados" :key="i"
            :pk_curso="i.pk_curso"
            :fk_usuarioCurso="i.fk_usuarioCurso"
            :fk_comprador="i.fk_comprador"
            :cursoNome="i.cursoNome"
            :tipoCurso="i.tipoCurso"
            :usuarioNome="i.usuarioNome"
            :compradorNome="i.fk_comprador != pk_usuario ? i.compradorNome : null"
            :cursoDescricao="i.cursoDescricao"
            :totalFavoritos="i.totalFavoritos"
            :favoritou="i.favoritou != pk_usuario ? true : false"
            :tipo="3"
            :desativarBotao="true"
            :ativarFavorito="i.fk_usuarioCurso != pk_usuario ? true : false"
            :ativarDelete="i.fk_usuarioCurso === pk_usuario ? true : false"
            @infoCurso="infoCurso"
            @adicionarFavorito="adicionarFavorito"
            @deletarFavorito="deletarFavorito"
            @deletarCurso="deletarCurso" />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#dashboard {
  font-family: 'Work Sans', sans-serif;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  padding: .5rem .2rem .5rem 1rem;
  
  .lado-user-pagina-dashboard{
    width: 20%;
        
  }
  .lado-cursos-pagina-dashboard{
    width: calc(100vw - 22%);
    padding: 2rem 2rem 1rem 1rem;
    //background-color: red;

    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
      margin-bottom: 2.5rem;

      h4{
        font-size: 1.3rem;
        margin: 0;
        padding: 5px 0 2px 0;
        //background-color: blue;

      }
      hr{
        border: 1px solid #6C63FF;
        margin: 0 0 .5rem 0;
        width: 100%;
        
      }
      .cards-cursos-pagina-dashboard{
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
  #dashboard{  
    .lado-user-pagina-dashboard{
      width: 30%;

    }
    .lado-cursos-pagina-dashboard{
      width: 69%;
      padding: 2rem 1rem 1rem 1rem;
      
    }
  }
}
@media only screen and (max-width: 720px) {
#dashboard{
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-bottom: 1rem;
  padding: .5rem .2rem .5rem .2rem;

  .lado-user-pagina-dashboard{
    width: 95%;
    padding: .5rem 0;

  }
  .lado-cursos-pagina-dashboard{
    width: 95%;
    padding: 2rem 0 0 0;

    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
      h4{
        text-align: center;

      }
      .cards-cursos-pagina-dashboard{
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