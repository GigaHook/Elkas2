<template>
	<Head title="О нас"/>
	<MainLayout :user="user">
		
	</MainLayout>
</template>

<script>
export default {
	data(){
		return {

		}
	},

}
</script>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import OrderItem from '../Components/OrderItem.vue'

defineProps({
  user: Object,
	orders: Object,
})
</script>

<style scoped>

</style>