<template>
  <MainLayout :user="user" :page="page" :title="title">
    <v-card class="pa-3" color="#f9f7f7" elevation="3">
      <div class="text-h5 mb-2">{{ product.name }}</div>
      <v-row>
        <v-col cols="6">
          <v-sheet class="w-100 text-center" style="aspect-ratio: 1 / 1;">
            img
          </v-sheet>
        </v-col>

        <v-col cols="6">
          <div class="text-h6">Описание</div>
          {{ product.description }}
        </v-col>
      </v-row>
      <div class="my-2 text-h6">Цена: ${{ product.price }}</div>
      <Button>Добавить в корзину</Button>
    </v-card>
  </MainLayout>
</template>

<script>
  export default {
   data() {

   } 
  }
</script>

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
  page: String,
  title: String,
  product: Object,
})
</script>

<style scoped>

</style>