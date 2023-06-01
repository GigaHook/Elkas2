<template>
	<Head title="Корзина"/>
	<MainLayout
		:user="user"
		:cartUpdate="cartUpdate"
		:cartData="cartData"
		@cartEndUpdate="cartUpdate = null"
		@cartClear="cartClear"
	>
		<v-slide-y-transition group leave-absolute>
			<CartBar
				:entries="products" 
				:title="'Товары'" 
				:type="'product'"
				@changePriceVariant="productsPriceVariant = !productsPriceVariant"
				@clear="cartClearItems"
			/>
			<v-row>
				<v-slide-y-transition group leave-absolute v-if="products.length > 0">
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

			<CartBar 
				:entries="services" 
				:title="'Услуги'" 
				:type="'service'"
				@changePriceVariant="servicesPriceVariant = !servicesPriceVariant"
				@clear="cartClearItems"
			/>
	
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
import { Head, router } from '@inertiajs/vue3'
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
			cartUpdate: null,
		}
	},

	computed: {
		cartData() {
			return {
				totalItems: this.totalItems(this.products) + this.totalItems(this.services),
				totalPrice: this.totalPrice(this.products) + this.totalPrice(this.services)
			}
		}
	},

	mounted() {
		this.products = this.$page.props.cart.products
		this.services = this.$page.props.cart.services
		this.$root.cartBadge = false
	},

	methods: {	
		totalPrice(items) {
      let total = 0
      items.forEach(item => {
        total += item.price * item.count
      })
      return total
    },

    totalItems(items) {
      let total = 0
      items.forEach(item => {
        total += item.count
      })
      return total
    },

		get(type) { //GET PRODUCTS/SERVICES
			return type == 'product' ? this.products : this.services
		},

		cartAddItem(id, type) { //ADD
			router.post(`/cart/${type}`, { id: id, }, { preserveState: true, preserveScroll: true })
			this.get(type).find(elem => elem.id == id).count++
		},

		cartRemoveItem(id, type) { //REMOVE
			if (this.get(type).find(elem => elem.id == id).count == 1) return this.cartDeleteItem(id, type) 
			router.patch(`/cart/${type}/${id}`, { preserveState: true, preserveScroll: true })
			this.get(type).find(elem => elem.id == id).count--
		},

		cartDeleteItem(id, type) { //DELETE
			router.delete(`/cart/${type}/${id}`, { preserveState: true, preserveScroll: true, })
			this.sendCartUpdate('delete', type, this.get(type).find(elem => elem.id == id))
			this.get(type).splice(this.get(type).findIndex(elem => elem.id == id), 1)
		},

		cartClearItems(type) { //CLEAR
			router.delete(`cart/${type}`)
			this.sendCartUpdate('clear', type)
			this.get(type).splice(0, this.get(type).length)
		},

		sendCartUpdate(action, type, item=null) {
			this.cartUpdate = {
				action: action,
				type: type,
				item: item,
			} 
		},

		cartClear() {
			this.cartClearItems('product')
			this.cartClearItems('service')
		},

	}
}

</script>

<style scoped>

</style>