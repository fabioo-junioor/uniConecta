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
        this.alerta.mensagem = "Logando!"
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
        this.alerta.tipo = "warning"
        this.alerta.isAlert = true

      }else if(id == 6){
        this.alerta.mensagem = "Senha enviada para email!"
        this.alerta.tipo = "info"
        this.alerta.isAlert = true

      }else if(id == 7){
        this.alerta.mensagem = "Ocorreu algum problema!"
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

        return ((id != 2)&&(id != 3)&&(id != 5)&&(id != 7)) ? location.reload() : false

      }, 4500)

    },
    async atualizaDadosPreview(){
      let dadosUsuario = await getDadosUsuarioLocal()
      this.logado = (dadosUsuario != null) ? true : false
      this.imagemPerfil = (dadosUsuario != null) ? dadosUsuario[0].img : null
      this.nomeUsuario = (dadosUsuario != null) ? dadosUsuario[0].nome.split(" ")[0] : ""

    },
    sair(){
      setTimeout(() => {
        deleteDadosUsuario()

        return location.reload()

      }, 1100)
    }
  },
  async mounted() {
      await this.atualizaDadosPreview()

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
          <b-nav-item>
              <router-link to="/sobre">SOBRE</router-link>
          </b-nav-item>
          <b-nav-item>
            <router-link to="/cursos">UNIDADES DE ESTUDO</router-link>
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
            <b-nav-item-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret left>
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
                <router-link to="/meusCursos">Minhas Unidades</router-link>
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
  z-index: 0;
  a{
    font-family: 'Work Sans', sans-serif;
    color: white !important;
    text-decoration: none;

  }
  .navbar{
    width: 100%;
    padding: 0 1.5rem;
    background-color: #6C63FF;
    box-shadow: 0px 1px 5px 2px rgba(0, 0, 0, 0.5);
    
    .navbar-brand{
      padding: .1rem .2rem;
      margin: .3rem .1rem;
      border-radius: 5px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 1px 1px 1px 1px rgba(255, 255, 255, 1);

      img{
        border-radius: 5px;
        max-width: 9rem;
        
      }
    }
    .navbar-brand:hover{
      border: 1px solid white;

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
          width: 90%;
          display: flex;
          align-items: center;
          padding: 0 0 0 1rem;

          a{
            border-radius: 5px;
            font-size: .9rem;
            padding: .6rem 1rem;
            border: 1px solid white;

          }
          a:hover{
            background-color: rgba(255, 255, 255, 1);
            box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, .2);
            color: #6C63FF !important;
            font-weight: bold;

          }
          .vue-school-active-link{
            background-color: rgba(255, 255, 255, 1);
            box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, .2);
            color: #6C63FF !important;
            font-weight: bold;
            
          }
        }
        .menu-user{
          width: 10%;
                 
          .menu-user-nao-logado{            
            a{
              display: flex;
              flex-direction: row;
              justify-content: center;
              align-items: center;
              border-radius: 5px;
              font-size: .9rem;
              padding: .3rem .5rem;              
              border: 1px solid white;
              
            }
            a:hover{
              background-color: rgba(255, 255, 255, 1);
              box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, .2);
              color: #6C63FF !important;
              font-weight: bold;

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
                width: 2.5rem;
                height: 2.5rem;

              }
              .img-icon-user:hover{
                border: 2px solid white;
                box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, .3);

              }
            }
            a:hover{
              border-bottom: 2px solid #6C63FF;

            }
            .vue-school-active-link{              
              color: #6C63FF !important;
            
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
          width: 100%;
          display: flex;
          flex-direction: column;
          align-items: center;
          padding: 0 0 0 .2rem;

          .nav-item{
            width: 100%;

            a{
              display: flex;
              justify-content: center;
              align-items: center;
              font-size: .9rem;
              padding: .5rem;
              width: 100%;
              height: 3rem;

            }
          }
        }
        .menu-user{
          width: 100%;
          display: flex;
          justify-content: center;

          .menu-user-nao-logado{
            width: 100%;
            display: flex;
            justify-content: center;

            .nav-item{
              width: 80%;

              a{
                display: flex;
                justify-content: center;
                align-items: center;
                height: 2.5rem;

              }
            }
          }
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
