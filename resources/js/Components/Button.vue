<template>
  <v-btn class="btn-var-1">
    <slot/>
  </v-btn>  
</template>

<script setup>

</script>

<style scoped>
  .btn-var-1{
    background-color:#3f72af;
    color: white;
  }
  .btn-var-1:hover{
    transform: translateY(-3px);
    box-shadow: 0px 3px 8px rgba(136, 144, 194, 0.3), 0px 7px 21px rgba(63, 114, 175, 0.5);
  }
  .btn-var-1:active{
    background-color:#112D4E;
    transform: translateY(2px);
    transition: all .05s ease-in-out;
    box-shadow: 0px 2px 6px rgba(136, 144, 194, 0.3), 0px 3px 10px rgba(37, 44, 97, 0.5);
  }
</style>
