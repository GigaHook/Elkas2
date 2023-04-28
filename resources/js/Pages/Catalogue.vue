<template>
	<Head title="Home" />
	<MainLayout :user="user" >

		<div class="text-h4 mt-1 ms-2">Каталог</div>
		
		<div class="d-flex pa-1">
			<v-hover v-for="product in products" :key="product.name" v-slot="{ isHovering, props }">
				<v-card :elevation="isHovering ? 10 : 0" v-bind="props" class="w-25 ma-1 px-3 pb-2 pt-1" color="#DBE2EF">
					<div class="text-center">
						<span class="text-h6">{{ product.name }}</span>
						<v-sheet class="w-100" style="aspect-ratio: 1 / 1;">
							{{ product.image }}
						</v-sheet>
						<div class="my-1 text-h6">${{ product.price }}</div>
						<Button class="mb-2 w-100">Добавить в корзину</Button>
						<v-btn variant="text" v-ripple="{ class: `text-info` }">Подробнее</v-btn>
					</div>
				</v-card>
			</v-hover>
		</div>

	</MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '../Components/Button.vue'

defineProps({
	user: Object,
	products: Object,
});


</script>

<style scoped>

</style>