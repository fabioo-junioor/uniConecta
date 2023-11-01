<script>

export default {
  name: "Alerta",
  data() {
    return {
        tempo: 4,
        dismissCountDown: 0

    }
  },
  props: {
    mensagem: String,
    tipo: String

  },
  methods: {
    countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown

    },
    showAlert() {
      this.dismissCountDown = this.tempo

    }
  },
  created(){
    this.showAlert()

  }
};
</script>
<template>
  <div id="alerta">
    <b-alert
      :show="dismissCountDown"
      dismiss-label
      fade
      :variant=tipo
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged">
      <div class="mensagem-alerta">
        <i v-if="tipo == 'danger'" class='bx bx-error'></i>
        <i v-if="(tipo == 'info')||(tipo == 'warning')" class='bx bx-info-circle'></i>
        <i v-if="tipo == 'success'" class='bx bx-check-circle'></i>
        <p>{{ mensagem }}</p>
      </div>
      <b-progress
        :variant=tipo
        :max="tempo"
        :value="dismissCountDown"
        height="4px"
      ></b-progress>
    </b-alert>
  </div>
</template>

<style lang="scss" scoped>
@import url("https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css");
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#alerta{
  position: absolute;
  
  .alert{
    width: 30%;
    position: fixed;
    top: 5%;
    right: 1%;
    z-index: 2000;

    .mensagem-alerta{
      padding: 0;
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: flex-start;

      i{
        padding: .3rem;
        font-size: 1.2rem;
        color: black;

      }
      p{
        font-family: 'Work Sans', sans-serif;
        font-size: .9rem;
        color: black;
        padding: .3rem 0;

      }
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 990px) {
  #alerta{
    .alert{
        width: 40%;

    }
  }
}
@media only screen and (max-width: 720px) {
}
@media only screen and (max-width: 481px) {
  #alerta{
    .alert{
        width: 80%;

    }
  }
}
@media only screen and (max-width: 360px) {
  #alerta{
    .alert{
        width: 90%;

    }
  }
}
</style>