<template>
	<Head title="О нас"/>
	<MainLayout :user="user">

		<v-expansion-panels 
			v-for="order in processedOrders" 
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
					<span class="ms-2 order-number">
						{{ formatOrderId(order.id) }}
					</span>

					<v-chip v-if="order.status == 'В работе'" color="info" variant="elevated" class="text-h6 ms-2">
						{{ order.status }}
					</v-chip>

					<v-chip v-else-if="order.status == 'Завершён'" color="success" variant="elevated" class="text-h6 ms-2">
						{{ order.status }}
					</v-chip>

					<v-chip v-else variant="elevated" class="text-h6 ms-2">
						{{ order.status }}
					</v-chip>

				</v-expansion-panel-title>

				<v-expansion-panel-text
					style="background-color: #f9f7f7"
					class="rounded"
				>
					<v-row class="mb-n4">

						<v-col cols="12" class="d-flex align-center pb-0 mt-1 mb-n2" style="white-space: nowrap;">
							<h2>Информация о заказе</h2>
							<v-divider class="mt-1 ms-2"/>
						</v-col>

						<template v-if="user.admin">

							<v-col cols="3" class="pt-0 pb-3">
								<v-select
					  			prefix="Статус"
					  			:items="['В работе', 'Завершён', 'Отменён']"
									v-model="order.status"
									@update:model-value="updateStatus(order)"
            	    variant="underlined"
            	    density="comfortable"
									hide-details
								/>
							</v-col>

							<v-col cols="3" class="mt-2 pt-0 pb-3">
								Заказчик: <br> {{ getOrderUser(order.user_id).name }}
							</v-col>

							<v-col cols="3" class="mt-2 pt-0 pb-3">
								Телефон: <br> {{ getOrderUser(order.user_id).number }} 
							</v-col>

							<v-col cols="3" class="mt-2 pt-0 pb-3">
								Почта: <br> {{ getOrderUser(order.user_id).email }} 
							</v-col>
							
							<v-divider class="mx-3"/>

						</template>

						<v-col cols="3">
							Всего предметов: {{ countOrderProducts(order.id) + countOrderServices(order.id) }}<br>
							Итого: <v-icon icon="mdi-currency-rub" size="xs" class="mb-1"/>{{ order.price }}
						</v-col>

						<v-col cols="3">
							Товаров: {{ countOrderProducts(order.id) }}<br>
							На стоимость: <v-icon icon="mdi-currency-rub" size="xs" class="mb-1"/>{{ totalOrderProducts(order.id) }}
						</v-col>

						<v-col cols="3">
							Услуг: {{ countOrderServices(order.id) }}<br>
							На стоимость: <v-icon icon="mdi-currency-rub" size="xs" class="mb-1"/>{{ totalOrderServices(order.id) }}
						</v-col>

						<v-col cols="3">
							Дата оформления: <br> {{ getOrderUser(order.user_id).created_at.slice(0, 10) }}
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

					<v-row v-if="getOrderProducts(order.id).length < 1">
						<v-col cols="12" class="text-center text-blue-grey-lighten-1">
							Нет товаров
						</v-col>
					</v-row>

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

					<v-row v-if="getOrderServices(order.id).length < 1">
						<v-col cols="12" class="text-center text-blue-grey-lighten-1">
							Нет услуг
						</v-col>
					</v-row>

					<Button
						v-if="!user.admin && order.status == 'В работе'"
						@click="cancel(order.id)"
						class="mt-1"
					>
						Отменить
					</Button>

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
		processedOrders() {
			let orders = this.orders.reverse()
			if (!this.user.admin) orders.forEach(order => order.expanded = [order.status == 'В работе' ? order.id : null])
			return orders
		},

	},

	methods: {
		getOrderProducts(id) {
			return this.orderProducts.filter(elem => elem.order_id == id)
		},

		getOrderServices(id) {
			return this.orderServices.filter(elem => elem.order_id == id)
		},

		getOrderUser(id) {
			if (this.user.admin) return this.users.find(user => user.id == id)
			else return this.user
		},

		formatOrderId(id) { //bruh
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

		updateStatus(order) {
			router.patch(`/orders/${order.id}`, { status: order.status }, { preserveState: true, preserveScroll: true })
		},

		cancel(id) {
			router.patch(`/orders/cancel/${id}`, {}, { preserveState: true, preserveScroll: true })
		}
		

	},

	mounted() {

	},

}
</script>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import OrderItem from '../Components/OrderItem.vue'
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
	orders: Object,
	orderProducts: Array,
	orderServices: Array,
	users: {
		type: Array,
		default: [],
	}
})
</script>

<style scoped>
@import url('https://fonts.cdnfonts.com/css/major-mono-display-2');
.order-number{
	font-family: 'Major Mono Display', sans-serif;
	font-weight: 900;
	font-size:20px;
	background: #ffffff;
	border-radius: 3px;
	z-index: 1;
	padding: 0 2px 2px 2px;
	outline: 1px solid #bbb;
	font-variant-numeric: tabular-nums;
}
.order-title{
	font-size: 24px
}

</style>