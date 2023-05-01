<template>
	<Head title="Каталог"/>
	<MainLayout :user="user" :page="page">
		<v-row>
			<template v-for="product in $page.props.products" :key="product.id">
				<v-col xl="3" md="4" sm="6" v-if="product.available == true">
					<v-hover v-slot="{ isHovering, props }">
							<v-card
								:elevation="isHovering ? 10 : 3"
								v-bind="props" 
								class="text-center px-3 pt-1 pb-3" 
								color="#f9f7f7"
								@click="open(product.id)"
							>
								<div class="text-h6">{{ product.name }}</div>
								<v-sheet class="my-1 w-100" style="aspect-ratio: 1 / 1;">img</v-sheet>
								<div class="my-1 text-h6">${{ product.price }}</div>
								<Button @click="addToCart(product.id)" class="w-100" :disabled="!user">Добавить в корзину</Button>
							</v-card>
					</v-hover>
				</v-col>
			</template>
		</v-row>
	</MainLayout>
</template>

<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
  page: String,
})

const addToCart = id => router.post('/cart/product', {
	id: id,
}, {
	preserveState: true,
	preserveScroll: true,
})

const open = id => router.get('/products/' + id)

</script>

<style scoped>

</style>