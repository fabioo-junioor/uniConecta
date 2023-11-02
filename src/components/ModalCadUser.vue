<script>
import { dadosUsuarioPreview, geradorSenha } from '../config/global.js'
import { encryptSenha, decryptSenha } from '../config/auth.js'
import Alerta from './Alerta.vue'

export default {
  name: "ModalCadUser",
  components: {Alerta},
  data() {
    return {
      form: {
        nome: "",
        email: "",
        telefone: null,
        senha: "",
        permissaoTelefone: null,
        mostrarSenha: false,
        tipoSenha: "password"
      },
      tituloModal: "Login Usuário",
      logar: 1,
      esqueceuSenha: true,
      botaoAcessar: false,
      botaoSalvar: false,
      botaoEnviarEmail: false,
      mensagemRecuperacao: false,
      checkWhatsapp: false,
      url: null

    };
  },
  methods: {
    async authUsuario() {
      const response = await fetch(this.url+'authUsuario.php', {
        method: "POST",
        body: JSON.stringify({
          email: this.form.email

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].email != null){
          let valid = await decryptSenha(this.form.senha, dados[0].senha)
          if(valid){
            this.$emit('mensagemAlerta', 1)
            dadosUsuarioPreview(dados[0].pk_usuario)

          }else{
            this.$emit('mensagemAlerta', 3)

          }
        }else{
          this.$emit('mensagemAlerta', 2)                

        }
      }
    },
    async cadastrarUsuario(){
      let hash = await encryptSenha(this.form.senha)
      const response = await fetch(this.url+'cadastrarUsuario.php', {
        method: 'POST',
        body: JSON.stringify({
          nome: this.form.nome,
          email: this.form.email,
          telefone: this.form.telefone,
          senha: hash,
          permissaoTelefone: this.form.permissaoTelefone
        })
      })
      if(!response.ok){
        console.log(response.ok)

      }else{
        const dados = await response.json()
        if(dados[0].pk_usuario != null){
          this.$emit('mensagemAlerta', 5) 
          
          }else{
          this.$emit('mensagemAlerta', 4) 

        }
      }
    },
    async recuperarSenha(){
      this.mensagemRecuperacao = true
      let novaSenha = await geradorSenha()
      let hash = await encryptSenha(novaSenha)
      const response = await fetch(this.url+'recuperarSenha.php', {
        method: "POST",
        body: JSON.stringify({
          email: this.form.email,
          novaSenha: novaSenha,
          hash: hash

        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].email != null){
          if(dados[0].email){
            this.$emit('mensagemAlerta', 6)

          }else{
            this.$emit('mensagemAlerta', 7)
            
          }
        }else{
          this.$emit('mensagemAlerta', 2)

        }
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
    validarEmail(email){
      var res = /\S+@\S+\.\S+/

      return res.test(email)

    },
    reset() {
      this.form.nome = "";
      this.form.email = "";
      this.form.senha = "";
      this.form.telefone = "";
      this.form.permNumber = null;
    
    },
    enableBotaoAcessar(){
      if((this.validarEmail(this.form.email)) &&
        (this.form.senha.length >= 6)){
        this.botaoAcessar = true

      }else{
        this.botaoAcessar = false

      }
    },
    enableBotaoSalvar(){
      if((this.form.nome != "") &&
        (this.validarEmail(this.form.email)) &&
        (this.form.senha.length >= 6)){
          this.botaoSalvar = true

      }else{
        this.botaoSalvar = false

      }
    },
    enableBotaoEnviarEmail(){
      if(this.validarEmail(this.form.email)){
          this.botaoEnviarEmail = true

      }else{
        this.botaoEnviarEmail = false

      }
    }
  },
  mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    
  },
  watch: {
    'form.mostrarSenha': function(){
      if(this.form.mostrarSenha){
        this.form.tipoSenha = "text"

      }else{
        this.form.tipoSenha = "password"

      }
    }
  }
};
</script>
<template>
  <div id="modal-cadastro-usuario">
    <b-modal
      id="modal-scrollable-user-lg"
      size="lg"
      :title="tituloModal">
      <div id="loginUser">
        <div>
          <img src="../assets/draw/login.svg" />
        </div>
        <b-form>
          <div v-if="logar === 1">
            <div class="form-floating">
              <b-form-input
                v-model="form.email"
                type="email"
                placeholder="*Email: (contato@mail.com) "
                @input="enableBotaoAcessar()"
              ></b-form-input>
              <label for="floatingInput">*Email: (contato@mail.com)</label>
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.senha"
                :type="form.tipoSenha"
                placeholder="*Senha: (Min. 6 caracteres) "
                @input="enableBotaoAcessar()"
                ></b-form-input>
                <label for="floatingInput">*Senha: (Min. 6 caracteres)</label>
            </div>
            <div class="checkMostrarSenha">
              <b-form-checkbox
                v-model="form.mostrarSenha"
                :value="true"
                :unchecked-value="false"      
              ></b-form-checkbox>Mostrar senha
            </div>
            <div class="campos-obrigatorios">
              <p>* Campos obrigatórios </p>
            </div>
            <div class="buttons-login-user">
              <b-button
                @click="authUsuario()"
                variant="primary"
                :disabled="!botaoAcessar" >Acessar</b-button>
              <b-button @click="(logar = 2), tituloModal = 'Cadastre-se', esqueceuSenha = false, reset()" variant="secondary"
                >Cadastre-se</b-button
              >
            </div>
          </div>
          <div v-if="logar === 2">
            <div class="form-floating">
              <b-form-input
                v-model="form.nome"
                type="text"
                placeholder="*Seu nome: "
                @input="enableBotaoSalvar()"
              ></b-form-input>
              <label for="floatingInput">*Seu nome:</label>
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.email"
                type="email"
                placeholder="*Email: (contato@mail.com) "
                @input="enableBotaoSalvar()"
              ></b-form-input>
              <label for="floatingInput">*Email: (contato@mail.com)</label>
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.telefone"
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
                v-model="form.permissaoTelefone"
                value="1"
                unchecked-value="0"      
              ></b-form-checkbox>Permitir contato via whatsapp
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.senha"
                :type="form.tipoSenha"
                placeholder="*Senha: (Min. 6 caracteres) "
                @input="enableBotaoSalvar()"
              ></b-form-input>
              <label for="floatingInput">*Senha: (Min. 6 caracteres)</label>
            </div>
            <div class="checkMostrarSenha">
              <b-form-checkbox
                v-model="form.mostrarSenha"
                :value="true"
                :unchecked-value="false"      
              ></b-form-checkbox>Mostrar senha
            </div>
            <div class="campos-obrigatorios">
              <p>* Campos obrigatórios </p>
            </div>
            <div class="buttons-login-user">
              <b-button
                @click="cadastrarUsuario()"
                variant="primary"
                :disabled="!botaoSalvar"
                >Salvar</b-button
              >
              <b-button @click="(logar = 1), tituloModal = 'Login Usuário', esqueceuSenha = true, reset()" variant="secondary"
                >Fazer login</b-button
              >
            </div>
          </div>
          <div v-if="logar === 3">
            <div class="form-floating">
              <b-form-input
                  v-model="form.email"
                  type="email"
                  placeholder="*Email: (contato@mail.com) "
                  @input="enableBotaoEnviarEmail()"
                ></b-form-input>
                <label for="floatingInput">*Email: (contato@mail.com)</label>
            </div>
            <div v-if="mensagemRecuperacao">
              <span class="mensagem-recuperacao">
                <i class='bx bx-info-circle'></i>
                  Nova senha será enviado por email!
                </span>
            </div>
            <div class="campos-obrigatorios">
              <p>* Campos obrigatórios </p>
            </div>
            <div class="buttons-login-user">
              <b-button
                @click="recuperarSenha()"
                variant="primary"
                :disabled="!botaoEnviarEmail"
                >Enviar email</b-button>
            </div>
            <div class="link-esqueceu-senha-user">
              <b-button
                @click="logar = 1, esqueceuSenha = true, tituloModal = 'Login Usuário'"
                >Voltar</b-button>
            </div>
          </div>
          <div
            v-if="esqueceuSenha"
            class="link-esqueceu-senha-user">
            <b-button
              @click="logar = 3, esqueceuSenha = false, tituloModal = 'Recuperar senha'"
              >Esqueceu sua senha?</b-button>
          </div>
        </b-form>
      </div>
    </b-modal>
  </div>
</template>
<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

.modal-content {
  border-radius: 5px !important;
  border: none !important;
  background-color: transparent !important;
  box-shadow: 1px 1px 10px 2px rgba(0, 0, 0, 0.5);

  .modal-header{
    background-color: #6C63FF;
    border-bottom: 1px solid white;
    height: 3rem !important;
  
    h5 {
      color: white;
      font-size: 1.1rem !important;
      font-family: 'Work Sans', sans-serif;

    }
  }
  .modal-header .close {
    background-color: transparent;
    padding: 0.2rem 0.5rem;
    border: none;
    border-radius: 2px;
    color: white;

  }
  .modal-header .close:hover {
    background-color: rgba(255, 255, 255, 0.2);

  }
  .modal-body {
    padding: 0;
    background-color: #6C63FF !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: center !important;
    width: 100% !important;

    img {
      width: 10rem;
      height: auto;
      margin: 2rem 0 1rem 0;
      filter: drop-shadow(1px 1px 2px black);

    }
  }
  .modal-footer {
    display: none !important;

  }
}
#loginUser {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;

}
#loginUser form {
  width: 100% !important;
  padding: .2rem .5rem .5rem .5rem;
  border-radius: 5px;

}
#loginUser form div {
  width: 100% !important;
  display: flex;
  flex-direction: column;
  align-items: center;

}
#loginUser form input {
  margin: 5px 0px;
  border: none;
  height: 3.5rem;
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
  color: black;
}
#loginUser form input:focus{
  border-bottom: 1px solid black;

}
#loginUser .checkWhatsapp{
  margin: 5px 0px;
  display: flex !important;
  flex-direction: row;
  color: white;
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
#loginUser .checkMostrarSenha{
  margin: 5px 0px;
  display: flex !important;
  flex-direction: row;
  color: white;
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
#loginUser form label{
  font-family: 'Work Sans', sans-serif;
  color: black;
  font-size: .9rem;
  
}
#loginUser form label::after{
  background-color: transparent;

}
#loginUser .campos-obrigatorios{
  display: flex !important;
  flex-direction: row;
  justify-content: flex-end;
  color: white;
  font-size: .9rem;

}
#loginUser div .buttons-login-user {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  padding: 10px;
  width: 100%;
}
#loginUser .buttons-login-user button {
  font-family: 'Work Sans', sans-serif;
  box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
  width: 40%;
  height: 3rem;
  border-radius: 5px;
  color: white;
}
#loginUser .link-esqueceu-senha-user {
  margin: 1rem 0;

}
#loginUser .link-esqueceu-senha-user button {
  font-family: 'Work Sans', sans-serif;
  font-size: 0.9rem;
  padding: 0.8rem 2rem;
  color: rgba(255, 255, 255, 1);
  font-weight: bold;
  background-color: transparent;
  border: none;
  border-radius: 10px;
}
#loginUser .link-esqueceu-senha-user button:hover {
  color: rgba(255, 255, 255, .8);
  font-weight: bold;
}
#loginUser .mensagem-recuperacao{
  font-family: 'Work Sans', sans-serif;
  color: white;
  font-size: .9rem;
  padding: .7rem 0;

  i{
    font-size: 1.1rem;
    padding: .1rem;

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
}
@media only screen and (max-width: 360px) {
}
</style>