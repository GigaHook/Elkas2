<template>
	<Head title="Home" />
	<MainLayout :user="user" >
		<h1>Каталог</h1>
		{{ user?.name }}
		<Link href="/dashboard"><v-btn>Дэшборд</v-btn></Link>


	</MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
	user: Object,
});


</script>

<style scoped>

</style>