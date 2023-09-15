<script>
import ModalCadUser from "./ModalCadUser.vue";

export default {
  name: "NavMenu",
  components: { ModalCadUser },
  data() {
    return {
      logado: true,
      nameUser: "Fabio",
    };
  },
  methods: {
    cad() {
      console.log("teste");
    },
  },
};
</script>

<template>
  <div id="navmenu">
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
            <router-link to="/cursos">CURSOS</router-link>
          </b-nav-item>
        </div>
        <div class="menu-user">
          <div
            class="menu-user-nao-logado"
            v-if="!logado">
            <b-nav-item>
                <a v-b-modal.modal-scrollable-user-lg>
                  <ModalCadUser />
                    LOGIN
                </a>
              </b-nav-item>
          </div>
          <div
            class="menu-user-logado"
            v-else>
            <b-nav-item-dropdown :text="nameUser" right>
              <b-dropdown-item>
                <router-link to="/dashboard">Dashboard</router-link>
              </b-dropdown-item>
              <b-dropdown-item>
                <router-link to="meusCursos">Meus Cursos</router-link>
              </b-dropdown-item>
              <b-dropdown-item>
                <router-link to="editarPerfil">Editar Perfil</router-link>
              </b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
              <b-dropdown-item>Sair</b-dropdown-item>
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
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        //background-color: purple;

        .menu-estatico{
          display: flex;
          //background-color: blue;
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
          //background-color: green;
          
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
            a{
              color: black !important;
              font-size: .9rem;
              font-weight: 400;
              padding: 0;
  
            }
          }
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
          padding: 0 0 0 .2rem;

          a{
            font-size: .9rem;
            padding: .5rem;

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
