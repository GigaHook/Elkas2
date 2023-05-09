<template>
	<Head title="Главная"/>
	<MainLayout :user="user">
		<v-card class="pa-3" elevation="3" color="#f9f7f7">
			<v-img src="storage/assets/main.png" height="200px" class=""/>
			<div class="text-center text-h5 mt-4">
				Надежные кассы для успешного бизнеса
			</div>
			<div class="text-center text-h6 mb-4">
				Продажа и ремонт кассовой техники
			</div>
			<v-carousel
				cycle
				hide-delimiters
				show-arrows="hover"
			>
			  <v-carousel-item
			    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
			    cover
			  />
						
			  <v-carousel-item
			    src="https://cdn.vuetifyjs.com/images/cards/hotel.jpg"
			    cover
			  />
						
			  <v-carousel-item
			    src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
			    cover
			  />
			</v-carousel>
		</v-card>
	</MainLayout>
</template>

<script>
export default {

	data(){

	},

}
</script>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  user: Object,
})
</script>

<style scoped>

</style>