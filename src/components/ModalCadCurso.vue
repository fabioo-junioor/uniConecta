<script>
import { getDadosUsuarioLocal } from '../config/global.js'
import Alerta from './Alerta.vue'

export default {
  name: "ModalCadCurso",
  components: {Alerta},
  data() {
    return {
      formCurso: {
        nome: "",
        totalHoras: null,
        valor: null,
        descricao: "",
        tipoCurso: null,
        opcoes: [
          { value: "Curso", text: "Curso" },
          { value: "Aula", text: "Aula" },
          { value: "Ofcina", text: "Oficina" },
        ],
      },
      alerta: {
        mensagem: "",
        tipo: "",
        isAlert: false
      },
      botaoCadastrar: false,
      url: null
    };
  },
  methods: {
    async cadastrarCurso() {
      let dadosUsuario = getDadosUsuarioLocal()
      const response = await fetch(this.url+'cadastrarCurso.php', {
        method: "POST",
        body: JSON.stringify({
          nome: this.formCurso.nome,
          totalHoras: this.formCurso.totalHoras,
          valor: this.formCurso.valor,
          descricao: this.formCurso.descricao,
          tipoCurso: this.formCurso.tipoCurso,
          email: dadosUsuario[0].email,
          pk_usuario: dadosUsuario[0].pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log(dados)
        if(dados[0].pk_curso == true){
          //console.log("cadastrado")
          this.mensagemAlerta(1)

        }else{
          //console.log("nao cadastrado!")
          this.mensagemAlerta(2)                  

        }
      }
    },
    enableBotaoCadastrar(){
      if((this.formCurso.nome != "") &&
        (this.formCurso.tipoCurso != "") &&
        (this.formCurso.totalHoras > 0) &&
        (this.formCurso.descricao != "")){
        this.botaoCadastrar = true

      }else{
        this.botaoCadastrar = false

      }
    },
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Curso cadastrado"
        this.alerta.tipo = "success"
        this.alerta.isAlert = true

      }else if(id == 2){
        this.alerta.mensagem = "Curso não cadastrado!"
        this.alerta.tipo = "danger"
        this.alerta.isAlert = true

      }
      this.resetaAlerta(id)

    },
    resetaAlerta(id){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

        return ((id != 2)&&(id != 3)) ? location.reload() : false

      }, 4100)

    }
  },
  mounted(){
    this.url = import.meta.env.VITE_ROOT_API

  },
  watch: {
    'formCurso.totalHoras': function(valor){
      if(valor <= 0){
        this.formCurso.totalHoras = null
        this.formCurso.valor = null
        
      }else{
        this.formCurso.totalHoras = valor
        this.formCurso.valor = valor * 5

      }
    }
  }
};
</script>
<template>
  <Alerta 
    v-if="alerta.isAlert"
    :mensagem="alerta.mensagem"
    :tipo="alerta.tipo"/>
  <b-modal
    id="modal-scrollable-curso-lg"
    size="lg"
    scrollable
    title="Cadastrar Curso">
    <div id="cadastro-curso">
      <b-form>
        <div>
          <img src="../assets/draw/login.svg" />
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
            <b-form-select
              v-model="formCurso.tipoCurso"
              :options="formCurso.opcoes"
              @change="enableBotaoCadastrar()"
            >
              <template #first>
                <b-form-select-option :value="null" disabled
                  >Selecionar tipo</b-form-select-option
                >
              </template>
            </b-form-select>
            
          </div>
          <div class="form-floating">
            <b-form-input
              required
              v-model="formCurso.totalHoras"
              type="number"
              placeholder="Informe o total de horas: "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">Total de horas: (Min. 1 hora)</label>
          </div>
          <div class="form-floating">
            <b-form-input
              disabled
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
#cadastro-curso form input:disabled{
  background-color: rgba(255, 255, 255, 0.8);

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
#cadastro-curso form select {
  width: 100%;
  margin: 5px 0px;
  border: .5px solid black;
  height: 3.5rem;
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.5);
  color: black;
  padding-left: 0.5rem;

  option:nth-child(1) {
    background-color: #6c63ff;
    color: white;
  }
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
/* Responsive */
</style>