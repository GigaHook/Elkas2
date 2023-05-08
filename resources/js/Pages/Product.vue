<template>
  <Head :title="product.name"/>
  <MainLayout 
    :user="user" 
    :product="product"
    :cartUpdate="cartUpdate"
		@cartEndUpdate="cartUpdate = null"
  >
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
      <div class="d-flex">
        <Button @click="cartAddItem">Добавить в корзину</Button>
        <v-fade-transition>
          <v-card 
            v-if="$page.props.cart?.products.find(elem => elem.id == product.id)" 
            class="ms-3 d-flex justify-center align-center"
            width="38" 
            height="38"
            variant="tonal"
            style="transform: translateY(-1px);"
          >
            <v-icon color="#3f72af" icon="mdi-cart-check" size="32" style="transform: translateX(1px);"/>
          </v-card>
        </v-fade-transition>
      </div>
    </v-card>
  </MainLayout>
</template>

<script>
export default {
 data() {
  return {
    cartUpdate: null,
  }
 },

 methods: {
  cartAddItem() {
    router.post('/cart/product', { id: this.product.id, }, { preserveState: true, preserveScroll: true })
    this.cartUpdate = { action: 'add', type: 'product', item: this.product } 
  },
 }
}
</script>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
  product: Object,
})
</script>

<style scoped>

</style>