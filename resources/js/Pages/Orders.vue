<template>
	<Head title="О нас"/>
	<MainLayout :user="user">

		<v-expansion-panels 
			v-for="order in reversedOrders" 
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
					Заказ №
					<span class="ms-1 order-number text-weight-thin">
						{{ formatOrderId(order.id) }}
					</span>

					<template> 
						<v-chip v-if="order.status == 'В работе'" color="info" variant="elevated" class="text-h6 ms-2">
							{{ order.status }}
						</v-chip>
						<v-chip v-else-if="order.status == 'Завершён'" color="success" variant="elevated" class="text-h6 ms-2">
							{{ order.status }}
						</v-chip>
						<v-chip v-else variant="elevated" class="text-h6 ms-2">
							{{ order.status }}
						</v-chip>
					</template>
						
				</v-expansion-panel-title>
				
				<v-expansion-panel-text
					style="background-color: #f9f7f7"
					class="rounded"
				>
					<div class="text-h6">
						Изменить статус заказа
						<v-select
					  	chips
					  	prefix="Статус"
							density="compact"
					  	:items="['В работе', 'Завершён', 'Отменён']"
					  	variant="underlined"
							class="w-25"
							v-model="order.status"
						/>

					</div>
					<v-row class="text-h6">
						<v-col cols="4">
							Всего предметов: {{ countOrderProducts(order.id) + countOrderServices(order.id) }}<br>
							Итого: ${{ order.price }}
						</v-col>
						<v-col cols="4">
							Товаров: {{ countOrderProducts(order.id) }}<br>
							На стоимость: ${{ totalOrderProducts(order.id) }}
						</v-col>
						<v-col cols="4">
							Услуг: {{ countOrderServices(order.id) }}<br>
							На стоимость: ${{ totalOrderServices(order.id) }}
						</v-col>
					</v-row>

					<div class="d-flex align-center">
						<h2>Товары</h2>
						<v-divider class="mt-1 ms-2"/>
					</div>

					
					<OrderItem 
						v-for="orderProduct in getOrderProducts(order.id)"
						:key="orderProduct.id"
						:item="orderProduct"
						type="product"
					/>

					<div class="d-flex align-center">
						<h2>Услуги</h2>
						<v-divider class="mt-1 ms-2"/>
					</div>

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

	computed: {
		reversedOrders() {
			return this.orders.reverse()
		}
	},

	methods: {
		getOrderProducts(id) {
			return this.orderProducts.filter(elem => elem.order_id == id)
		},

		getOrderServices(id) {
			return this.orderServices.filter(elem => elem.order_id == id)
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
		},

		countOrderProducts(id) {
			let count = 0
			this.getOrderProducts(id).forEach(elem => count += elem.count)
			return count
		},

		countOrderServices(id) {
			let count = 0
			this.getOrderServices(id).forEach(elem => count += elem.count)
			return count
		},

		totalOrderProducts(id) {
			let total = 0
			this.getOrderProducts(id).forEach(elem => total += elem.count * elem.price)
			return total			
		},

		totalOrderServices(id) {
			let total = 0
			this.getOrderServices(id).forEach(elem => total += elem.count * elem.price)
			return total
		},

		panelClick(event, expanded) {
			if (event.target.tagName != 'button') {
				expanded = []
				console.log(event.target.tagName);
				console.log(expanded);
			}
		},


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