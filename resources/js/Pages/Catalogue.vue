<template>
	<MainLayout :user="user" :page="page" :title="title">
		<v-row>
			<v-col xl="3" md="4" sm="6" v-for="product in $page.props.products" :key="product.name">
				<v-hover v-slot="{ isHovering, props }">
					<v-card
						:elevation="isHovering ? 10 : 3"
						v-bind="props" 
						class="text-center px-3 pt-2 pb-1" 
						:class="{ 'z-plus': isHovering }" 
						color="#f9f7f7"
					>
						<span class="text-h6">{{ product.name }}</span>
						<v-sheet class="w-100" style="aspect-ratio: 1 / 1;">img</v-sheet>
						<div class="my-1 text-h6">${{ product.price }}</div>
						<Button class="mb-2 w-100">Добавить в корзину</Button>
					</v-card>
				</v-hover>
			</v-col>
		</v-row>
	</MainLayout>
</template>


<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
  page: String,
  title: String,
})
</script>

<style scoped>
.z-plus{
	z-index: 1;
}
</style>