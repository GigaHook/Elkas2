<template>
	<Head title="Главная"/>
	<MainLayout :user="user">
		<v-card class="pa-3" elevation="3" color="#f9f7f7">
			<v-carousel
				cycle
				hide-delimiters
				show-arrows="hover"
				height="60vh"
			>
				<v-carousel-item
				  :src="'../storage/assets/slide-1.png'"
				  cover
				/>
				<v-carousel-item
					:src="'../storage/assets/slide-2.png'"
					cover
				/>
				<v-carousel-item
					:src="'../storage/assets/slide-3.png'"
					cover
				/>
			</v-carousel>
			<div class="text-center text-h3 mt-8">
				Надежные кассы для успешного бизнеса
			</div>
			<div class="text-center text-h4 mb-8 mt-4">
				Продажа и ремонт кассовой техники
			</div>
			<v-row class="text-h6">
				<v-col cols="5">
					<img :src="'../storage/assets/main-2.jpg'" class="w-100">
				</v-col>
				<v-col cols="7">
					Компания "Элкас" занимается продажей и ремонтом кассового оборудования и другого торгового оборудования уже более 10 лет. Наша компания предоставляет нашим клиентам наивысший уровень сервиса, качество работы и конечный результат. Мы имеем длительный опыт работы в сфере торгового оборудования и знаем, какое оборудование соответствует вашим потребностям и требованиям.
				</v-col>
				<v-col cols="7">
					Мы предлагаем широкий ассортимент торгового оборудования, включая кассовые аппараты, сканеры, весы и POS-терминалы, по доступным ценам. Мы также предоставляем ремонт и обслуживание оборудования, установку софта и другие сервисные услуги. Наша команда высококвалифицированных специалистов готова помочь вам в любое время.
				</v-col>
				<v-col cols="5">
					<img :src="'../storage/assets/main-1.jpg'" class="w-100">
				</v-col>
			</v-row>
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