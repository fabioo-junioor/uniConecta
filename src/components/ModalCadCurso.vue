<script>
import { getDadosUsuarioLocal } from '../config/global.js'
import Alerta from './Alerta.vue'

export default {
  name: "ModalCadCurso",
  components: {Alerta},
  data() {
    return {
      pk_usuario: null,
      email: "",
      formCurso: {
        nome: "",
        totalHoras: null,
        valor: null,
        descricao: "",
        tipoCurso: null,
        grupoApoio: false,
        opcoes: [
          { value: "Aula", text: "Aula" },
          { value: "Oficina", text: "Oficina" },
          { value: "Curso", text: "Curso" },
          { value: "Palestra", text: "Palestra" },
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
      const response = await fetch(this.url+'cadastrarCurso.php', {
        method: "POST",
        body: JSON.stringify({
          nome: this.formCurso.nome,
          totalHoras: this.formCurso.totalHoras,
          valor: this.formCurso.valor,
          descricao: this.formCurso.descricao,
          tipoCurso: this.formCurso.tipoCurso,
          email: this.email,
          pk_usuario: this.pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_curso == true){
          this.mensagemAlerta(1)

        }else{
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
    async atualizaDados(){
      let dadosUsuario = await getDadosUsuarioLocal()
      this.pk_usuario = dadosUsuario != null ? dadosUsuario[0].pk_usuario : null
      this.email = dadosUsuario != null ? dadosUsuario[0].email : ""

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

      }, 4500)

    }
  },
  mounted(){
    this.url = import.meta.env.VITE_ROOT_API
    this.atualizaDados()

  },
  watch: {
    'formCurso.totalHoras': function(valor){
      if(valor <= 0){
        this.formCurso.totalHoras = null
        this.formCurso.valor = null
        
      }else{
        this.formCurso.totalHoras = valor
        this.formCurso.valor = (this.formCurso.grupoApoio) ? 0 : (valor * 5)

      }
    },
    'formCurso.grupoApoio': function(){
      if(this.formCurso.grupoApoio){
        this.formCurso.valor = 0

      }else{
        this.formCurso.valor = this.formCurso.totalHoras * 5
        
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
      <div>
        <img src="../assets/draw/educator.svg" />
      </div>
      <b-form>
        <div>
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.nome"
              type="text"
              placeholder="Titulo : "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">Titulo:</label>
          </div>
          <div class="form-floating">
            <b-form-select
              v-model="formCurso.tipoCurso"
              :options="formCurso.opcoes"
              @change="enableBotaoCadastrar()"
            >
              <template #first>
                <b-form-select-option :value="null" disabled
                  >Selecione o tipo:</b-form-select-option
                >
              </template>
            </b-form-select>
            
          </div>
          <div class="checkGrupoApoio">
              <b-form-checkbox
                v-model="formCurso.grupoApoio"
                :value="true"
                :unchecked-value="false"      
              ></b-form-checkbox>Grupo de Apoio (Monitoria; Pet; etc)?
            </div>
          <div class="form-floating">
            <b-form-input
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
              placeholder="Valor: (Moedas) "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">Valor: (Moedas)</label>
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
    height: 3rem;
  
    h5 {
      color: white;
      font-size: 1.1rem;
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
      width: 11rem;
      height: auto;
      margin: 4rem 0 1rem 0;
      filter: drop-shadow(1px 1px 2px black);
    }

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
#cadastro-curso form input {
  margin: 5px 0px;
  border: .5px solid black;
  height: 3.5rem;
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.5);
  color: black;
}
#cadastro-curso form input:disabled{
  background-color: rgba(255, 255, 255, 0.8);

}
#cadastro-curso .checkGrupoApoio{
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
#cadastro-curso form textarea {
  margin: 5px 0px;
  border: .5px solid black; 
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.5);
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
  box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.5);
  color: black;
  padding-left: 0.5rem;

  option:nth-child(1) {
    background-color: black;
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
  box-shadow: 1px 1px 0px 0px rgba(0, 0, 0, 1);
  width: 40%;
  height: 3rem;
  border-radius: 5px;
  color: white;
}
/* Responsive */
</style>