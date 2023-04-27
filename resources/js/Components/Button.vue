<template>
    <v-btn class="btn-var-1" :type="typeProp ?? 'button'">
      <slot/>
    </v-btn>  
</template>

<script setup>
defineProps({
  typeProp: String
})
</script>

<style scoped>
  .btn-var-1{
    background-color:#3f72af;
    color: white;
    border-radius: 10px;
  }
  .btn-var-1:hover{
    background-color:#112D4E;
    transform: translateY(-3px);
    box-shadow: 0px 3px 8px rgba(136, 144, 194, 0.3), 0px 7px 21px rgba(37, 44, 97, 0.5);
  }
</style>
