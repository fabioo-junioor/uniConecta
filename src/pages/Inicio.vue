<script setup>
import ListRanking from '../components/ListRanking.vue'

</script>

<template>
  <div id="inicio">
    <div class="inicio-ranking-likes">
      <ListRanking />      
    </div>
    <div class="inicio-ranking-best-sellers">
      <ListRanking />      
    </div>
  </div>
</template>


<style lang="scss" scoped>
#inicio {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 3rem .5rem 0 .5rem;

  .inicio-ranking-likes{
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;

  }
  .inicio-ranking-best-sellers{
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;

  }
}
</style>
