<script>
import { getDadosUsuarioLocal } from '../config/global.js'
import CardCursos from '../components/CardCursos.vue'

export default {
  name: "Dashboard",
  components: {CardCursos},
  data() {
    return {
      pk_usuario: null,
      nomeUsusario: "",
      graduacao: "",
      totalPontos: null,
      totalMoedas: null,
      imagemPerfil: null,
      url: null,
      cursosVendidos: null,
      cursosComprados: null,
      cursosAvaliados: null
      
    }
  },
  methods: {
    buscaCursosVendidos(dadosUsuario){
      fetch(this.url+'buscaCursos.php?buscaCursosVendidos=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      .then((res) => res.json())
      .then((dados) => {
        if(dados[0].pk_usuario != null){
          this.cursosVendidos = dados

        }else{
          this.cursosVendidos = null

        }
          //console.log(dados)

      })
    },
    buscaCursosComprados(dadosUsuario){
      fetch(this.url+'buscaCursos.php?buscaCursosComprados=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      .then((res) => res.json())
      .then((dados) => {
        if(dados[0].pk_usuario != null){
          this.cursosComprados = dados

        }else{
          this.cursosComprados = null

        }
          //console.log(dados)

      })
    },
    buscaCursosAvaliados(dadosUsuario){
      fetch(this.url+'buscaCursos.php?buscaCursosAvaliados=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      .then((res) => res.json())
      .then((dados) => {
        if(dados[0].pk_usuario != null){
          this.cursosAvaliados = dados

        }else{
          this.cursosAvaliados = null

        }
          //console.log(dados)

      })
    },
    infoCurso(){
      console.log("info curso ")
      

    },
    atualizaDadosPreview(dadosUsuario){
      this.pk_usuario = dadosUsuario[0].pk_usuario
      this.nomeUsuario = dadosUsuario[0].nome
      this.graduacao = dadosUsuario[0].graduacao
      this.totalMoedas = dadosUsuario[0].total_moedas
      this.totalPontos = dadosUsuario[0].total_pontos
      this.imagemPerfil = dadosUsuario[0].img


    }
  },
  mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    let dadosUsuario = getDadosUsuarioLocal()
    this.atualizaDadosPreview(dadosUsuario)
    this.buscaCursosVendidos(dadosUsuario)
    this.buscaCursosComprados(dadosUsuario)
    this.buscaCursosAvaliados(dadosUsuario)

  }
}
</script>

<template>
  <div id="dashboard">
    <div class="lado-user">
      <div class="foto-user">
        <img
          v-if="!imagemPerfil"
          src="../assets/img/person1.png" />
        <img
          v-else
          :src="imagemPerfil" />
      </div>
      <div class="dados-user">
        <h3>{{ nomeUsuario }}</h3>
        <h2>{{ graduacao }}</h2>
        <div>
          <img src="../assets/gifs/coin.gif" />
          {{ totalMoedas }}
        </div>
        <div>
          <img src="../assets/img/trophy.png" />
          {{ totalPontos }}
        </div>
      </div>
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
            :cursoNome="i.cursoNome"
            :usuarioNome="i.usuarioNome"
            :cursoDescricao="i.cursoDescricao"
            :tipo="true"
            @infoCurso="infoCurso" />
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
            :cursoNome="i.cursoNome"
            :usuarioNome="i.usuarioNome"
            :cursoDescricao="i.cursoDescricao"
            :tipo="true" />
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
            :cursoNome="i.cursoNome"
            :usuarioNome="i.usuarioNome"
            :cursoDescricao="i.cursoDescricao"
            :isValid="true"
            :tipo="true" />
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
  //background-color: red;
  
  .lado-user{
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3rem 0 0 0;
    //background-color: brown;

    .foto-user{
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0 1rem 0;
      border: 1px solid #6c63ff;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      padding: .3rem;

      max-width: 16rem !important;
      max-height: 16rem !important;
      min-width: 15rem !important;
      min-height: 15rem !important;

      img{
        border-radius: 5px;
        max-width: 15.5rem;
        max-height: 15.5rem;
        min-width: auto;
        min-height: auto;

      }
    }
    .dados-user{
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      padding: 1rem 0 1rem 1rem;
      background-color: white;
      border: 1px solid #6C63FF;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
      border-radius: 5px;

      h3{
        padding: 1rem 0 0 0;
        font-size: 1.2rem;
        width: 100%;

      }
      h2{
        font-size: .9rem;
        width: 100%;

      }
      h3::first-letter, h2::first-letter{
        text-transform: uppercase;
        
      }
      div{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        padding: .5rem 0;
        font-size: .8rem;
        font-weight: bold;
        //background-color: gray;
       
        img{
          height: 2rem;
          margin: .1rem;
          //background-color: red;
          
        }
      }
    }    
  }
  .lado-cursos{
    width: calc(100vw - 30%);
    padding: 3rem 0 0 0;
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
  .lado-user{
    .dados-user {
      width: 90%;

      div {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;

      }
    }
  }
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

    .foto-user{
        max-width: 13rem !important;
        max-height: 13rem !important;
        min-width: 12rem !important;
        min-height: 12rem !important;

      img{
        max-height: 12.5rem;
        max-width: 12.5rem;

      }
    }
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

  .lado-user{
    width: 95%;

    .dados-user {
      width: 60%;
      display: flex;
      flex-direction: column;
      justify-content: center;

      h3 {
        text-align: center;

      }
      h2 {
        text-align: center;

      }
      div {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;

      }
    }
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
  .lado-user{
    .dados-user {
      width: 80%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 0;

      h3 {
        text-align: center;

      }
      h2 {
        text-align: center;

      }
      div {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;

      }
    }
  }
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
#dashboard{
  .lado-user{
    .dados-user {
      width: 90%;
      
    }
  }
}
}
</style>