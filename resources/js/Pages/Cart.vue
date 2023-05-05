<template>
	<Head title="Корзина"/>
	<MainLayout :user="user">
		
		<CartBar :entries="products" :title="'Товары'"/>
		<v-row>
			<CartItem 
				v-for="product in products"
				:key="product.id"
				:item="product"
				:type="'products'"
				@update="getProducts"
				/>
		</v-row>
		
		<CartBar :entries="services" :title="'Услуги'"/>
		<v-row>
			<CartItem v-for="service in services" :key="service.id" :item="service" :type="'services'"/>
		</v-row>

	</MainLayout>
</template>

<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'
import CartBar from '../Components/CartBar.vue'
import CartItem from '../Components/CartItem.vue'

defineProps({
	user: Object,
	cart: Object,
})

</script>

<script>
export default {
	data() {
		return {
			products: [], //TODO РОБИТ ПОСЛЕ ВТОРОЙ ПЕРЕЗАГРУЗКИ
			services: this.getServices(),
		}
	},

	mounted() {
		this.getProducts()
	},

	methods: {
		getProducts() {
			this.products = []
			for (const cartItem of this.cart.products) {
				let product = this.$page.props.products.find(product => product.id == cartItem.product_id)
				product.count = cartItem.count
				this.products.push(product)
			}
		},

		getServices() {
			let services = []
			for (const cartItem of this.cart.services) {
				let service = this.$page.props.services.find(service => service.id == cartItem.service_id)
				service.count = cartItem.count
				services.push(service)	//services.push(service)
			}
			return services
		},

	}

}


</script>



<style scoped>


</style>