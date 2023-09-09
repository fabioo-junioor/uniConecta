<script>
import ModalUser from './ModalUser.vue'

export default{
  name: 'NavMenu',
  components: {ModalUser},
  data(){
    return{
      logado: true,
      nameUser: "Fabio"

    }
  },
  methods:{
    cad(){
      console.log("teste")

    }
  }
}
</script>

<template>
  <div id="navmenu">
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand>
        <router-link to="/">UniConecta</router-link>
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <div class="menuStatic">
            <b-nav-item>
              <router-link to="/sobre">SOBRE</router-link>
            </b-nav-item>
            <b-nav-item><router-link to="/cursos">CURSOS</router-link></b-nav-item>
          </div>
          <div class="menu-user">
            <div v-if="!logado"
              class="menu-user-nao-logado">
              <b-nav-item>
                <a v-b-modal.modal-scrollable-user-lg>
                  <ModalUser />
                    LOGIN
                </a>
              </b-nav-item>
            </div>
            <div v-else
              class="menu-user-logado">
              <b-nav-item-dropdown
                :text=nameUser>
                <b-dropdown-item>
                  <router-link to="/dashboard">Dashboard</router-link>
                </b-dropdown-item>
                <b-dropdown-item>
                  <router-link to="meusCursos">Meus Cursos</router-link>
                </b-dropdown-item>
                <b-dropdown-item id="teste">Editar Perfil</b-dropdown-item>
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
#navmenu{
  width: 100%;

  .navbar{
    width: 100%;
    background: #6C63FF !important;
    box-shadow: 0px 2px 5px 3px rgba(0, 0, 0, 0.5);

    padding: .5rem;

    .navbar-brand{
      border: 1px solid white;
      border-radius: 5px;

    }
    .navbar-brand:hover{
      background-color: rgba(255, 255, 255, 0.1);

    }
    #nav-collapse{
      width: 100%;

      .navbar-nav{
        width: 100%;
        display: flex;
        flex-direction: row;
        //background-color: red;
        
        .menuStatic{
          display: flex;
          flex-direction: row;
          width: 80%;
          //background-color: blueviolet;

          .nav-item{
            //background-color: green;
            padding: 0 1rem;

            a{
              color: white;
              text-decoration: none;
              font-size: 1.1rem;
              background-color: transparent;

            }
            a:hover{
              color: white;
              text-decoration: underline 3px;
              text-underline-offset: 100%;

            }          
          }
        }
        .menu-user{
          display: flex;
          flex-direction: row;

          .menu-user-nao-logado{
            a{
              color: white;
              text-decoration: none;
              font-size: 1.2rem;
              padding: .5rem;
              background-color: transparent;

            }
            a:hover{
              color: #6C63FF;
              text-decoration: underline 3px;
              text-underline-offset: 95%;

          }
          }
          .menu-user-logado{
            display: flex;
            align-items: center;
            z-index: 1 !important;
            
            a{
              color: rgba(0, 0, 0, 1);
              font-size: 1rem;
              font-weight: 400;
              padding: 0;
  
            }
          }
        }
      }      
    }
    a{
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      font-size: 1.5rem;
      font-weight: 500;

      padding: .5rem 1.5rem;
      border-radius: 5px;

    }  
  }
  .navbar-toggler{
    border: 1px solid #6C63FF;

  }
}
</style>
