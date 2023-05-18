<template>
	<Head title="О нас"/>
	<MainLayout :user="user">

		<v-expansion-panels 
			v-for="order in orders" 
			:key="order.id"
		>
			<v-expansion-panel 
				:title="`Заказ №${order.id}`"
				elevation="3"
				class="ma-1 rounded"
				color="#f9f7f7"
			>
				<v-expansion-panel-text
					style="background-color: #f9f7f7"
					class="rounded"
				>
					<v-row>
						<OrderItem 
							v-for="orderProduct in getOrderProducts(order.id)"
							:key="orderProduct.id"
							:item="orderProduct"
							type="product"
						/>
					</v-row>
				</v-expansion-panel-text>
			</v-expansion-panel>
		</v-expansion-panels>

	</MainLayout>
</template>

<script>
export default {
	data(){
		return {

		}
	},

	methods: {
		getOrderProducts(orderId) {
			return this.orderProducts.filter(elem => elem.order_id == orderId)
		},
	},

}
</script>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import OrderItem from '../Components/OrderItem.vue'

defineProps({
  user: Object,
	orders: Object,
	orderProducts: Array,
})
</script>

<style scoped>

</style>