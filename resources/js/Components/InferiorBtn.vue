<template>
  <v-btn 
    variant="text"
    v-ripple="{ class: `text-info` }"
  >
    <slot />
  </v-btn>
</template>

<script>
export default {
  data() {
    return {

    }
  }
}
</script>

<style scoped>

</style>