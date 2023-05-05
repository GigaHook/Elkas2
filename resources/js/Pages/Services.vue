<template>
	<Head title="Каталог"/>
	<MainLayout :user="user">
		<v-row>
			<template v-for="service in $page.props.services" :key="service.id">
				<v-col xl="3" md="4" sm="6" v-if="service.available == true">
					<v-hover v-slot="{ isHovering, props }">
						<v-card
							:elevation="isHovering ? 10 : 3"
							v-bind="props" 
							@click="open(service.id)"
							class="text-center px-3 pt-1 pb-3 card" 
							variant="plain"
						>
							<div class="text-h6">{{ service.name }}</div>
							<v-sheet class="my-1 w-100 img" style="aspect-ratio: 1 / 1;">img</v-sheet>
							<div class="text-h6">${{ service.price }}</div>
							<v-divider class="mb-3"/>
							<Button 
                @click.stop="addToCart(service.id)"
                class="w-100 buy-btn" 
                :disabled="!user"
              >
                Добавить в корзину
              </Button>
						</v-card>
					</v-hover>
				</v-col>
			</template>
		</v-row>
	</MainLayout>
</template>

<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
  page: String,
})

const addToCart = id => router.post('/cart/service', {
	id: id,
}, {
	preserveState: true,
	preserveScroll: true,
})

const open = id => router.get('/services/' + id)

</script>

<style scoped>
.card{
	background-color: #f9f7f7;
	opacity: 1;
}

</style>