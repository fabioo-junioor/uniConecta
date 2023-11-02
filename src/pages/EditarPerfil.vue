<script>
import { getDadosUsuarioLocal } from "../config/global.js";
import { encryptSenha } from '../config/auth.js'
import Alerta from "../components/Alerta.vue";
import LadoUsuario from "../components/LadoUsuario.vue";

export default {
  name: "EditarPerfil",
  components: { Alerta, LadoUsuario },
  data() {
    return {
      pk_usuario: null,
      nomeUsuario: "",
      graduacao: "",
      telefone: "",
      email: "",
      permissaoTelefone: null,
      mediaStars: 0,
      imagemPerfil: null,
      totalPontos: 0,
      totalMoedas: 0,
      formEdicao: {
        imagem: null,
        adicionouImagem: true,
        nome: "",
        email: "",
        telefone: "",
        permissaoTelefone: null,
        graduacao: null,
        mostrarSenha: false,
        tipoSenha: "password",
        opcoes: [
          { value: "Sistemas de informação", text: "Sistemas de informação" },
          { value: "Ciência da computação", text: "Ciência da computação" },
          { value: "Sistemas para internet", text: "Sistemas para internet" },
          { value: "Engenharia da computação", text: "Engenharia da computação" }
        ],
        senha: "",
      },
      botaoSalvar: false,
      checkWhatsapp: true,
      url: null,
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false,
      },
    };
  },
  methods: {
    enableBotaoSalvar() {
      if (this.formEdicao.nome != "" &&
        this.formEdicao.email != "" &&
        this.formEdicao.graduacao != null &&
        this.formEdicao.senha.length >= 6 &&
        this.formEdicao.adicionouImagem == true) {
        this.botaoSalvar = true;

      } else {
        this.botaoSalvar = false;

      }
    },
    selecionarImagem(event) {
      var input = event;
      this.validarTamanhoImagem(input)
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.formEdicao.imagem = e.target.result;
          this.enableBotaoSalvar()

        };
        reader.readAsDataURL(input.files[0])

      }

    },
    async validarTamanhoImagem(e){
      const tamanho = await e.files[0].size /1024/1024
      if(tamanho > 3){
        this.formEdicao.adicionouImagem = false
        this.alerta.mensagem = "Imagem muito grande!";
        this.alerta.tipo = "warning";
        this.alerta.isAlert = true;
        this.resetaAlerta();

      }else{
        this.formEdicao.adicionouImagem = true

      }
    },
    async salvarEdicao() {
      let hash = await encryptSenha(this.formEdicao.senha)
      const response = await fetch(this.url + "editarUsuario.php", {
        method: "POST",
        body: JSON.stringify({
          pk_usuario: this.pk_usuario,
          nome: this.formEdicao.nome,
          telefone: this.formEdicao.telefone,
          graduacao: this.formEdicao.graduacao,
          img: this.formEdicao.imagem,
          senha: hash,
          permissaoTelefone: this.formEdicao.permissaoTelefone
        }),
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_usuario != null){
          await this.atualizaDadosPreview()
          this.mensagemAlerta(1)

        }
      }
    },
    async buscarDadosEdicao() {
      let dadosUsuario = await getDadosUsuarioLocal();
      const response = await fetch(this.url + "buscaDadosUsuario.php?dadosEdicao=1", {
        method: "POST",
        body: JSON.stringify({
          pk_usuario: dadosUsuario[0].pk_usuario
          
        }),
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        await this.atualizaDadosEdicao(dados);

      }
    },
    handlePhone(event){
      event.value = this.maskPhone(event.value)
      if(event.value != ""){
        this.checkWhatsapp = true

      }else{
        this.checkWhatsapp = false

      }
    },
    maskPhone(value){
      if(!value){
        return ""
        
      }else{
        value = value.replace(/\D/g,'')
        value = value.replace(/(\d{2})(\d)/,"($1) $2")
        value = value.replace(/(\d)(\d{4})$/,"$1-$2")
        return value
        
      }
    },
    async atualizaDadosPreview() {
      let dadosUsuario = await getDadosUsuarioLocal();
      this.pk_usuario = dadosUsuario[0].pk_usuario
      this.nomeUsuario = dadosUsuario[0].nome
      this.graduacao = dadosUsuario[0].graduacao
      this.totalMoedas = dadosUsuario[0].total_moedas
      this.totalPontos = dadosUsuario[0].total_pontos
      this.imagemPerfil = dadosUsuario[0].img
      this.telefone = dadosUsuario[0].telefone
      this.email = dadosUsuario[0].email
      this.permissaoTelefone = dadosUsuario[0].permissaoTelefone
      this.mediaStars = parseFloat(dadosUsuario[0].mediaStars).toFixed(2)
      

    },
    async atualizaDadosEdicao(dadosUsuario) {
      this.formEdicao.imagem = dadosUsuario[0].img
      this.formEdicao.nome = dadosUsuario[0].nome
      this.formEdicao.email = dadosUsuario[0].email
      this.formEdicao.telefone = dadosUsuario[0].telefone
      this.formEdicao.graduacao = dadosUsuario[0].graduacao
      this.formEdicao.permissaoTelefone = dadosUsuario[0].permissaoTelefone

      this.checkWhatsapp = ((dadosUsuario[0].telefone.length === 0)||(dadosUsuario[0].telefone === null)) ? false : true
      
    },
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Edição realizada!";
        this.alerta.tipo = "success";
        this.alerta.isAlert = true;

      }
      this.resetaAlerta(id)

    },
    resetaAlerta(id){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

        return (id == 1) ? location.reload() : false

      }, 4500)
    }
  },
  async mounted() {
    this.url = import.meta.env.VITE_ROOT_API;
    await this.atualizaDadosPreview();
    await this.buscarDadosEdicao();

  },
  watch: {
    'formEdicao.mostrarSenha': function(){
      if(this.formEdicao.mostrarSenha){
        this.formEdicao.tipoSenha = "text"

      }else{
        this.formEdicao.tipoSenha = "password"

      }
    }
  }
};
</script>

<template>
  <div id="editar-perfil">
    <Alerta
      v-if="alerta.isAlert"
      :mensagem="alerta.mensagem"
      :tipo="alerta.tipo"
    />
    <div class="lado-user-pagina-edital-perfil">
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
              placeholder="*Seu nome:"
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">*Seu nome:</label>
          </div>
          <div class="form-floating">
            <b-form-input
              disabled
              v-model="formEdicao.email"
              type="email"
              placeholder="*Email: (contato@mail.com) "
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">*Email: (contato@mail.com)</label>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formEdicao.telefone"
              type="tel"
              placeholder="Telefone: (55 99999 9999) "
              maxlength="15"
              @keyup="handlePhone($event.target)"
            ></b-form-input>
            <label for="floatingInput">Telefone: (55 99999 9999)</label>
          </div>
          <div
            v-if="checkWhatsapp"
            class="checkWhatsapp">
            <b-form-checkbox
              v-model="formEdicao.permissaoTelefone"
              value="1"
              unchecked-value="0"      
            ></b-form-checkbox>Permitir contato via whatsapp
          </div>
          <div>
            <b-form-select
              v-model="formEdicao.graduacao"
              :options="formEdicao.opcoes"
              @change="enableBotaoSalvar()"
            >
              <template #first>
                <b-form-select-option :value="null" disabled
                  >Escolher curso</b-form-select-option
                >
              </template>
            </b-form-select>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formEdicao.senha"
              :type="formEdicao.tipoSenha"
              placeholder="*Senha: (Min. 6 caracteres) "
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">*Senha: (Min. 6 caracteres)</label>
          </div>
          <div class="checkMostrarSenha">
            <b-form-checkbox
              v-model="formEdicao.mostrarSenha"
              :value="true"
              :unchecked-value="false"      
            ></b-form-checkbox>Mostrar senha
          </div>
          <div class="campos-obrigatorios">
            <p>* Campos obrigatórios </p>
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
  padding: .5rem .2rem .5rem 1rem;

  .lado-user-pagina-edital-perfil {
    width: 20%;
    //background-color: brown;
  }
  .lado-edicao {
    width: calc(100vw - 22%);
    padding: 2rem 2rem 1rem 1rem;
    display: flex;

    .imagem-profile {
      //background-color: red;
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;

      input {
        width: 100%;
        height: auto;
        margin: 0 0 1rem 0;
        padding: .3rem;
        border: none;
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 1px 1px #6C63FF;
        color: black;
        font-weight: 500;
      }
    }
    .preview-imagem {
      max-width: 21rem !important;
      max-height: auto !important;
      min-width: 15rem !important;
      min-height: 15rem !important;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0 1rem 0;
      padding: 0.3rem;
      border: none;
      border-radius: 5px;
      background-color: rgb(240, 240, 240);
      box-shadow: 1px 1px 1px 1px #6C63FF;
      color: black;
      font-weight: 500;

      img {
        max-height: 20rem;
        max-width: 20rem;
        border-radius: 5px;
      }
      h5 {
        color: rgba(0, 0, 0, 0.6);
        font-weight: 600;
        font-size: 1rem;
      }
    }
    form {
      width: 100% !important;
      padding: 1rem 0.5rem;
      border-radius: 5px;

      div {
        width: 100% !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        
      }
      input {
        margin: 0 0 1rem 0;
        border: none;
        height: 4rem;
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 1px 1px #6C63FF;
        color: rgba(0, 0, 0, 0.8);
      }
      input:disabled{
        background-color: rgba(0, 0, 0, 0.05);

      }
      input:focus{
        border-bottom: 1px solid #6C63FF;

      }
      label {
        font-family: "Work Sans", sans-serif;
        font-size: .9rem;
        color: black;
      }
      label::after {
        background-color: transparent;
      }
      select {
        width: 100%;
        margin: 0 0 1rem 0;
        border: none;
        height: 3rem;
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 1px 1px #6C63FF;
        color: black;
        padding-left: 0.5rem;

        option:nth-child(1) {
          background-color: #6c63ff;
          color: white;
        }
      }
      select:focus{
        border-bottom: 1px solid #6C63FF;

      }
      .checkWhatsapp{
        margin: 0 0 1rem 0;
        display: flex !important;
        flex-direction: row;
        height: 2.5rem;
        color: black;
        font-weight: 500;
        font-size: .9rem;

        .custom-control{
          width: 1.5rem !important;

          input{
            height: 100% !important;
            box-shadow: none;

          }
        }
      }
      .checkMostrarSenha{
        margin: 0 0 .2rem 0;
        display: flex !important;
        flex-direction: row;
        height: 1.5rem;
        color: black;
        font-weight: 500;
        font-size: .9rem;

        .custom-control{
          width: 1.5rem !important;

          input{
            height: 100% !important;
            box-shadow: none;

          }
        }
      }
      .campos-obrigatorios{
        display: flex !important;
        flex-direction: row;
        justify-content: flex-end;
        color: black;
        font-size: .9rem;

      }
    }
    div {
      .botao-salvar {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        padding: 10px;
        width: 100%;

        button {
          font-family: "Work Sans", sans-serif;
          box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
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
  #editar-perfil {
    .lado-user-pagina-edital-perfil{
      width: 30%;

    }
    .lado-edicao {
      width: 69%;
      padding: 2rem 1rem 1rem 1rem;
      
    }
  }
}
@media only screen and (max-width: 720px) {
  #editar-perfil {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: .5rem .2rem .5rem .2rem;

    .lado-user-pagina-edital-perfil {
      width: 95%;
    }
    .lado-edicao {
      width: 95%;
      padding: 2rem .2rem 1rem .2rem;
      
    }
  }
}
@media only screen and (max-width: 481px) {
  #editar-perfil {
    .lado-edicao {
      padding: 2rem .1rem 1rem .1rem;

      form {
        padding: 0;
      }
    }
  }
}
@media only screen and (max-width: 360px) {
  #editar-perfil {
    .lado-edicao {
      .preview-imagem {
        max-width: 16rem !important;
        max-height: auto !important;
        min-width: 15rem !important;
        min-height: 15rem !important;

        img {
          max-height: 15rem;
          max-width: 15rem;
        }
      }
    }
  }
}
</style>