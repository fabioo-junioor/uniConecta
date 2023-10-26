<script>
import { getDadosUsuarioLocal, deleteDadosUsuario } from "../config/global.js"
import ModalCadUser from "./ModalCadUser.vue";
import Alerta from './Alerta.vue'

export default {
  name: "NavMenu",
  components: { ModalCadUser, Alerta },
  data() {
    return {
      logado: false,
      nomeUsuario: "",
      imagemPerfil: null,
      alerta:{
        mensagem: '',
        tipo: '',
        isAlert: false

      }
    };
  },
  methods: {
    mensagemAlerta(id) {
      if(id == 1){
        this.alerta.mensagem = "Logando..."
        this.alerta.tipo = "success"
        this.alerta.isAlert = true

      }else if(id == 2){
        this.alerta.mensagem = "Email incorreto!"
        this.alerta.tipo = "danger"
        this.alerta.isAlert = true

      }else if(id == 3){
        this.alerta.mensagem = "Senha incorreta!"
        this.alerta.tipo = "danger"
        this.alerta.isAlert = true

      }else if(id == 4){
        this.alerta.mensagem = "Cadastrado, efetue o login!"
        this.alerta.tipo = "success"
        this.alerta.isAlert = true

      }else if(id == 5){
        this.alerta.mensagem = "Email já existe!"
        this.alerta.tipo = "info"
        this.alerta.isAlert = true

      }
        this.resetaAlerta(id)

    },
    resetaAlerta(id){
      setTimeout(() => {
        this.alerta.mensagem = ""
        this.alerta.tipo = ""
        this.alerta.isAlert = false

        return ((id != 2)&&(id != 3)&&(id != 5)) ? location.reload() : false

      }, 4050)

    },
    atualizaDadosPreview(dadosUsuario){
      this.logado = (dadosUsuario != null) ? true : false
      this.imagemPerfil = (dadosUsuario != null) ? dadosUsuario[0].img : null
      this.nomeUsuario = (dadosUsuario != null) ? dadosUsuario[0].nome.split(" ")[0] : ""

    },
    sair(){
      setTimeout(() => {
        deleteDadosUsuario()
        console.log("saiu...")

        return location.reload()

      }, 1500)      
    }
  },
  async mounted() {
      let dadosUsuario = await getDadosUsuarioLocal()
      this.atualizaDadosPreview(dadosUsuario)

  }
};
</script>

<template>
  <div id="navmenu">
    <Alerta
      v-if="alerta.isAlert"
      :mensagem="alerta.mensagem"
      :tipo="alerta.tipo" />
    <b-navbar toggleable="lg">
      <router-link to="/">
        <b-navbar-brand><img src="../assets/img/logo.png"></b-navbar-brand>
      </router-link>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
       <b-navbar-nav>
        <div class="menu-estatico">
          <b-nav-item disabled>
              <router-link to="/sobre">SOBRE</router-link>
          </b-nav-item>
          <b-nav-item>
            <router-link to="/cursos">CURSOS</router-link>
          </b-nav-item>
        </div>
        <div class="menu-user">
          <div
            class="menu-user-nao-logado"
            v-if="!logado">
            <b-nav-item>
                <a v-b-modal.modal-scrollable-user-lg>
                  <ModalCadUser
                    @mensagemAlerta="mensagemAlerta" />
                    LOGIN
                </a>
              </b-nav-item>
          </div>
          <div 
            class="menu-user-logado"
            v-else>
            <b-nav-item-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret right>
              <template #button-content>
                <img
                  id="imagemPerfil"
                  class="img-icon-user"
                  v-if="!imagemPerfil"
                  src="../assets/img/person1.png" />
                <img
                  id="imagemPerfil"
                  class="img-icon-user"
                  v-else
                  :src="imagemPerfil" />
                  <b-tooltip
                    target="imagemPerfil"
                    variant="primary" 
                    placement="bottomleft">
                    {{nomeUsuario}}
                  </b-tooltip>
              </template>
              <b-dropdown-item>
                <router-link to="/dashboard">Dashboard</router-link>
              </b-dropdown-item>
              <b-dropdown-item>
                <router-link to="/meusCursos">Meus Cursos</router-link>
              </b-dropdown-item>
              <b-dropdown-item>
                <router-link to="/editarPerfil">Editar Perfil</router-link>
              </b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
              <b-dropdown-item
                @click="sair()">Sair</b-dropdown-item>
            </b-nav-item-dropdown>
          </div>
        </div>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>


<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#navmenu {
  a{
    font-family: 'Work Sans', sans-serif;
    color: white !important;
    text-decoration: none;

  }
  .navbar{
    width: 100%;
    padding: 0 1rem;
    background-color: #6C63FF;
    box-shadow: 0px 1px 10px 2px rgba(0, 0, 0, 0.5);

    .navbar-brand{
      padding: 0;
      margin: .2rem .1rem;
      border: 1px solid white;
      border-radius: 5px;

      img{
        border-radius: 5px;
        max-width: 9rem;
        
      }
    }
    .navbar-brand:hover{
      background-color: white;
      box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.3);

    }
    .navbar-toggler{
      border: 1px solid white;

    }
    #nav-collapse{
      .navbar-nav{
        min-width: 90%;
        height: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;

        .menu-estatico{
          display: flex;
          align-items: center;
          padding: 0 0 0 1rem;

          a{
            font-size: .9rem;
            padding: .5rem;
            font-weight: 600;

          }
          a:hover{
            color: white;
            text-decoration: underline 3px;
            text-underline-offset: 100%;

          }
        }
        .menu-user{          
          .menu-user-nao-logado{
            a{
              color: white !important;
              padding: 0;
              font-weight: 600;
              font-size: .9rem;
  
            }
            a:hover{
              color: white;
              text-decoration: underline 3px;
              text-underline-offset: 100%;

            }
          }
          .menu-user-logado{
            li{
              color: white;
              font-weight: 600;

            }
            li::first-letter{
              text-transform: uppercase;
              
            }
            a{
              color: black !important;
              font-size: .9rem;
              font-weight: 400;
              padding: 0;

              .img-icon-user{
                border: 2px solid #6C63FF;
                border-radius: 50%;
                width: 3.1rem;
                height: 3.1rem;

              }
              .img-icon-user:hover{
                border: 2px solid white;
                box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, .3);

              }
            }
          }
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
#navmenu {
  .navbar{
    padding: 0 1rem 0 .2rem;

    #nav-collapse{
      .navbar-nav{
        min-width: 90%;
        display: flex;
        flex-direction: column;

        .menu-estatico{
          display: flex;
          flex-direction: column;
          align-items: flex-start;
          padding: 0 0 0 .2rem;

          a{
            font-size: .9rem;
            padding: .5rem;

          }
          a:hover{
            text-decoration: none;

          }
          a:active{
            color: rgba(0, 0, 0, 0.7) !important;

          }
        }
        .menu-user{
          .menu-user-logado{
            margin-bottom: .5rem;
            
            a{
              .img-icon-user{
                width: 2.5rem;
                height: 2.5rem;
                margin-left: .5rem;

              }
            }
          }
        }
      }
    }
  }  
}
}
@media only screen and (max-width: 720px) {
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>
