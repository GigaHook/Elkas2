<template>
	<Head title="О нас"/>
	<MainLayout :user="user">
		<v-card class="pa-3" elevation="3" color="#f9f7f7">
			{{ orders }}
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
	orders: Object,
})
</script>

<style scoped>

</style>