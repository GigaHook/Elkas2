<template>
	<Head title="Корзина"/>
	<MainLayout :user="user">
		<v-slide-y-transition group leave-absolute>

			<CartBar :entries="products" :title="'Товары'" @changePriceVariant="productsPriceVariant = !productsPriceVariant"/>
		
			<v-row v-if="products.length > 0">
				<v-slide-y-transition group leave-absolute>
					<CartItem
						v-for="product in products"
						:key="product.id"
						:item="product"
						:type="'product'"
						:priceVariant="productsPriceVariant"
						@add="cartAddItem"
						@remove="cartRemoveItem"
						@delete="cartDeleteItem"
					/>
				</v-slide-y-transition>
			</v-row>
			
			<v-divider class="my-5"/>

			<CartBar :entries="services" :title="'Услуги'" @changePriceVariant="servicesPriceVariant = !servicesPriceVariant"/>
	
			<v-row>
				<v-slide-y-transition group leave-absolute>
					<CartItem
						v-for="service in services"
						:key="service.id"
						:item="service"
						:type="'service'"
						:priceVariant="servicesPriceVariant"
						@add="cartAddItem"
						@remove="cartRemoveItem"
						@delete="cartDeleteItem"
					/>
				</v-slide-y-transition>
			</v-row>

		</v-slide-y-transition>
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
			services: [],
			productsPriceVariant: true,
			servicesPriceVariant: true,
		}
	},

	mounted() {
		this.products = this.$page.props.cart.products
		this.services = this.$page.props.cart.services
	},

	methods: {	
		defineType(type) {
			return type == 'product' ? this.products : this.services
		},

		cartAddItem(id, type) {
			router.post(`/cart/${type}`, { id: id, }, { preserveState: true, preserveScroll: true })
			this.defineType(type).find(elem => elem.id == id).count++
		},

		cartRemoveItem(id, type) {
			if (this.defineType(type).find(elem => elem.id == id).count == 1) return this.cartDeleteItem(id, type) 
			router.patch(`/cart/${type}/${id}`, { preserveState: true, preserveScroll: true })
			this.defineType(type).find(elem => elem.id == id).count--
		},

		cartDeleteItem(id, type) {
			router.delete(`/cart/${type}/${id}`, { preserveState: true, preserveScroll: true, })
			this.defineType(type).splice(this.defineType(type).findIndex(elem => elem.id == id), 1)
		}

	}
}

</script>

<style scoped>

</style>