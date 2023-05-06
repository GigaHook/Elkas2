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
				@update="update"
				/>
		</v-row>
		
		<!--<CartBar :entries="services" :title="'Услуги'"/>
		<v-row>
			<CartItem v-for="service in services" :key="service.id" :item="service" :type="'services'"/>
		</v-row>-->

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
			products: [],
		}
	},

	mounted() {
		this.products = this.$page.props.cart.products
	},

	methods: {	
		update(context) {
			if (context.action == 'delete') {
				this.products.splice(this.products.findIndex(elem => elem.id == context.id), 1)
			}
		}
	}

}

</script>

<style scoped>

</style>