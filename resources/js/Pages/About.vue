<template>
	<Head title="О нас"/>
	<MainLayout :user="user">
		<v-card class="pa-3" elevation="3" color="#f9f7f7">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus quidem sit dolores assumenda eius temporibus iste suscipit, cumque, vel nisi odit ab nemo accusamus fugiat ipsa. Laboriosam aliquid quaerat corporis?
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