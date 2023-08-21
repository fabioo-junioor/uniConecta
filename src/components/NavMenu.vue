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
          <b-nav-item><router-link to="/sobre">SOBRE</router-link></b-nav-item>
          <b-nav-item><router-link to="/cursos">CURSOS</router-link></b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav v-if="!logado">
          <b-nav-item>
            <a v-b-modal.modal-scrollable-user-lg>
              <ModalUser />
              LOGIN
            </a>
          </b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav v-else>
          <b-nav-item href="#">Logado</b-nav-item>
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

    padding: 1rem;

    .navbar-brand{
      border: 2px solid rgba(255, 255, 255, 0.7);
      border-radius: 5px;

    }
    .navbar-brand:hover{
      background-color: rgba(255, 255, 255, 0.1);
    }

    #nav-collapse{
      display: flex;
      justify-content: space-between;
      padding: 0 1rem;

      a{
        color: white;
        text-decoration: none;
        font-size: 1.2rem;
        padding: .5rem;
        background-color: transparent;
        

      }
      a:hover{
        text-decoration: underline;

      }
    }
    a{
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      font-size: 1.5rem;
      font-weight: 500;

      padding: .5rem 1.5rem;
      border-radius: 5px;

    }
  
  }
}
</style>
