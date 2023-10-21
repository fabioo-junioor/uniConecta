<script>
import { getDadosUsuarioLocal } from '../config/global.js'
import CardCursos from '../components/CardCursos.vue'
import LadoUsuario from '../components/LadoUsuario.vue'
import ModalInfoCurso from '../components/ModalInfoCurso.vue'

export default {
  name: "Dashboard",
  components: {CardCursos, LadoUsuario, ModalInfoCurso},
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

      }      
    }
  },
  methods: {
    async buscaCursosVendidos(dadosUsuario){
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
        //console.log(dados)
        if(dados[0].pk_curso != null){
          this.cursosVendidos = dados

        }else{
          this.cursosVendidos = null

        }
      }
    },
    async buscaCursosComprados(dadosUsuario){
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
        //console.log(dados)
        if(dados[0].pk_curso != null){
          this.cursosComprados = dados

        }else{
          this.cursosComprados = null

        }
      }
    },
    async buscaCursosAvaliados(dadosUsuario){
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
        //console.log(dados)
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
    async infoCurso(pk_curso){
      await this.buscaInfoCurso(pk_curso)
      this.$root.$emit('bv::show::modal', 'modalInfoCurso')    
      //console.log("info curso ", pk_curso)

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
    async deletarCurso(pk_curso){
      console.log(pk_curso)

    },
    async atualizaDadosPreview(dadosUsuario){
      this.pk_usuario = dadosUsuario[0].pk_usuario
      this.nomeUsuario = dadosUsuario[0].nome
      this.graduacao = dadosUsuario[0].graduacao
      this.totalMoedas = dadosUsuario[0].total_moedas
      this.totalPontos = dadosUsuario[0].total_pontos
      this.imagemPerfil = dadosUsuario[0].img
      this.email = dadosUsuario[0].email
      this.telefone = dadosUsuario[0].telefone
      this.permissaoTelefone = dadosUsuario[0].permissaoTelefone

    }
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    let dadosUsuario = getDadosUsuarioLocal()
    await this.atualizaDadosPreview(dadosUsuario)
    await this.buscaCursosVendidos(dadosUsuario)
    await this.buscaCursosComprados(dadosUsuario)
    await this.buscaCursosAvaliados(dadosUsuario)

  }
}
</script>

<template>
  <div id="dashboard">
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
    <div class="lado-cursos">
      <div
        class="cursos-vendidos"
        v-if="cursosVendidos != null">
        <h4>Vendidos</h4>
        <hr>
        <div class="cards-cursos">
          <CardCursos 
            v-for="i in cursosVendidos" :key="i"
            :pk_curso="i.pk_curso"
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
            @deletarCurso="deletarCurso" />
        </div>
      </div>
      <div
        class="cursos-comprados"
        v-if="cursosComprados != null">
        <h4>Comprados</h4>
        <hr>
        <div class="cards-cursos">
          <CardCursos 
            v-for="i in cursosComprados" :key="i"
            :pk_curso="i.pk_curso"
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
            @deletarFavorito="deletarFavorito" />
        </div>
      </div>
      <div
        class="cursos-avaliados"
        v-if="cursosAvaliados != null">
        <h4>Avaliados</h4>
        <hr>
        <div class="cards-cursos">
          <CardCursos 
            v-for="i in cursosAvaliados" :key="i"
            :pk_curso="i.pk_curso"
            :cursoNome="i.cursoNome"
            :tipoCurso="i.tipoCurso"
            :usuarioNome="i.usuarioNome"
            :compradorNome="i.compradorNome"
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
  padding-bottom: 1rem;
  //background-color: red;
  
  .lado-user{
    width: 20%;
        
  }
  .lado-cursos{
    width: calc(100vw - 22%);
    padding: 3rem 1rem 0 1rem;
    //background-color: red;

    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
      //background-color: blue;
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
      .cards-cursos{
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: .5rem;
        align-items: stretch;
        
      }
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
#dashboard{
  .lado-cursos{
    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
      .cards-cursos{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: .3rem;
        
      }
    }
  }
}
}
@media only screen and (max-width: 992px) {
#dashboard{  
  .lado-user{
    width: 25%;

  }
  .lado-cursos{
    width: 70%;
    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
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
#dashboard{
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-bottom: 1rem;

  .lado-user{
    width: 95%;

  }
  .lado-cursos{
    width: 95%;
    padding: 3rem 0 0 0;

    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
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
#dashboard{
  .lado-cursos{
    .cursos-comprados,
    .cursos-vendidos,
    .cursos-avaliados{
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