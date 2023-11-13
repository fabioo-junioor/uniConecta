<script>
import Alerta from './Alerta.vue'

export default {
  name: "ModalEdicaoCurso",
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
      botaoSalvar: false,
      url: null,
      isValidGrupoHoras: false,
      isValidValor: false,
    };
  },
  props:{
    pk_curso: Number

  },
  methods: {
    async buscarDadosEdicaoCurso(pk_curso) {
      const response = await fetch(this.url + "buscaDadosCurso.php?dadosEdicaoCurso=1", {
        method: "POST",
        body: JSON.stringify({
          pk_curso: pk_curso
          
        }),
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_curso != null){
          this.formCurso.nome = await dados[0].nome
          this.formCurso.tipoCurso = await dados[0].tipoCurso
          this.formCurso.totalHoras = await dados[0].totalHoras
          //this.formCurso.valorFinal = await dados[0].valorCurso
          this.formCurso.local = await dados[0].localCurso
          this.formCurso.data = await dados[0].dataCurso
          this.formCurso.horario = await dados[0].horario
          this.formCurso.descricao = await dados[0].descricao
          this.formCurso.linkMaterial = await dados[0].linkMaterial

          this.botaoSalvar = true
        }else{
          
        }
      }
    },
    async salvarEdicao(pk_curso){
      const response = await fetch(this.url + "editarCurso.php", {
        method: "POST",
        body: JSON.stringify({
          pk_curso: pk_curso,
          nome: this.formCurso.nome,
          tipoCurso: this.formCurso.tipoCurso,
          totalHoras: this.formCurso.totalHoras,
          valorCurso: this.formCurso.valorFinal,
          localCurso: this.formCurso.local,
          dataCurso: this.formCurso.data,
          horario: this.formCurso.horario,
          descricao: this.formCurso.descricao,
          linkMaterial: this.formCurso.linkMaterial
        }),
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        if(dados[0].pk_curso != null){
          this.mensagemAlerta(1)

        }
      }

    },
    enableBotaoSalvar(){
      if((this.formCurso.nome != "") &&
        (this.formCurso.tipoCurso != "") &&
        (this.formCurso.totalHoras > 0) &&
        (this.formCurso.descricao != "")){
        this.botaoSalvar = true

      }else{
        this.botaoSalvar = false

      }
    },
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Unidade Editada!"
        this.alerta.tipo = "success"
        this.alerta.isAlert = true

      }
      this.resetaAlerta(id)

    },
    resetaAlerta(id){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

        return location.reload()

      }, 4500)

    }
  },
  async created(){
    this.url = import.meta.env.VITE_ROOT_API
    this.isUpdate = false

  },
  watch: {
    pk_curso: async function(){
      await this.buscarDadosEdicaoCurso(this.pk_curso)

    },
    'formCurso.totalHoras': function(valor){
      //console.log("horas")
      if(valor > '0'){
        if(this.formCurso.grupoApoio){
          this.formCurso.valorFinal = '0'

        }else{
          this.formCurso.valorFinal = ((this.formCurso.tipoValor === 0)) ? 0 : parseInt(this.formCurso.tipoValor) + parseInt(valor)

        }
      }else{
        if(this.formCurso.grupoApoio){
          this.formCurso.valorFinal = '0'

        }else{
          this.formCurso.valorFinal = (this.formCurso.tipoValor === 0) ? 0 : parseInt(this.formCurso.tipoValor)

        }
      }    
    },
    'formCurso.grupoApoio': async function(){
      //console.log("--",this.formCurso.tipoValor)
      if(this.formCurso.grupoApoio){
        this.formCurso.valorFinal = '0'
        this.isValidValor = true

      }else{
        this.formCurso.valorFinal = '0'
        this.formCurso.tipoValor = 0
        //this.formCurso.valorFinal = parseInt(this.formCurso.tipoValor) + parseInt(this.formCurso.totalHoras)
        this.isValidValor = false

      }
    },
    'formCurso.tipoCurso': function(){
      //console.log("tipo")
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
      //console.log(this.formCurso.valorFinal, valor, this.formCurso.totalHoras)
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
    id="modalEdicaoCurso"
    size="lg"
    title="Editar Unidade">
    <div id="editar-curso">
      <b-form id="formulario-editar-curso">
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.nome"
              type="text"
              placeholder="*Titulo : "
              @input="enableBotaoSalvar()"
            ></b-form-input>
            <label for="floatingInput">*Titulo:</label>
          </div>
          <div class="form-floating">
            <b-form-select
              v-model="formCurso.tipoCurso"
              :options="formCurso.opcoes"
              @change="enableBotaoSalvar()"
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
              ></b-form-checkbox>Grupo de Apoio (Monitoria; Pet; etc)?
            </div>
          <div class="form-floating">
            <b-form-input
              :disabled="!isValidGrupoHoras"
              v-model="formCurso.totalHoras"
              type="number"
              placeholder="*Total de horas: "
              @input="enableBotaoSalvar()"
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
            <p>Valor: {{formCurso.valorFinal}}</p>
          </div>
          <div class="data-horario">
            <div class="form-floating">
              <b-form-input
                v-model="formCurso.local"
                type="text"
                placeholder="Local : "
                ></b-form-input>
              <label for="floatingInput">Local:</label>
            </div>
            <div>
              <b-form-input
                v-model="formCurso.data"
                type="date"
                placeholder="Data : "
                ></b-form-input>
            </div>
            <div>
              <b-form-input
                v-model="formCurso.horario"
                type="time"
                placeholder="Horario : "
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
              @input="enableBotaoSalvar()"
            ></b-form-textarea>
            <label for="floatingInput">*Descrição:</label>
          </div>
          <div class="form-floating">
            <b-form-input
              v-model="formCurso.linkMaterial"
              type="text"
              placeholder="Link material extra : "
            ></b-form-input>
            <label for="floatingInput">Link material extra:</label>
          </div>
          <div class="campos-obrigatorios">
            <p>* Campos obrigatorios </p>
          </div>
          <div class="botao-cadastrar">
            <b-button
              :disabled="!botaoSalvar"
              @click="salvarEdicao(pk_curso)" variant="primary"
              >Salvar</b-button>
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
#editar-curso{
  width: 100%;

  #formulario-editar-curso{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: .2rem .5rem .5rem .5rem;

    div{
      margin: .2rem 0;

      label{
        font-family: 'Work Sans', sans-serif;
        color: black;
        font-size: .9rem;

      }
      input{
        background-color: white;
        border: none;
        border-radius: 5px;
        box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
        color: black;
        height: 3.6rem;
        
      }
      input:disabled{
        background-color: rgba(255, 255, 255, 0.8);
      
      }
      input:focus{
        border-bottom: 1px solid black;

      }
      select{
        width: 100%;
        height: 2.5rem;
        border: none;
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
      select:focus{
        border-bottom: 1px solid black;

      }
      textarea{
        border: none; 
        border-radius: 5px;
        background-color: white;
        box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 1);
        color: black;

      }
      textarea:focus{
        border-bottom: 1px solid black;

      }
    }
    .checkGrupoApoio{
      display: flex;
      flex-direction: row;
      padding: 0 .2rem;
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
    .checks-valores div{
      display: flex;
      flex-direction: row;
      justify-content: space-around;

      .custom-control{
        display: flex;
        flex-direction: row;
        justify-content: center;
        width: 33% !important;

        input{
          height: 100% !important;
          box-shadow: none;

        }
      }
    }
    .valor-curso{
      padding: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      
      p{
        color: white;
        padding: .5rem 0 0 .5rem;
      }
    }
    .data-horario{
      display: flex;
      flex-direction: row;
      justify-content: space-between;

      div{
        width: 33% !important;
        padding: .2rem 0;

      }
    }
    .campos-obrigatorios{
      display: flex;
      justify-content: flex-end;
      
      p{
        color: white;
        font-size: .9rem;
        padding: 0 .5rem;

      }
    }
    .botao-cadastrar{
      width: 100%;
      display: flex;
      justify-content: center;

      button{
        width: 90%;
        height: 3rem;
        font-family: 'Work Sans', sans-serif;
        box-shadow: 1px 1px 0px 0px rgba(0, 0, 0, 1);
        color: white;
      }
    }
  }
}
/* Responsive */
</style>