<script>
export default {
  name: "ModalUser",
  data() {
    return {
      form: {
        nome: "",
        email: "",
        telefone: null,
        senha: "",
      },
      logar: true,
    };
  },
  methods: {
    logarUser() {
      if (this.form.email === "" || this.form.senha === "") {
        
      } else {
        console.log("Logou- ", this.form.email, this.form.senha)
      
      }
    },
    cadastrarUser() {
      if (this.form.email === "" ||
        this.form.senha === "" ||
        this.form.nome === "" ||
        this.form.telefone === null) {
      } else {
      }
    },
    reset() {
      this.form.nome = "";
      this.form.email = "";
      this.form.senha = "";
      this.form.telefone = null;
      console.log("Resetou");
    },
  },
};
</script>
<template>
  <b-modal
    id="modal-scrollable-user-lg"
    size="lg"
    scrollable
    title="Login Usuário">
    <div id="loginUser">
      <b-form>
        <div>
          <img src="../assets/draw/my_password.svg" />
        </div>
        <div v-if="logar">
          <b-form-input
            v-model="form.email"
            type="email"
            placeholder="Informe seu email: "
          ></b-form-input>
          <b-form-input
            v-model="form.senha"
            type="password"
            placeholder="Informe sua senha: "
          ></b-form-input>
          <div class="buttons-login-user">
            <b-button @click="logarUser()" variant="primary">Acessar</b-button>
            <b-button @click="(logar = !logar), reset()" variant="secondary"
              >Cadastre-se</b-button
            >
          </div>
        </div>
        <div v-else>
          <b-form-input
            v-model="form.nome"
            type="text"
            placeholder="Informe seu nome: "
          ></b-form-input>
          <b-form-input
            v-model="form.email"
            type="email"
            placeholder="Informe seu email: "
          ></b-form-input>
          <b-form-input
            v-model="form.telefone"
            type="number"
            placeholder="Informe seu telefone: "
          ></b-form-input>
          <b-form-input
            v-model="form.senha"
            type="password"
            placeholder="Informe sua senha: "
          ></b-form-input>
          <div class="buttons-login-user">
            <b-button @click="cadastrarUser()" variant="primary"
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
</template>
<style lang="scss">
.modal-content {
  border-radius: 5px !important;
  border: none !important;

  .modal-header{
    background-color: #232526;
    border: none !important;
  
    h5 {
      color: #252525;
      font-size: 1.4rem;
      font-family: Verdana, Geneva, Tahoma, sans-serif;

    }
  }
  .modal-header .close {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 0.2rem 0.5rem;
    border: none;
    border-radius: 5px;
    color: black;

  }
  .modal-header .close:hover {
    background-color: rgba(255, 255, 255, 0.7);

  }
  .modal-body {
    padding: 0;
    background-color: #232526 !important;
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
  margin-bottom: 1rem;
  filter: drop-shadow(1px 1px 3px #252525);
}
#loginUser form input {
  margin: 5px 0px;
  border: .5px solid white;
  height: 3.5rem;
  border-radius: 5px;
  background-color: #3e3e3e;
  box-shadow: 2px 2px 5px #252525;
  color: #fff;
}
#loginUser form input::placeholder {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  color: rgba(255, 255, 255, 0.8);
  font-size: 1rem;
}
#loginUser div .buttons-login-user {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  padding: 10px;
  width: 100%;
}
#loginUser .buttons-login-user button {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  box-shadow: 2px 2px 5px #252525;
  width: 40%;
  height: 3rem;
  border-radius: 10px;
  color: rgba(255, 255, 255, 0.9);
}
#loginUser .link-esqueceu-senha-user {
  margin: 1rem 0;

}
#loginUser .link-esqueceu-senha-user button {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 0.8rem;
  padding: 0.8rem 2rem;
  color: rgba(255, 255, 255, 0.8);
  font-weight: bold;
  background-color: transparent;
  border: none;
  border-radius: 10px;
}
#loginUser .link-esqueceu-senha-user button:hover {
  color: rgba(255, 0, 0, 0.7);
  font-weight: bold;
}
</style>