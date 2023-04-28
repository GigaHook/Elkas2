<template>
	<Head title="Home" />
	<v-slide-x-transition>
	<MainLayout :user="user">
		<h1>Главная</h1>
		{{ user?.name }}
		<Link href="/dashboard"><v-btn>Дэшборд</v-btn></Link> <br>
		<v-btn @click="asd++">+</v-btn>
		{{ asd }}
	</MainLayout>
</v-slide-x-transition>
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
});

</script>

<style scoped></style>