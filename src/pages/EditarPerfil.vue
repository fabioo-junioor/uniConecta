<script>
import { getDadosUsuarioLocal, dadosUsuarioPreview } from '../config/global.js'
import Alerta from '../components/Alerta.vue'

export default {
  name: "EditarPerfil",
  components: {Alerta},
  data() {
    return {
      pk_usuario: null,
      nomeUsuario: "",
      graduacao: "",
      imagemPerfil: null,
      totalPontos: 0,
      totalMoedas: 0,
      formEdicao: {
        imagem: null,
        adicionouImagem: false,
        nome: "",
        email: "",
        telefone: null,
        graduacao: null,
        opcoes: [
          {value: 'Sistemas de informação', text: 'Sistemas de informação'},
          {value: 'Medicina', text: 'Medicina'},
          {value: 'Engenharia Eletrica', text: 'Engenharia Eletrica'}
        ],
        senha: "",
      },
      botaoSalvar: false,
      url: null,
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false

      }
    }
  },
  methods: {
    enableBotaoSalvar(){     
      if(/*(this.formEdicao.adicionouImagem == true) &&*/
          (this.formEdicao.nome != "") && 
          (this.formEdicao.email != "") && 
          (this.formEdicao.telefone > 0) &&
          (this.formEdicao.graduacao != null) &&
          (this.formEdicao.senha != "")){
            this.botaoSalvar = true

      }else{
        this.botaoSalvar = false

      }
    },
    selecionarImagem(event){
      var input = event
      if(input.files && input.files[0]){
        var reader = new FileReader()
        reader.onload = e => {
          this.formEdicao.imagem = e.target.result
          this.formEdicao.adicionouImagem = true
          //console.log(this.formEdicao.imagem)
          this.enableBotaoSalvar()

        }
        reader.readAsDataURL(input.files[0])
      }
    },
    salvarEdicao(){
      fetch(this.url+'editarUsuario.php', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: this.pk_usuario,
          nome: this.formEdicao.nome,
          telefone: this.formEdicao.telefone,
          graduacao: this.formEdicao.graduacao,
          img: this.formEdicao.imagem,
          senha: this.formEdicao.senha

        })
      })
      .then((res) => res.json())
      .then((dados) => {
        console.log("salvo")
        dadosUsuarioPreview(dados[0].pk_usuario)
        this.atualizaDadosPreview()

        this.alerta.mensagem = "Edição realizada"
        this.alerta.tipo = "success"
        this.alerta.isAlert = true
        this.resetaAlerta()

      })
    },
    buscarDadosEdicao(){
      let dadosUsuario = getDadosUsuarioLocal()
      fetch(this.url+'buscaDadosUsuario.php?dadosEdicao=1', {
        method: 'POST',
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      .then((res) => res.json())
      .then((dados) => {
        //console.log(dados)
        this.atualizaDadosEdicao(dados)

      })
    },
    atualizaDadosPreview(){
      let dadosUsuario = getDadosUsuarioLocal()
      this.pk_usuario = dadosUsuario[0].pk_usuario
      this.nomeUsuario = dadosUsuario[0].nome
      this.graduacao = dadosUsuario[0].graduacao
      this.totalMoedas = dadosUsuario[0].total_moedas
      this.totalPontos = dadosUsuario[0].total_pontos
      this.imagemPerfil = dadosUsuario[0].img


    },
    atualizaDadosEdicao(dadosUsuario){
      this.formEdicao.imagem = dadosUsuario[0].img
      this.formEdicao.nome = dadosUsuario[0].nome
      this.formEdicao.email = dadosUsuario[0].email
      this.formEdicao.telefone = dadosUsuario[0].telefone
      this.formEdicao.graduacao = dadosUsuario[0].graduacao


    },
    resetaAlerta(){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

      }, 4050)
    }
  },
  async mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    await this.buscarDadosEdicao()
    await this.atualizaDadosPreview()

  }
};
</script>

<template>
  <div id="editar-perfil">
    <Alerta
      v-if="alerta.isAlert"
      :mensagem="alerta.mensagem"
      :tipo="alerta.tipo" />
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
    <div class="lado-edicao">
      <b-form>
        <div>
          <div class="preview-imagem">
            <h5 v-if="!formEdicao.imagem">Visualização</h5>
            <img :src="formEdicao.imagem" />
          </div>
          <div class="imagem-profile">
            <b-form-file
              v-model="formEdicao.imagem"
              plain
              ref="minhaImagem"
              @change="selecionarImagem($event.target)"
              accept="image/*"
              ></b-form-file>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formEdicao.nome"
              type="text"
              placeholder="Informe seu nome:"
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">Informe seu nome:</label>
          </div>
          <div class="form-floating">
            <b-form-input
              disabled
              v-model="formEdicao.email"
              type="email"
              placeholder="Informe seu email:"
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">Informe seu email:</label>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formEdicao.telefone"
              type="tel"
              placeholder="Informe seu telefone:"
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">Informe seu telefone:</label>
          </div>
          <div>
            <b-form-select
              v-model="formEdicao.graduacao"
              :options="formEdicao.opcoes"
              @change="enableBotaoSalvar()">
              <template #first>
                <b-form-select-option
                  :value="null"
                  disabled>Escolher curso</b-form-select-option>
              </template>            
            </b-form-select>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formEdicao.senha"
              type="password"
              placeholder="Informe sua senha:"
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">Informe sua senha:</label>
          </div>
          <div class="botao-salvar">
            <b-button
              @click="salvarEdicao()"
              variant="primary"
              :disabled="!botaoSalvar"
              >Salvar</b-button>
          </div>
        </div>
      </b-form>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#editar-perfil {
  font-family: "Work Sans", sans-serif;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  //background-color: red;

  .lado-user {
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3rem 0 0 0;
    //background-color: brown;

    .foto-user {
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

      img {
        border-radius: 5px;
        max-width: 15.5rem;
        max-height: 15.5rem;
        min-width: auto;
        min-height: auto;

      }
    }
    .dados-user {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      padding: 1rem 0 1rem 1rem;
      background-color: white;
      border: 1px solid #6c63ff;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
      border-radius: 5px;

      h3 {
        padding: 1rem 0 0 0;
        font-size: 1.2rem;
        width: 100%;
      }
      h2 {
        font-size: 0.9rem;
        width: 100%;
      }
      h3::first-letter, h2::first-letter{
        text-transform: uppercase;
        
      }
      div {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        padding: 0.5rem 0;
        font-size: 0.8rem;
        font-weight: bold;
        //background-color: gray;

        img {
          height: 2rem;
          margin: 0.1rem;
          //background-color: red;
        }
      }
    }
  }
  .lado-edicao {
    width: calc(100vw - 30%);
    padding: 3rem 0 0 0;
    display: flex;
    //background-color: red;

    .imagem-profile{
      //background-color: red;
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;

      input{
        width: 100%;
        height: auto;
        margin: 0 0 1rem 0;
        padding: .2rem;
        border: 1px solid #6c63ff;
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
        color: black;
        font-weight: 500;

      }
    }
    .preview-imagem{
      max-width: 21rem !important;
      max-height: auto !important;
      min-width: 15rem !important;
      min-height: 15rem !important;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0 1rem 0;
      padding: .3rem;
      border: 1px solid #6c63ff;
      border-radius: 5px;
      background-color: rgb(240, 240, 240);
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
      color: black;
      font-weight: 500;

      img{
        max-height: 20rem;
        max-width: 20rem;
        border-radius: 5px;

      }
      h5{
        color: rgba(0, 0, 0, 0.6);
        font-weight: 600;
        font-size: 1rem;
      }
    }
    form{
      width: 100% !important;
      padding: 1rem .5rem;
      border-radius: 5px;

      div{
        width: 100% !important;
        display: flex;
        flex-direction: column;
        align-items: center;

      }
      input{
        margin: 0 0 1rem 0;
        border: 1px solid #6c63ff;
        height: 4rem;
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
        color: rgba(0, 0, 0, 0.8);

      }
      label{
        font-family: 'Work Sans', sans-serif;
        font-size: .9rem;
        color: black;
  
      }
      label::after{
        background-color: transparent;

      }
      select{
        width: 100%;
        margin: 0 0 1rem 0;
        border: 1px solid #6c63ff;
        height: 3rem;
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
        color: black;
        padding-left: .5rem;

        option:nth-child(1){
          background-color: #6c63ff;
          color: white;

        }
      }
    }
    div{
      .botao-salvar{
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        padding: 10px;
        width: 100%;

        button{
          font-family: 'Work Sans', sans-serif;
          box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);
          width: 90%;
          height: 4rem;
          border-radius: 5px;
          color: white;
          
        }
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
  #editar-perfil{
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
    .lado-edicao{
      width: 70%;

    }
  }
}
@media only screen and (max-width: 720px) {
  #editar-perfil{
    //background-color: red;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;

    .lado-user{
      //background-color: blue;
      width: 95%;

      .dados-user {
        width: 60%;
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
    .lado-edicao{
      width: 95%;
      //background-color: aquamarine;

    }
  }
}
@media only screen and (max-width: 481px) {
  #editar-perfil{
    .lado-user{
      .dados-user {
        width: 80%;

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
    .lado-edicao{
      width: 95%;

      form{
        padding: 0;

      }
    }
  }
}
@media only screen and (max-width: 360px) {
  #editar-perfil{
    .lado-edicao{
      .preview-imagem{
        max-width: 16rem !important;
        max-height: auto !important;
        min-width: 15rem !important;
        min-height: 15rem !important;

        img{
          max-height: 15rem;
          max-width: 15rem;

        }
      }
    }
  }
}
</style>