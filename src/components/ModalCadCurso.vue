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
        valorFinal: 0,
        tipoValor: null,
        valores: [
          {item: 0, name: 'Valor 1'},
          {item: 0, name: 'Valor 2'},
          {item: 0, name: 'Valor 3'}
        ],
        data: "",
        horario: "",
        local: "",
        descricao: "",
        linkMaterial: "",
        grupoApoio: false,
        tipoCurso: null,
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
      url: null,
      isValidGrupoHoras: false,
      isValidValor: false
    };
  },
  methods: {
    async cadastrarCurso() {
      const response = await fetch(this.url+'cadastrarCurso.php', {
        method: "POST",
        body: JSON.stringify({
          nome: this.formCurso.nome,
          totalHoras: this.formCurso.totalHoras,
          valor: this.formCurso.valorFinal,
          descricao: this.formCurso.descricao,
          tipoCurso: this.formCurso.tipoCurso,
          localCurso: this.formCurso.local,
          dataCurso: this.formCurso.data,
          horario: this.formCurso.horario,
          linkMaterial: this.formCurso.linkMaterial,
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
        this.alerta.mensagem = "Unidade cadastrada!"
        this.alerta.tipo = "success"
        this.alerta.isAlert = true

      }else if(id == 2){
        this.alerta.mensagem = "Unidade não cadastrada!"
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
      if(valor > '0'){
        if(this.formCurso.grupoApoio){
          this.formCurso.valorFinal = '0'

        }else{
          this.formCurso.valorFinal = (this.formCurso.tipoValor === 0) ? 0 : parseInt(this.formCurso.tipoValor) + parseInt(valor)

        }
      }else{
        if(this.formCurso.grupoApoio){
          this.formCurso.valorFinal = '0'

        }else{
          this.formCurso.valorFinal = (this.formCurso.tipoValor === 0) ? 0 : parseInt(this.formCurso.tipoValor)

        }
      }    
    },
    'formCurso.grupoApoio': function(){
      if(this.formCurso.grupoApoio){
        this.formCurso.valorFinal = '0'
        this.isValidValor = true

      }else{
        this.formCurso.valorFinal = '0'
        this.formCurso.tipoValor = 0
        this.formCurso.valorFinal = (this.formCurso.tipoValor === 0) ? 0 : parseInt(this.formCurso.tipoValor) + parseInt(this.formCurso.totalHoras)
        this.isValidValor = false

      }
    },
    'formCurso.tipoCurso': function(){
      if(this.formCurso.tipoCurso == "Aula"){
        this.formCurso.valores[0].item = 2
        this.formCurso.valores[0].name = 'Valor: 2'
        this.formCurso.valores[1].item = 3
        this.formCurso.valores[1].name = 'Valor: 3'
        this.formCurso.valores[2].item = 4
        this.formCurso.valores[2].name = 'Valor: 4'


      }else if(this.formCurso.tipoCurso == "Oficina"){
        this.formCurso.valores[0].item = 3
        this.formCurso.valores[0].name = 'Valor: 3'
        this.formCurso.valores[1].item = 4
        this.formCurso.valores[1].name = 'Valor: 4'
        this.formCurso.valores[2].item = 5
        this.formCurso.valores[2].name = 'Valor: 5'
    

      }else if(this.formCurso.tipoCurso == "Curso"){
        this.formCurso.valores[0].item = 3
        this.formCurso.valores[0].name = 'Valor: 3'
        this.formCurso.valores[1].item = 4
        this.formCurso.valores[1].name = 'Valor: 4'
        this.formCurso.valores[2].item = 5
        this.formCurso.valores[2].name = 'Valor: 5'
    

      }else if(this.formCurso.tipoCurso == "Palestra"){
        this.formCurso.valores[0].item = 2
        this.formCurso.valores[0].name = 'Valor: 2'
        this.formCurso.valores[1].item = 3
        this.formCurso.valores[1].name = 'Valor: 3'
        this.formCurso.valores[2].item = 4
        this.formCurso.valores[2].name = 'Valor: 4'
    

      }
      this.formCurso.valorFinal = '0'
      this.formCurso.totalHoras = null
      this.formCurso.tipoValor = 0
      this.isValidGrupoHoras = true

    },
    'formCurso.tipoValor': function(valor){
      this.formCurso.valorFinal = ((this.formCurso.totalHoras === null)||(this.formCurso.totalHoras == '')||(valor === 0)) ? valor : parseInt(this.formCurso.totalHoras) + parseInt(valor)

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
    title="Cadastrar Unidade">
    <div id="cadastro-curso">
      <b-form>
        <div>
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.nome"
              type="text"
              placeholder="*Titulo : "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">*Titulo:</label>
          </div>
          <div class="form-floating">
            <b-form-select
              v-model="formCurso.tipoCurso"
              :options="formCurso.opcoes"
              @change="enableBotaoCadastrar()"
            >
              <template #first>
                <b-form-select-option :value="null" disabled
                  >*Selecione o tipo:</b-form-select-option
                >
              </template>
            </b-form-select>
            
          </div>
          <div class="checkGrupoApoio">
              <b-form-checkbox
                :disabled="!isValidGrupoHoras"
                v-model="formCurso.grupoApoio"
                :value="true"
                :unchecked-value="false"      
              ></b-form-checkbox>Grupo de Apoio
              <i class='bx bx-info-circle'
                id="tooltip-button-variant"></i>
              <b-tooltip target="tooltip-button-variant"
                variant="danger">Marcar opção se for algum grupo de apoio como: monitoria, pet, etc.</b-tooltip>
            </div>
          <div class="form-floating">
            <b-form-input
              :disabled="!isValidGrupoHoras"
              v-model="formCurso.totalHoras"
              type="number"
              placeholder="*Total de horas: "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">*Total de horas: (Min. 1 hora)</label>
          </div>
          <div class="checks-valores">
            <b-form-radio-group
              :disabled="!isValidGrupoHoras || isValidValor"
              v-model="formCurso.tipoValor"
              :options="formCurso.valores"
              value-field="item"
              text-field="name">
            </b-form-radio-group>
          </div>
          <div class="valor-curso">
            <i class='bx bx-info-circle'
                id="tooltip-button-variant2"></i>
              <b-tooltip target="tooltip-button-variant2"
                variant="danger">Valor final da unidade: valor definido acima + total de horas</b-tooltip>
            <p>Valor: {{formCurso.valorFinal}}</p>
          </div>
          <div class="data-horario">
            <div class="form-floating">
              <b-form-input
                v-model="formCurso.local"
                type="text"
                placeholder="Local : "
                @input="enableBotaoCadastrar()"
                ></b-form-input>
              <label for="floatingInput">Local:</label>
            </div>
            <div>
              <b-form-input
                v-model="formCurso.data"
                type="date"
                placeholder="Data : "
                @input="enableBotaoCadastrar()"
                ></b-form-input>
            </div>
            <div>
              <b-form-input
                v-model="formCurso.horario"
                type="time"
                placeholder="Horario : "
                @input="enableBotaoCadastrar()"
                ></b-form-input>              
            </div>
          </div>
          <div class="form-floating">
            <b-form-textarea
              v-model="formCurso.descricao"
              type="text"
              rows="2"
              max-rows="5"
              placeholder="*Descrição: "
              @input="enableBotaoCadastrar()"
            ></b-form-textarea>
            <label for="floatingInput">*Descrição:</label>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.linkMaterial"
              type="text"
              placeholder="Link material extra : "
              @input="enableBotaoCadastrar()"
            ></b-form-input>
            <label for="floatingInput">Link material extra:</label>
          </div>
          <div class="campos-obrigatorios">
            <p>* Campos obrigatorios </p>
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
  padding: .2rem .5rem .5rem .5rem;
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
  border: none;
  height: 3.5rem;
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
  color: black;
}
#cadastro-curso form input:disabled{
  background-color: rgba(255, 255, 255, 0.8);

}
#cadastro-curso form input:focus{
  border-bottom: 1px solid black;

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
  i{
    padding: 0 .2rem;
  }
}
#cadastro-curso .checks-valores{
  padding: .5rem 0;

  .bv-no-focus-ring{
    width: 100% !important;
    display: flex;
    flex-direction: row;
      justify-content: space-around;

    .custom-control{
      display: flex;
      flex-direction: row;
      width: 33% !important;

      input{
        height: 100% !important;
        box-shadow: none;

      }
    }
  }
}
#cadastro-curso .valor-curso{
  display: flex !important;
  flex-direction: row !important;
  align-items: center !important;
  color: white;
  font-size: 1rem;
  height: 2rem;

  p{
    margin: 0 !important;

  }
  i{
    padding: 0 .2rem;

  }
}
#cadastro-curso form .data-horario{
  display: flex;
  flex-direction: row;
  justify-content: space-between;

  div{
    width: 33% !important;
    padding: .2rem 0;

  }
}
#cadastro-curso form textarea {
  margin: 5px 0px;
  border: none; 
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
  color: black;
}
#cadastro-curso form textarea:focus{
  border-bottom: 1px solid black;
  
}
#cadastro-curso form label{
  font-family: 'Work Sans', sans-serif;
  color: black;
  font-size: .9rem;
  
}
#cadastro-curso form label::after{
  background-color: transparent;

}
#cadastro-curso form select {
  width: 100%;
  margin: 5px 0px;
  border: none;
  height: 2.5rem;
  border-radius: 5px;
  background-color: white;
  box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
  color: black;
  font-size: .9rem;
  padding-left: 0.5rem;

  option:nth-child(1) {
    background-color: black;
    color: white;
  }
}
#cadastro-curso form select:focus{
  border-bottom: 1px solid black;
  
}
#cadastro-curso .campos-obrigatorios{
  display: flex !important;
  flex-direction: row;
  justify-content: flex-end;
  padding: .5rem;
  color: white;
  font-size: .9rem;

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
  box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
  width: 40%;
  height: 3rem;
  border-radius: 5px;
  color: white;
}
/* Responsive */
</style>