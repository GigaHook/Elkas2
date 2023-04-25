<template>
  <v-btn class="btn-var-1" elevation="6" :type="typeProp ? typeProp : 'button'">
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
    background-color:#3F72AF;
    color: white;
    border-radius: 10px;
  }
</style>
