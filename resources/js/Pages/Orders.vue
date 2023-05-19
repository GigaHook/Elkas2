<template>
	<Head title="О нас"/>
	<MainLayout :user="user">

		<v-expansion-panels 
			v-for="order in orders" 
			:key="order.id"
			v-model="order.expanded"
			class="mb-3"
		>
			<v-expansion-panel
				elevation="3"
				class="mb-2 rounded"
				color="#f9f7f7"
				:value="order.id"
			>
				<v-expansion-panel-title color="#f9f7f7" class="order-title">
					Заказ №<span class="ms-1 order-number text-weight-thin">
						{{ formatOrderId(order.id) }}
					</span>
					
				</v-expansion-panel-title>
				
				<v-expansion-panel-text
					style="background-color: #f9f7f7"
					class="rounded"
				>
					<h2>Продукты</h2>
					<OrderItem 
						v-for="orderProduct in getOrderProducts(order.id)"
						:key="orderProduct.id"
						:item="orderProduct"
						type="product"
					/>
					<v-divider class="mt-7 mb-4"/>
					<h2>Услуги</h2>
					<OrderItem 
						v-for="orderService in getOrderServices(order.id)"
						:key="orderService.id"
						:item="orderService"
						type="service"
					/>
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

		getOrderServices(orderId) {
			return this.orderServices.filter(elem => elem.order_id == orderId)
		},

		formatOrderId(id) {
			let result = ''
			switch (id.toString().length) {
				case 1:
					result = `0000000${id}`
					break;
				case 2:
					result = `000000${id}`
					break;
				case 3:
					result = `00000${id}`
					break;
				case 4:
					result = `0000${id}`
					break;
				case 5:
					result = `000${id}`
					break;
				case 6:
					result = `00${id}`
					break;
				case 7:
					result = `0${id}`
					break;
				case 8:
					result = id
					break;
			
				default:
					result = id
					break;
			}
			return result
		}
	},

	mounted() {

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
	orderServices: Array,
})
</script>

<style scoped>
@import url('https://fonts.cdnfonts.com/css/bender');
.order-number{
	font-family: 'Bender', sans-serif;
	font-size:24px;
	font-weight:100;
	background: #ffffff;
	border-radius: 3px;
	z-index: 1;
	padding: 0 3px 0 2px;
	outline: 1px solid #bbb;
}
.order-title{
	font-size: 24px
}
</style>