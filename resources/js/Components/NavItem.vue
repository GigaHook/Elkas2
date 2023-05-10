<template>
  <Link :href="route">
    <v-btn
      class="rounded-0 nav-item" 
      :class="{ 'active': $page.url === route }" 
      :elevation="$page.url === route ? 7 : 0"
    >
      <slot/>
    </v-btn>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  route: String,
})

</script>

<style scoped>
.nav-item:hover {
  background-color: #3F72AF;
  color: #DBE2EF;
}
.nav-item {
  color: #112D4E;
  font-weight: 600;
  width: 100px;
  height: 100%;
  transition: all .1s ease-in-out;
}
.active, .active:hover{
  background-color: #F38307;
  color: white;
  z-index: 2;
}
</style>