<script>
export default {
  name: "Rodape",
  data() {
    return {}

  }
};
</script>

<template>
  <div id="rodape">
    <h4>Copyright © 2023 UniConecta</h4>
  </div>
</template>


<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap');

#rodape {
  font-family: 'Work Sans', sans-serif;
  background-color: #6C63FF;
  min-height: 3rem;
  width: 100%;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: flex-end;
  box-shadow: -1px -1px 10px 2px rgba(0, 0, 0, 0.3);

  h4{
    padding: .2rem;
    font-size: .9rem;
    color: white;

  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 992px) {
}
@media only screen and (max-width: 720px) {
  #rodape {
    min-height: 2.5rem;
    
    h4{
      font-size: .8rem;
      padding: 0;

    }
  }
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>
