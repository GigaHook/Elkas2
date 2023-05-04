<template>
	<Head title="Корзина"/>
	<MainLayout :user="user">
		
		<CartBar :entries="products" :title="'Товары'"/>
		<v-row>
			<CartItem v-for="product in products" :key="product.id" :item="product" :type="'products'"/>
		</v-row>
		
		<CartBar :entries="services" :title="'Услуги'"/>
		<v-row>
			<CartItem v-for="service in services" :key="service.id" :item="service" :type="'services'"/>
		</v-row>

	</MainLayout>
</template>

<script>
export default {
	data() {
		return {
			products: this.getProducts(),
			services: this.getServices(),
		}
	},

	methods: {
		getProducts() {
			const products = []
			for (const cartItem of this.$page.props.cart.products) {
				let product = this.$page.props.products.find(product => product.id == cartItem.product_id)
				product.count = cartItem.count
				products.push(product)	//products.push(product)
			}
			return products
		},

		getServices() {
			const services = []
			for (const cartItem of this.$page.props.cart.services) {
				let service = this.$page.props.services.find(service => service.id == cartItem.service_id)
				service.count = cartItem.count
				services.push(service)	//services.push(service)
			}
			return services
		},

	}

}


</script>


<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'
import CartBar from '../Components/CartBar.vue'
import CartItem from '../Components/CartItem.vue'

defineProps({
  user: Object,
})
</script>

<style scoped>


</style>