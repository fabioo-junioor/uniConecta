<script>
export default {
  name: "ModalCadCurso",
  data() {
    return {
      formCurso: {
        nome: "",
        totalHoras: null,
        valor: null,
        descricao: "",
      },
      botaoCadastrar: false
    };
  },
  methods: {
    cadastrarCurso() {
      console.log(this.formCurso.nome,
        this.formCurso.totalHoras,
        this.formCurso.valor,
        this.formCurso.descricao)
    },
    enableBotaoCadastrar(){
      if((this.formCurso.nome != "") &&
        (this.formCurso.totalHoras > 0) &&
        (this.formCurso.valor > 0) &&
        (this.formCurso.descricao != "")){
        this.botaoCadastrar = true

      }else{
        this.botaoCadastrar = false

      }
    }
  },
};
</script>
<template>
  <b-modal
    id="modal-scrollable-curso-lg"
    size="lg"
    scrollable
    title="Cadastrar Curso">
    <div id="cadastro-curso">
      <b-form>
        <div>
          <img src="../assets/draw/my_password.svg" />
        </div>
        <div>
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.nome"
              type="text"
              placeholder="Informe o nome: "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">Informe o nome:</label>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.totalHoras"
              type="number"
              placeholder="Informe o total de horas: "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">Informe o total de horas:</label>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.valor"
              type="number"
              placeholder="Informe o valor: "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">Informe o valor:</label>
          </div>
          <div class="form-floating">
            <b-form-textarea
              v-model="formCurso.descricao"
              type="text"
              rows="3"
              max-rows="5"
              placeholder="Descrição: "
              @input="enableBotaoCadastrar()"
            ></b-form-textarea>
            <label for="floatingInput">Descrição:</label>
          </div>
          <div class="botao-cadastrar">
            <b-button
              :disabled="!botaoCadastrar"
              @click="cadastrarCurso()" variant="primary"
              >Salvar</b-button>
          </div>
        </div>
      </b-form>
    </div>
  </b-modal>
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
#cadastro-curso {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;

}
#cadastro-curso form {
  width: 100% !important;
  padding: 1rem 1rem;
  border-radius: 5px;

}
#cadastro-curso form div {
  width: 100% !important;
  display: flex;
  flex-direction: column;
  align-items: center;

}
#cadastro-curso form img {
  height: 7rem;
  margin-bottom: 2rem;
  filter: drop-shadow(1px 1px 3px #252525);
}
#cadastro-curso form input {
  margin: 5px 0px;
  border: .5px solid black;
  height: 3.5rem;
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.5);
  color: black;
}
#cadastro-curso form textarea {
  margin: 5px 0px;
  border: .5px solid black; 
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.5);
  color: black;
}
#cadastro-curso form label{
  font-family: 'Work Sans', sans-serif;
  color: black;
  
}
#cadastro-curso form label::after{
  background-color: transparent;

}
#cadastro-curso div .botao-cadastrar {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  padding: 10px;
  width: 100%;
}
#cadastro-curso .botao-cadastrar button {
  font-family: 'Work Sans', sans-serif;
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.5);
  width: 40%;
  height: 3rem;
  border-radius: 5px;
  color: white;
}
</style>