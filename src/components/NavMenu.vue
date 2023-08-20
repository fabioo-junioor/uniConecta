<script>
export default{
  data(){
    return{
      logado: false

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
          <b-nav-item><router-link to="/sobre">Sobre</router-link></b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav v-if="!logado">
          <b-nav-item href="#"><router-link to="/loginuser">Login</router-link></b-nav-item>
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
  height: 8%;

  .navbar{
    background: #232526;
    background: -webkit-linear-gradient(to right, #414345, #232526);
    background: linear-gradient(to right, #414345, #232526);

    padding: 1rem;

    #nav-collapse{
      display: flex;
      justify-content: space-between;

      a{
        color: #232526;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: 500;
        background-color: rgba(255, 255, 255, 1);
        padding: .5rem 1.5rem;
        border-radius: 5px;

      }
      a:hover{
        background-color: rgba(255, 255, 255, .8);

      }
    }
    a{
      color: white;
      text-decoration: none;
      font-size: 1.5rem;
      padding: .5rem;

    }
  
  }
}
</style>
