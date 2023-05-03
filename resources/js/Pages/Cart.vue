<template>
	<Head title="Каталог"/>
	<MainLayout :user="user">
		<v-row>
			<v-col cols="12">
				<v-card
					elevation="3"
					class="pa-3 d-flex"
					color="#f9f7f7"
				>
					<div class="text-h4 w-100">
						Корзина
					</div>
					<div class="w-100">
						<div class="text-h6 ">
							Товары 
						</div>
						Всего товаров: {{ $page.props.cart.products.length }}
					</div>
					<div class="w-100">
						<div class="text-h6 ">
							Услуги
						</div>
						
					</div>
				</v-card>
			</v-col>
		</v-row>
		<v-row>
			<template v-for="product in $page.props.products" :key="product.id">
				<v-col xl="3" md="4" sm="6" v-if="product.available == true">
					<v-hover v-slot="{ isHovering, props }">
						<v-card
							:elevation="isHovering ? 10 : 3"
							v-bind="props" 
							@click="router.get('/products/' + product.id)"
							class="text-center px-3 pt-1 pb-3 card" 
							variant="plain"
						>
							<div class="text-h6">{{ product.name }}</div>
							<v-sheet class="my-1 w-100 img" style="aspect-ratio: 1 / 1;">img</v-sheet>
							<div class="my-1 text-h6">${{ product.price }}</div>
						</v-card>
					</v-hover>
				</v-col>
			</template>
		</v-row>
		<v-row>
			<template v-for="product in $page.props.products" :key="product.id">
				<v-col xl="3" md="4" sm="6" v-if="product.available == true">
					<v-hover v-slot="{ isHovering, props }">
						<v-card
							:elevation="isHovering ? 10 : 3"
							v-bind="props" 
							@click="router.get('/products/' + product.id)"
							class="text-center px-3 pt-1 pb-3 card" 
							variant="plain"
						>
							<div class="text-h6">{{ product.name }}</div>
							<v-sheet class="my-1 w-100 img" style="aspect-ratio: 1 / 1;">img</v-sheet>
							<div class="my-1 text-h6">${{ product.price }}</div>
						</v-card>
					</v-hover>
				</v-col>
			</template>
		</v-row>
	</MainLayout>
</template>

<script>
export default {
	data() {
		return {
			products: this.getProducts(),
		}
	},

	methods: {
		getProducts() {
			const products = []
			//for (const cartItem of this.$page.props.cart.products) {
			//	let product = this.$page.props.products.filter(product => product.id = cartItem.product_id)
			//	products.push(product)
			//	alert(products)
			//	//product.count = cartItem.count
			//	//products.push(product)
			//}
			
		},
	}

}


</script>


<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
})
</script>

<style scoped>
.card{
	background-color: #f9f7f7;
	opacity: 1;
}

</style>