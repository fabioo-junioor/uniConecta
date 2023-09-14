<script>
export default {
  name: "EditarPerfil",
  data() {
    return {
      nomeUser: "Fabio Junior",
      curso: "Sistemas de informação",
      totalPontos: 626,
      totalCoins: 515,
      formEdicao: {
        imagem: null,
        adicionouImagem: false,
        nome: "Fabio",
        email: "fabio@inf",
        telefone: 99996655,
        graduacao: null,
        opcoes: [
          {value: 'Sistemas de informação', text: 'Sistemas de informação'},
          {value: 'Medicina', text: 'Medicina'},
        ],
        senha: "asdasd22",
      },
      botaoSalvar: false

    }
  },
  methods: {
    enableBotaoSalvar(){
      console.log("--> ", this.formEdicao.adicionouImagem)
     
      if((this.formEdicao.adicionouImagem == true) &&
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
          //console.log(this.formEdicao.adicionouImagem)
          this.enableBotaoSalvar()

        }
        reader.readAsDataURL(input.files[0])
      }
    },
    salvarEdicao(){
      console.log(this.formEdicao.imagem,
        this.formEdicao.nome,
        this.formEdicao.email,
        this.formEdicao.telefone,
        this.formEdicao.graduacao,
        this.formEdicao.senha)

    }
  }
};
</script>

<template>
  <div id="editar-perfil">
    <div class="lado-user">
      <div class="foto-user">
        <img src="../assets/img/person1.png" />
      </div>
      <div class="dados-user">
        <h3>{{ nomeUser }}</h3>
        <h2>{{ curso }}</h2>
        <div>
          <img src="../assets/gifs/coin.gif" />
          {{ totalCoins }}
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
            <h5 v-if="!formEdicao.adicionouImagem">Visualização</h5>
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
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
      border-radius: 5px;

      img {
        max-height: 15rem;
        max-width: 15rem;
        padding: 0;
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
/*################################################*/
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 992px) {
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
}
@media only screen and (max-width: 360px) {
}
</style>