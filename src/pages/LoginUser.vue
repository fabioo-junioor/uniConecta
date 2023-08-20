<script>
export default {
  name: "LoginUser",
  data() {
    return {
      form: {
        email: "",
        senha: "",

      },
      show: true

    }
  },
  methods: {
    onSubmit(e) {
      e.preventDefault();
      alert(JSON.stringify(this.form));

    }
  }
}
</script>

<template>
  <div id="loginuser">
    <div class="form">
      <h3>Fazer login</h3>
      <b-form @submit="onSubmit" v-if="show">
        <b-form-group
          id="input-group-1"
          label-for="input-1">
          <b-form-input
            id="input-1"
            v-model="form.email"
            type="email"
            placeholder="Email"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-2" label-for="input-2">
          <b-form-input
            id="input-2"
            v-model="form.senha"
            type="password"
            placeholder="Senha"
            required
          ></b-form-input>
        </b-form-group>

        <b-button type="submit" variant="light">Entrar</b-button>
      </b-form>
    </div>
  </div>
</template>

<style lang="scss" scoped>
#loginuser {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 5rem;
  background-color: blue;
  height: 92%;

  h3{
    color: white;
    padding-bottom: 1rem;

  }

  .form{
    background-color: #232526;
    border-radius: 5px;
    width: 60%;
    padding: 3rem 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    box-shadow: 1px 1px 5px 3px rgba(0, 0, 0, .4);

    form{
      width: 100%;
      display: flex;
      flex-direction: column;

      input{
        margin-bottom: 1.5rem;
        height: 3.5rem;

      }
      button{
        color: #232526;
        font-weight: 600;
        height: 3rem;

      }
    }
  }  
}
</style>