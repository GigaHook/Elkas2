<template>
	<v-hover v-slot="{ isHovering, props }">
		<v-card
			:elevation="isHovering ? 10 : 3"
			v-bind="props" 
			@click="router.get(`/${type}s/${item.id}`)"
			class="pa-3 my-3 card" 
			variant="plain"
		>
			<v-row>

				<v-col cols="2">
					<v-sheet class="w-100 img" style="aspect-ratio: 1 / 1;">img</v-sheet>
				</v-col>
	
				<v-col cols="8">
					<h3>{{ item.name }}</h3>
					{{ item.description }}
				</v-col>
	
				<v-col cols="2" class="text-h6 text-end">
					<div class="text-h5">
						<v-icon icon="mdi-currency-rub" size="xs" class="mb-1"/>{{ item.price * item.count }}
					</div>
					<v-icon icon="mdi-currency-rub" size="xs" class="mb-1"/>{{ item.price }} х {{ item.count }}
				</v-col>
	
			</v-row>
		</v-card>
	</v-hover>
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

	methods: {
		
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