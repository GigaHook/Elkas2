<template>
	<MainLayout :user="user" :page="page" :title="title">
		<v-card class="pa-2" elevation="3" color="#f9f7f7">
			<h1>Главная</h1>
			{{ user?.name }}
			<Link href="/dashboard"><v-btn>Дэшборд</v-btn></Link> <br>
			<v-btn @click="asd++">+</v-btn>
			{{ asd }}
		</v-card>
	</MainLayout>
</template>

<script>
export default {

	data: () => ({
		asd: 0,
	}),

}
</script>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  user: Object,
  page: String,
  title: String,
})
</script>

<style scoped>

</style>