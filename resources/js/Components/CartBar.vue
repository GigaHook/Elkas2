<template>
  <v-row>
		<v-col cols="12">
      <v-toolbar
        elevation="3"
				color="#f9f7f7"
        rounded
       >
        <v-toolbar-title>
          <div class="d-flex">
            <div class="text-h5 my-auto">{{ title }}</div>
            <v-divider class="mx-4 my-1" vertical/>
            <div>
              <div>Всего: <b>{{ totalItems() }}</b></div>
              <div>На общую стоимость: <b><Rub/>{{ totalPrice() }}</b></div>
            </div>
          </div>
        </v-toolbar-title>
        <v-toolbar-items>
          <v-btn @click="changePriceVariant">
            <v-icon :icon="priceVariant ? 'mdi-tag-multiple' : 'mdi-tag-multiple-outline'" size="30"/>
          </v-btn>
          <v-btn @click="$emit('clear', type)">
            <v-icon icon="mdi-delete-forever-outline" size="30"/>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
		</v-col>
	</v-row>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Rub from '../Components/Rub.vue'
</script>

<script>
export default {
  props: {
    entries: Object,
    title: String,
    type: String,
  },

  data() {
    return {
      priceVariant: false
    }
  },

  methods: {
    changePriceVariant() {
      this.priceVariant = !this.priceVariant
      this.$emit('changePriceVariant')
    },

    totalPrice() {
      let total = 0
      this.entries.forEach(item => {
        total += item.price * item.count
      })
      return total
    },

    totalItems() {
      let total = 0
      this.entries.forEach(item => {
        total += item.count
      })
      return total
    }
    
  }
}
</script>

<style scoped>

</style>