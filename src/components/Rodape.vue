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
  display: flex;
  padding: 0;
  justify-content: center;
  align-items: flex-end;
  box-shadow: -1px -1px 10px 2px rgba(0, 0, 0, 0.3);

  h4{
    font-size: 1rem;
    font-weight: 600;
    color: white;

  }
}
</style>
