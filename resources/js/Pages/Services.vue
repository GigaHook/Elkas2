<template>
	<MainLayout :user="user" :page="page" :title="title">
		<v-row>
			<template v-for="service in $page.props.services" :key="service.id">
				<v-col xl="3" md="4" sm="6" v-if="service.available == true">
					<v-hover v-slot="{ isHovering, props }">
						<v-card
							:elevation="isHovering ? 10 : 3"
							v-bind="props" 
							class="text-center px-3 pt-1 pb-3" 
							color="#f9f7f7"
						>
							<div class="text-h6">{{ service.name }}</div>
							<v-sheet class="my-1 w-100" style="aspect-ratio: 1 / 1;">img</v-sheet>
							<div class="my-1 text-h6">${{ service.price }}</div>
							<Button class="w-100">Добавить в корзину</Button>
						</v-card>
					</v-hover>
				</v-col>
			</template>
		</v-row>
	</MainLayout>
</template>


<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
  page: String,
  title: String,
})

</script>

<style scoped>

</style>