<template>
	<Head title="Home" />
	<v-slide-x-transition>
	<MainLayout :user="user">
		<h1>Главная</h1>
		{{ user?.name }}
		<Link href="/dashboard"><v-btn>Дэшборд</v-btn></Link>
	</MainLayout>
</v-slide-x-transition>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
	user: Object,
});


</script>

<style scoped></style>