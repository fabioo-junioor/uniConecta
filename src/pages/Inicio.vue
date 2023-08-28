<script setup>
</script>

<template>
  <div id="inicio">
    <div class="inicio-img-draw">
      <img src="../assets/draw/sharing_knowledge.svg" />
    </div>
    <div class="inicio-ranking">
      <p>
        There are many variations of passages of Lorem Ipsum available, but the
        majority have suffered alteration in some form, by injected humour, or
        randomised words which don't look even slightly believable. If you are
        going to use a passage of Lorem Ipsum, you need to be sure there isn't
        anything embarrassing hidden in the middle of text. All the Lorem Ipsum
        generators on the Internet tend to repeat predefined chunks as
        necessary, making this the first true generator on the Internet. It uses
        a dictionary of over 200 Latin words, combined with a handful of model
        sentence structures, to generate Lorem Ipsum which looks reasonable. The
        generated Lorem Ipsum is therefore always free from repetition, injected
        humour, or non-characteristic words etc.
      </p>
    </div>
  </div>
</template>


<style lang="scss" scoped>
#inicio {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 3rem .5rem 0 .5rem;

  .inicio-img-draw{
    width: 60%;
    display: flex;
    align-items: center;
    justify-content: center;

  }
  .inicio-ranking{
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;

    p{
      text-align: justify;
      border: 2px solid #6C63FF;
      border-radius: 5px;
      width: 70%;
      padding: 1rem;

    }

  }

}
</style>
