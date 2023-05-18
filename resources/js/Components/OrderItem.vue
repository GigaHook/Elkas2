<template>
	<v-col xl="3" md="4" sm="6">
		<v-hover v-slot="{ isHovering, props }">
			<v-card
				:elevation="isHovering ? 10 : 3"
				v-bind="props" 
				@click="router.get(`/${type}s/${item.id}`)"
				class="text-center px-3 pt-1 pb-3 card" 
				variant="plain"
			>
				<div class="text-h6">{{ item.name }}</div>
				<v-sheet class="my-1 w-100 img" style="aspect-ratio: 1 / 1;">img</v-sheet>
				<div class="my-3 text-h6">
					${{ item.count * item.price }}, ${{ item.price }} x {{ item.count }}
				</div>
			</v-card>
		</v-hover>
	</v-col>
</template>

<script>
export default {
  props: {
    item: Object,
		type: String,
  },

  data() {
		return {
			
    }
  },
}
</script>

<script setup>
import { router } from '@inertiajs/vue3';
</script>

<style scoped>
.card{
	background-color: #f9f7f7;
	opacity: 1;
}
</style>