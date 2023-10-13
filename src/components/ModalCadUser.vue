<script>
import { dadosUsuarioPreview } from '../config/global.js'
import Alerta from './Alerta.vue'

export default {
  name: "ModalCadUser",
  components: {Alerta},
  data() {
    return {
      form: {
        nome: "",
        email: "",
        telefone: "",
        senha: "",
        permNumber: null,
      },
      logar: true,
      botaoAcessar: false,
      botaoSalvar: false,
      url: null

    };
  },
  methods: {
    async authUsuario() {
      const response = await fetch(this.url+'authUsuario.php', {
        method: "POST",
        body: JSON.stringify({
          email: this.form.email,
          senha: this.form.senha
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_usuario != null){
          dadosUsuarioPreview(dados[0].pk_usuario)
          this.$emit('mensagemAlerta', 1)

        }else{
          console.log("Senha incorreta!")
          this.$emit('mensagemAlerta', 2)                  

        }
      }
    },
    async cadastrarUsuario(){
      /*
      const response = await fetch(this.url+'cadastrarUsuario.php', {
        method: 'POST',
        body: JSON.stringify({
          nome: this.form.nome,
          email: this.form.email,
          telefone: this.form.telefone,
          senha: this.form.senha
        })
      })
      if(!response.ok){
        console.log(response.ok)

      }else{
        const dados = await response.json()
        if(dados[0].pk_usuario != null){
          this.$emit('mensagemAlerta', 3) 
          
          }else{
          this.$emit('mensagemAlerta', 4) 

        }
      }*/
      console.log(this.form.permNumber)

    },
    handlePhone(event){
      event.value = this.maskPhone(event.value)

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
    reset() {
      this.form.nome = "";
      this.form.email = "";
      this.form.senha = "";
      this.form.telefone = "";
      this.form.permNumber = null;
      console.log("Resetou");
    
    },
    enableBotaoAcessar(){
      if((this.form.email != "") &&
        (this.form.senha != "")){
        this.botaoAcessar = true

      }else{
        this.botaoAcessar = false

      }
    },
    enableBotaoSalvar(){
      console.log(this.form.telefone)
      if((this.form.nome != "") &&
        (this.form.email != "") &&
        (this.form.telefone != "") &&
        (this.form.senha != "")){
          this.botaoSalvar = true

      }else{
        this.botaoSalvar = false

      }
    }
  },
  mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    
  }
};
</script>
<template>
  <div id="modal-cadastro-usuario">
    <b-modal
      id="modal-scrollable-user-lg"
      size="lg"
      scrollable
      title="Login Usuário">
      <div id="loginUser">
        <b-form>
          <div>
            <img src="../assets/draw/login.svg" />
          </div>
          <div v-if="logar">
            <div class="form-floating">
              <b-form-input
                v-model="form.email"
                type="email"
                placeholder="Informe seu email: "
                @input="enableBotaoAcessar()"
              ></b-form-input>
              <label for="floatingInput">Informe seu email:</label>
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.senha"
                type="password"
                placeholder="Informe sua senha: "
                @input="enableBotaoAcessar()"
              ></b-form-input>
              <label for="floatingInput">Informe sua senha:</label>
            </div>
            <div class="buttons-login-user">
              <b-button
                @click="authUsuario()"
                variant="primary"
                :disabled="!botaoAcessar" >Acessar</b-button>
              <b-button @click="(logar = !logar), reset()" variant="secondary"
                >Cadastre-se</b-button
              >
            </div>
          </div>
          <div v-else>
            <div class="form-floating">
              <b-form-input
                v-model="form.nome"
                type="text"
                placeholder="Informe seu nome: "
                @input="enableBotaoSalvar()"
              ></b-form-input>
              <label for="floatingInput">Informe seu nome:</label>
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.email"
                type="email"
                placeholder="Informe seu email: "
                @input="enableBotaoSalvar()"
              ></b-form-input>
              <label for="floatingInput">Informe seu email:</label>
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.telefone"
                type="tel"
                placeholder="Informe seu telefone: "
                maxlength="15"
                @input="enableBotaoSalvar()"
                @keyup="handlePhone($event.target)"
              ></b-form-input>
              <label for="floatingInput">Informe seu telefone:</label>
            </div>
            <div class="form-floating">
              <b-form-input
                v-model="form.senha"
                type="password"
                placeholder="Informe sua senha: "
                @input="enableBotaoSalvar()"
              ></b-form-input>
              <label for="floatingInput">Informe sua senha:</label>
            </div>
            <div class="checkWhatsapp">
              <b-form-checkbox
                v-model="form.permNumber"
                value="1"
                unchecked-value="0"      
              ></b-form-checkbox>Permitir contato pelo whatsapp
            </div>
            <div class="buttons-login-user">
              <b-button
                @click="cadastrarUsuario()"
                variant="primary"
                :disabled="!botaoSalvar"
                >Salvar</b-button
              >
              <b-button @click="(logar = !logar), reset()" variant="secondary"
                >Fazer login</b-button
              >
            </div>
          </div>
          <div class="link-esqueceu-senha-user">
            <b-button v-if="logar">Esqueceu sua senha?</b-button>
          </div>
        </b-form>
      </div>
    </b-modal>
  </div>
</template>
<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

.modal-content {
  border-radius: 5px !important;
  border: none !important;
  background-color: transparent !important;
  box-shadow: 1px 1px 10px 2px rgba(0, 0, 0, 0.5);

  .modal-header{
    background-color: #6C63FF;
    border-bottom: 1px solid white;
  
    h5 {
      color: white;
      font-size: 1.3rem;
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
  padding: 1rem 1rem;
  border-radius: 5px;

}
#loginUser form div {
  width: 100% !important;
  display: flex;
  flex-direction: column;
  align-items: center;

}
#loginUser form img {
  height: 7rem;
  margin-bottom: 2rem;
  filter: drop-shadow(1px 1px 3px #252525);
}
#loginUser form input {
  margin: 5px 0px;
  border: .5px solid black;
  height: 3.5rem;
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.5);
  color: black;
}
#loginUser .checkWhatsapp{
  display: flex !important;
  flex-direction: row;
  height: 2.5rem;
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
  
}
#loginUser form label::after{
  background-color: transparent;

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
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.5);
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