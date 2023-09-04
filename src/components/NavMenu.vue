<script>
import ModalUser from './ModalUser.vue'

export default{
  name: 'NavMenu',
  components: {ModalUser},
  data(){
    return{
      logado: false

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
            <b-nav-item><router-link to="/sobre">SOBRE</router-link></b-nav-item>
            <b-nav-item><router-link to="/cursos">CURSOS</router-link></b-nav-item>
          </div>
          <div class="menuUser">
            <div v-if="!logado">
              <b-nav-item>
                <a v-b-modal.modal-scrollable-user-lg>
                  <ModalUser />
                    LOGIN
                </a>
              </b-nav-item>
            </div>
            <div v-else>
              <b-nav-item-dropdown
                text="MENU"
                toggle-class="nav-link-custom"
                right >
                <b-dropdown-item>PERFIL</b-dropdown-item>
                <b-dropdown-item>MEUS CURSOS</b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item>SAIR</b-dropdown-item>
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
  .navbar{
    background: #232526;
    box-shadow: 0px 2px 5px 3px rgba(0, 0, 0, 0.5);
    background: -webkit-linear-gradient(to right, #414345, #232526);
    background: linear-gradient(to right, #414345, #232526);

    padding: .5rem 0;

    .navbar-brand{
      border: 1px solid #6C63FF;
      border-radius: 5px;

    }
    .navbar-brand:hover{
      background-color: #6b63ff23;
    }

    #nav-collapse{
      width: 100%;
      display: flex;
      justify-content: space-between;

      .navbar-nav{
        width: 100%;
        display: flex;
        flex-direction: row;
        
        .menuStatic{
          display: flex;
          flex-direction: row;
          width: 80%;

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
        .menuUser{
          width: 20%;
          display: flex;
          justify-content: center;

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
